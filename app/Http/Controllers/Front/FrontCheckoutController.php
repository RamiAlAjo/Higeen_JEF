<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FrontCheckoutController extends Controller
{
    public function index()
{
    // Ensure the user is logged in before accessing checkout
    if (!Auth::guard('client')->check()) {
        return redirect()->route('client.login')->with('error', __('cart.please_login_to_checkout'));
    }

    $cart = $this->getOrCreateCart();
    $cartItems = $cart->items()->with('product')->get();

    $items = $cartItems->map(function ($cartItem) {
        $product = $cartItem->product;
        $name = app()->getLocale() === 'ar' ? $product->product_name_ar : $product->product_name_en;
        return [
            'id' => $cartItem->id,
            'name' => $name ?? 'Unnamed Product',
            'price' => $cartItem->price_at_time ?? $product->price ?? 0,
            'qty' => $cartItem->quantity,
            'stock' => $product->quantity,
            'image' => $product->main_image_url ?? asset('Uploads/default.jpg'),
            'line_total' => number_format($cartItem->price_at_time * $cartItem->quantity, 3),
        ];
    })->toArray();

    if (empty($items)) {
        return redirect()->route('cart.index')->with('error', __('cart.empty'));
    }

    return view('front.checkout', compact('items'));
}


 public function store(Request $request)
{
    // Check if the user is authenticated
    if (!Auth::guard('client')->check()) {
        return redirect()->route('client.login')->with('error', __('cart.please_login_to_order'));
    }

    $validated = $request->validate([
        'full_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone_number' => 'required|string|max:20',
        'shipping_area' => 'required|in:Amman,Salt,Irbid',
        'shipping_address' => 'required|string',
        'note' => 'nullable|string',
        'payment_method' => 'required|in:cod,card,paypal,stripe,bank_transfer,apple_pay,google_pay,wallet,klarna,cash',
    ]);

        $cart = $this->getOrCreateCart();
        $cartItems = $cart->items()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', __('cart.empty'));
        }

        foreach ($cartItems as $item) {
            if (!$item->product || $item->quantity > $item->product->quantity) {
                return back()->withErrors([
                    'cart' => __('cart.only_stock_left', [
                        'stock' => $item->product->quantity,
                        'name' => $item->product->product_name_en ?? 'Unnamed Product'
                    ])
                ]);
            }
        }

        $subtotalRaw = $cartItems->sum(fn($item) => ($item->price_at_time ?? $item->product->price) * $item->quantity);
        $tax = $subtotalRaw * 0.16;

        $shippingAreas = [
            'Amman' => 2.00,
            'Salt' => 3.00,
            'Irbid' => 4.00,
        ];

        $shipping_cost = $shippingAreas[$validated['shipping_area']] ?? 0.00;
        $discount = 0.00;
        $total = $subtotalRaw + $tax + $shipping_cost - $discount;

        $order = Order::create([
            'cart_id' => $cart->id,
            'client_id' => Auth::guard('client')->check() ? Auth::guard('client')->id() : null,
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'shipping_area' => $validated['shipping_area'],
            'shipping_address' => $validated['shipping_address'],
            'subtotal' => $subtotalRaw,
            'shipping_cost' => $shipping_cost,
            'discount' => $discount,
            'discount_percent' => null,
            'discount_type' => null,
            'total' => $total,
            'payment_method' => $validated['payment_method'],
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'delivery_status' => 'not_started',
        ]);

        // Save cart items to order_items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'product_name_en' => $item->product->product_name_en ?? 'Unnamed Product',
                'product_name_ar' => $item->product->product_name_ar ?? 'منتج غير مسمى',
                'price' => $item->price_at_time ?? $item->product->price ?? 0,
                'quantity' => $item->quantity,
                'total' => ($item->price_at_time ?? $item->product->price ?? 0) * $item->quantity,
            ]);
        }

        // Store order_id and shipping_area in session
        session(['order_id' => $order->id, 'shipping_area' => $validated['shipping_area']]);

        // Log order creation
        \Illuminate\Support\Facades\Log::info('Order created', [
            'order_id' => $order->id,
            'cart_id' => $cart->id,
            'client_id' => Auth::guard('client')->check() ? Auth::guard('client')->id() : null,
            'guest_token' => session('guest_token'),
        ]);

        // Optionally keep cart
        // $cart->items()->delete();
        // $cart->delete();
        // if (!Auth::guard('client')->check()) {
        //     session()->forget('guest_token');
        // }

        return redirect()->route('confirmation.index')->with('success', __('cart.order_placed'));
    }

    public function confirmation()
    {
        $query = Order::with(['items.product']);

        $orderId = session('order_id');
        if ($orderId) {
            $query->where('id', $orderId);
        } elseif (Auth::guard('client')->check()) {
            $query->where('client_id', Auth::guard('client')->id());
        } else {
            $guestToken = session('guest_token');
            if ($guestToken) {
                $query->whereHas('cart', function ($q) use ($guestToken) {
                    $q->where('guest_token', $guestToken);
                });
            }
        }

        $order = $query->latest()->first();

        if (!$order) {
            \Illuminate\Support\Facades\Log::warning('No order found', [
                'order_id' => $orderId,
                'client_id' => Auth::guard('client')->check() ? Auth::guard('client')->id() : null,
                'guest_token' => session('guest_token'),
            ]);
            return view('front.confirmation', ['order' => null, 'items' => [], 'orderNumber' => '']);
        }

        $items = $order->items->map(function ($orderItem) {
            $product = $orderItem->product;
            $name = app()->getLocale() === 'ar' ? $orderItem->product_name_ar : $orderItem->product_name_en;
            return [
                'id' => $orderItem->id,
                'name' => $name ?? 'Unnamed Product',
                'price' => $orderItem->price ?? 0,
                'qty' => $orderItem->quantity,
                'stock' => $product->quantity ?? 0,
                'image' => $product->main_image_url ?? asset('Uploads/default.jpg'),
                'line_total' => number_format($orderItem->total, 3),
            ];
        })->toArray();

        $orderNumber = 'ORD-' . $order->id . '-' . $order->created_at->timestamp;

        session()->forget('order_id');

        return view('front.confirmation', compact('order', 'items', 'orderNumber'));
    }

    protected function getOrCreateCart()
    {
        if (Auth::guard('client')->check()) {
            $cart = Cart::firstOrCreate(
                ['client_id' => Auth::guard('client')->id()],
                ['guest_token' => null]
            );
        } else {
            $guestToken = session('guest_token', Str::random(32));
            session(['guest_token' => $guestToken]);
            $cart = Cart::firstOrCreate(
                ['guest_token' => $guestToken],
                ['client_id' => null]
            );
        }

        return $cart;
    }

    protected function _getCartSummary(Cart $cart)
    {
        $subtotalRaw = $cart->items()->sum(DB::raw('price_at_time * quantity'));
        $subtotal = number_format($subtotalRaw, 3);
        $tax = number_format($subtotalRaw * 0.16, 3);
        $itemCount = $cart->items()->sum('quantity');

        $shippingAreas = [
            'Amman' => 2.00,
            'Salt' => 3.00,
            'Irbid' => 4.00,
        ];

        $shipping_area = session('shipping_area');
        $shipping_cost = $shippingAreas[$shipping_area] ?? 0.00;
        $final_total = number_format($subtotalRaw + ($subtotalRaw * 0.16) + $shipping_cost, 3);

        return [
            'cart_count' => $itemCount,
            'item_count' => $itemCount,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => number_format($shipping_cost, 3),
            'discount' => '0.000',
            'final_total' => $final_total,
        ];
    }
}
