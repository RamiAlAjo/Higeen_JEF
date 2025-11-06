<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ShippingArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->with(['client', 'shippingArea'])->latest()->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'client', 'shippingArea']);
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $order->load(['items.product', 'client', 'shippingArea']);
        $shippingAreas = ShippingArea::where('is_active', true)->get();
        return view('admin.orders.edit', compact('order', 'shippingAreas'));
    }

    public function update(Request $request, Order $order)
{
    $field = $request->input('field');
    $value = $request->input('value');

    $allowed = [
        'status' => ['pending','confirmed','shipped','delivered','cancelled'],
        'payment_status' => ['unpaid','paid','failed','refunded'],
        'delivery_status' => ['not_started','in_progress','delivered','cancelled','failed'],
    ];

    if (!isset($allowed[$field]) || !in_array($value, $allowed[$field])) {
        return response()->json(['success' => false, 'message' => 'Invalid value'], 422);
    }

    $order->update([$field => $value]);

    return response()->json(['success' => true]);
}

    public function destroy(Order $order)
    {
        // Optional: prevent deletion of delivered orders
        if (in_array($order->status, ['delivered', 'cancelled'])) {
            return back()->with('status-error', 'Cannot delete delivered or cancelled orders.');
        }

        $order->items()->delete();
        $order->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with('status-success', 'Order deleted successfully.');
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
            ], 500);
        }
    }
}