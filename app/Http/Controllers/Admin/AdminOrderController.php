<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function pendingOrders(Request $request)
    {
        try {
            $pendingOrders = Cache::remember('pending_orders', 10, function () {
                return Order::where('status', 'pending')
                    ->select('id', 'full_name', 'total', 'created_at')
                    ->with(['items' => function ($query) {
                        $query->select('order_id', app()->getLocale() === 'ar' ? 'product_name_ar as name' : 'product_name_en as name', 'quantity')
                              ->take(2);
                    }])
                    ->latest()
                    ->take(5)
                    ->get()
                    ->map(function ($order) {
                        return [
                            'id' => $order->id,
                            'full_name' => $order->full_name,
                            'total' => number_format($order->total, 2),
                            'created_at' => $order->created_at->format('M d, Y, h:i A'),
                            'items' => $order->items->map(function ($item) {
                                return [
                                    'name' => $item->name,
                                    'quantity' => $item->quantity,
                                ];
                            })->toArray(),
                            'items_count' => $order->items->count(),
                        ];
                    });
            });

            Log::info('Pending orders retrieved: ' . $pendingOrders->count());
            return response()->json([
                'pending_orders' => $pendingOrders,
                'pending_count' => $pendingOrders->count(),
            ], 200);
        } catch (\Exception $e) {
            Log::error('Failed to fetch pending orders: ' . $e->getMessage());
            return response()->json([
                'pending_orders' => [],
                'pending_count' => 0,
                'error' => 'Failed to fetch pending orders',
            ], 100);
        }
    }
}
