<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSubcategory;
use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FrontProductController extends Controller
{
    protected $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    /**
     * Display product listing page
     */
    public function index(Request $request)
    {
        $query = Product::where('status', 'active')->with('category', 'subcategory');

        if ($request->query('category')) {
            $query->where('category_id', $request->query('category'));
        }

        if ($request->query('subcategory')) {
            $query->where('subcategory_id', $request->query('subcategory'));
        }

        if ($request->query('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('product_name_en', 'like', "%{$search}%")
                  ->orWhere('product_name_ar', 'like', "%{$search}%")
                  ->orWhere('description_en', 'like', "%{$search}%")
                  ->orWhere('description_ar', 'like', "%{$search}%");
            });
        }

        $products = $query->paginate(6);
        $categories = ProductCategory::where('status', 'active')->get();
        $subcategories = ProductSubcategory::all();

        $bestSellers = Product::where('status', 'active')
                              ->orderBy('created_at', 'desc')
                              ->take(2)
                              ->get();

        $cart = $this->getOrCreateCart();
        $cartItemCount = $cart->items()->sum('quantity');
        $currency = session('currency', 'JOD');

        // Convert product prices
        $products->getCollection()->transform(function ($product) use ($currency) {
            $product->display_price = $this->currencyService->convert($product->price, 'JOD', $currency);
            $product->display_price_formatted = $this->currencyService->format($product->display_price, $currency);
            return $product;
        });

        $bestSellers->transform(function ($product) use ($currency) {
            $product->display_price = $this->currencyService->convert($product->price, 'JOD', $currency);
            $product->display_price_formatted = $this->currencyService->format($product->display_price, $currency);
            return $product;
        });

        return view('front.product', compact('products', 'categories', 'subcategories', 'bestSellers', 'cartItemCount', 'currency'));
    }

    /**
     * Show product detail page
     */
    public function show($id)
    {
        $product = Product::where('id', $id)
                          ->where('status', 'active')
                          ->with('category', 'subcategory')
                          ->firstOrFail();

        $currency = session('currency', 'JOD');
        $product->display_price = $this->currencyService->convert($product->price, 'JOD', $currency);
        $product->display_price_formatted = $this->currencyService->format($product->display_price, $currency);

        $relatedProducts = Product::where('category_id', $product->category_id)
                                  ->where('id', '!=', $product->id)
                                  ->where('status', 'active')
                                  ->take(4)
                                  ->get();

        $relatedProducts->transform(function ($product) use ($currency) {
            $product->display_price = $this->currencyService->convert($product->price, 'JOD', $currency);
            $product->display_price_formatted = $this->currencyService->format($product->display_price, $currency);
            return $product;
        });

        $cart = $this->getOrCreateCart();
        $cartItemCount = $cart->items()->sum('quantity');

        return view('front.product_show', compact('product', 'relatedProducts', 'cartItemCount', 'currency'));
    }

    /**
     * Handle AJAX add-to-cart request
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->input('product_id'));
        $quantity = $request->input('quantity');

        if ($product->quantity < $quantity) {
            return response()->json([
                'message' => 'Not enough stock available.',
                'cart_count' => $this->getOrCreateCart()->items()->sum('quantity')
            ], 422);
        }

        $cart = $this->getOrCreateCart();

        $existingItem = $cart->items()->where('product_id', $product->id)->first();

        if ($existingItem) {
            $existingItem->quantity += $quantity;
            $existingItem->price_at_time = $product->price; // Update price in case it changed
            $existingItem->save();
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price_at_time' => $product->price, // Store in JOD
            ]);
        }

        $cartCount = $cart->items()->sum('quantity');

        return response()->json([
            'message' => "{$product->product_name_en} added to cart!",
            'cart_count' => $cartCount
        ]);
    }

    /**
     * Get or create cart for authenticated or guest user
     */
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
