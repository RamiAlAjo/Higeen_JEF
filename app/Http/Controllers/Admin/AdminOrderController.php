<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ShippingArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query()->with(['client', 'shippingArea']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('delivery_status')) {
            $query->where('delivery_status', $request->delivery_status);
        }

        if ($request->filled('hesabate')) {
            if ($request->hesabate === 'sent') {
                $query->sentToHesabate();
            } elseif ($request->hesabate === 'not_sent') {
                $query->notSentToHesabate();
            }
        }

        $orders = $query->latest()->paginate(15);

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
            'status'         => ['pending','confirmed','shipped','delivered','cancelled'],
            'payment_status' => ['unpaid','paid','failed','refunded'],
            'delivery_status'=> ['not_started','in_progress','delivered','cancelled','failed'],
        ];

        if (!isset($allowed[$field]) || !in_array($value, $allowed[$field])) {
            return response()->json(['success' => false, 'message' => 'Invalid value'], 422);
        }

        $order->update([$field => $value]);

        return response()->json(['success' => true]);
    }

    public function destroy(Order $order)
    {
        if (in_array($order->status, ['delivered', 'cancelled'])) {
            return back()->with('status-error', 'Cannot delete delivered or cancelled orders.');
        }

        $order->items()->delete();
        $order->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with('status-success', 'Order deleted successfully.');
    }

    public function pendingOrders()
    {
        $pendingOrders = Cache::remember('admin_pending_orders', 30, function () {
            return Order::where('status', 'pending')
                ->with('items:id,order_id,product_name_en,product_name_ar,quantity')
                ->latest()
                ->take(6)
                ->get()
                ->map(fn($o) => [
                    'id' => $o->id,
                    'name' => $o->full_name,
                    'total' => number_format($o->total, 2),
                    'date' => $o->created_at->format('M d, h:i A'),
                    'items' => $o->items->take(2)->map(fn($i) => $i->name . ' ×' . $i->quantity)->implode(', '),
                    'more' => $o->items->count() > 2 ? ' +' . ($o->items->count() - 2) : ''
                ]);
        });

        return response()->json([
            'pending_orders' => $pendingOrders,
            'count' => $pendingOrders->count()
        ]);
    }

    // Called after successful Hesabate upload
    public function markHesabateSent(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->hesabate_sent_at = now();
        $order->hesabate_synced = true;
        $order->save();

        return response()->json(['success' => true]);
    }
}
