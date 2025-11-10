<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function change($currency)
    {
        $validCurrencies = ['NIS', 'JOD', 'USD', 'EUR', 'EGP'];
        if (!in_array($currency, $validCurrencies)) {
            return redirect()->back()->with('error', 'Invalid currency selected.');
        }

        session(['currency' => $currency]);

        return redirect()->back();
    }
}
