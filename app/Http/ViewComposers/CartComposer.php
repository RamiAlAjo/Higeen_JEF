<?php
namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Cart;
use Illuminate\Support\Str;

class CartComposer
{
    public function compose(View $view)
    {
        $cartItems = [];
        $cartItemCount = 0;

        if (auth('client')->check()) {
            $cart = Cart::firstOrCreate(
                ['client_id' => auth('client')->id()],
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

        if ($cart) {
            $cartItems = $cart->items()->with('product')->get();
            $cartItemCount = $cartItems->sum('quantity');
        }

        $view->with(compact('cartItems', 'cartItemCount'));
    }
}
