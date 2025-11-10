<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FrontCartController extends Controller
{
    protected $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

  public function index()
    {
        $cart = $this->getOrCreateCart();
        $currency = session('currency', 'NIS');
        $cartItems = $cart->items()->with('product')->get();

        $items = $cartItems->map(function ($cartItem) use ($currency) {
            $product = $cartItem->product;
            $convertedPrice = $this->currencyService->convert($cartItem->price_at_time, 'NIS', $currency);
            $lineTotal = $convertedPrice * $cartItem->quantity;
            return [
                'id' => $cartItem->id,
                'name' => $product->product_name_en,
                'price' => $convertedPrice,
                'price_formatted' => $this->currencyService->format($convertedPrice, $currency),
                'qty' => $cartItem->quantity,
                'stock' => $product->quantity,
                'image' => $product->main_image_url,
                'line_total' => $lineTotal,
                'line_total_formatted' => $this->currencyService->format($lineTotal, $currency),
            ];
        });

        $summary = $this->_getCartSummary($cart);

        return view('front.cart', [
            'items' => $items,
            'summary' => $summary,
            'cart' => $cart,
            'currency' => $currency,
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $product = Product::where('id', $request->product_id)
                          ->where('status', 'active')
                          ->firstOrFail();

        if ($request->quantity > $product->quantity) {
            return response()->json([
                'error' => 'Out of stock',
                'message' => 'Requested quantity exceeds available stock!',
            ], 422);
        }

        $cart = $this->getOrCreateCart();

        $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('product_id', $product->id)
                            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;
            if ($newQuantity > $product->quantity) {
                return response()->json([
                    'error' => 'Out of stock',
                    'message' => 'Adding this would exceed stock!',
                ], 422);
            }
            $cartItem->update([
                'quantity' => $newQuantity,
                'price_at_time' => $product->price,
            ]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price_at_time' => $product->price,
            ]);
        }

        $cart->refresh();

        return response()->json(array_merge(
            ['message' => 'Product added to cart successfully!'],
            $this->_getCartSummary($cart)
        ), 200);
    }

    public function mini()
    {
        $cart = $this->getOrCreateCart();
        $currency = session('currency', 'NIS');
        $cartItems = $cart->items()->with('product')->get();

        $items = $cartItems->map(function ($cartItem) use ($currency) {
            $product = $cartItem->product;
            $convertedPrice = $this->currencyService->convert($cartItem->price_at_time, 'NIS', $currency);
            $lineTotal = $convertedPrice * $cartItem->quantity;
            return [
                'id' => $cartItem->id,
                'name' => $product->product_name_en,
                'price' => $convertedPrice,
                'price_formatted' => $this->currencyService->format($convertedPrice, $currency),
                'qty' => $cartItem->quantity,
                'stock' => $product->quantity,
                'image' => $product->main_image_url,
                'line_total' => $lineTotal,
                'line_total_formatted' => $this->currencyService->format($lineTotal, $currency),
            ];
        })->toArray();

        $summary = $this->_getCartSummary($cart);

        return response()->json(array_merge(
            ['items' => $items],
            $summary
        ));
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = $this->getOrCreateCart();
        if ($cartItem->cart_id !== $cart->id) {
            return response()->json(['error' => 'Unauthorized', 'message' => 'Unauthorized'], 403);
        }

        $product = $cartItem->product;
        if ($request->quantity > $product->quantity) {
            return response()->json([
                'error' => 'Out of stock',
                'message' => 'Quantity exceeds available stock!',
            ], 422);
        }

        $cartItem->update([
            'quantity' => $request->quantity,
            'price_at_time' => $product->price,
        ]);

        $cart->refresh();

        return response()->json(array_merge(
            ['message' => 'Cart updated successfully!'],
            $this->_getCartSummary($cart)
        ), 200);
    }

    public function remove(CartItem $cartItem)
    {
        $cart = $this->getOrCreateCart();
        if ($cartItem->cart_id !== $cart->id) {
            return response()->json(['error' => 'Unauthorized', 'message' => 'Unauthorized'], 403);
        }

        $cartItem->delete();

        $cart->refresh();

        return response()->json(array_merge(
            ['message' => 'Item removed from cart!'],
            $this->_getCartSummary($cart)
        ), 200);
    }

    protected function _getCartSummary(Cart $cart)
    {
        $currency = session('currency', 'NIS');
        $subtotalRaw = $cart->items()->sum(DB::raw('price_at_time * quantity'));
        $subtotalConverted = $this->currencyService->convert($subtotalRaw, 'NIS', $currency);
        $subtotal = $this->currencyService->format($subtotalConverted, $currency);
        $itemCount = $cart->items()->sum('quantity');

        return [
            'cart_count' => $itemCount,
            'item_count' => $itemCount,
            'subtotal' => $subtotal,
            'subtotal_raw' => $subtotalConverted,
            'discount' => '0.000',
            'final_total' => $subtotal,
            'currency' => $currency,
        ];
    }

    protected function getOrCreateCart()
    {
        if (auth('client')->check()) {
            return Cart::firstOrCreate(
                ['client_id' => auth('client')->id()],
                ['guest_token' => null]
            );
        }

        $guestToken = session('guest_token', Str::random(32));
        session(['guest_token' => $guestToken]);

        return Cart::firstOrCreate(
            ['guest_token' => $guestToken],
            ['client_id' => null]
        );
    }
}
