<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class FrontClientDashboardController extends Controller
{
    /**
     * Show the client dashboard with profile info and orders.
     */
    public function index(Request $request)
    {
        $client = Auth::guard('client')->user();

        // Build the query for orders
        $query = Order::where('client_id', $client->id)
                      ->orderBy('created_at', 'desc');

        // Apply status filter if provided
        if ($request->has('status') && in_array($request->status, ['pending', 'confirmed', 'shipped', 'delivered', 'cancelled'])) {
            $query->where('status', $request->status);
        }

        // Fetch orders
        $orders = $query->get();

        return view('front.client_dashboard', compact('client', 'orders'));
    }
}
