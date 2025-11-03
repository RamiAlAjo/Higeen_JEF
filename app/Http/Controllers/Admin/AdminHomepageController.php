<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSubcategory;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class AdminHomepageController extends Controller
{
    public function index()
    {
        // Get the logged-in user
        $user = Auth::user();

        // Client statistics
        $totalClients = Client::count();
        $recentClients = Client::latest()->take(5)->get();
        $genderDistribution = Client::select('gender', DB::raw('count(*) as count'))
            ->whereNotNull('gender')
            ->groupBy('gender')
            ->pluck('count', 'gender')
            ->toArray();

        // Product statistics
        $totalProducts = Product::count();
        $activeProducts = Product::where('status', 'active')->count();
        $lowStockProducts = Product::where('quantity', '<=', 10)->count();
        $topProducts = Product::select('products.id', 'products.product_name_en', DB::raw('COUNT(order_items.id) as order_count'))
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('orders', 'order_items.order_id', '=', 'orders.id')
            ->groupBy('products.id', 'products.product_name_en')
            ->orderByDesc('order_count')
            ->take(5)
            ->get();

        // Category and Subcategory counts
        $totalCategories = ProductCategory::count();
        $totalSubcategories = ProductSubcategory::count();

        // Order statistics
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $recentOrders = Order::latest()->take(5)->get();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total');
        $orderStatusDistribution = Order::select('status', DB::raw('count(*) as count'))
            ->whereIn('status', ['pending', 'confirmed', 'shipped', 'delivered', 'cancelled'])
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Ensure all expected statuses are included, even with zero counts
        $statusDefaults = ['pending' => 0, 'confirmed' => 0, 'shipped' => 0, 'delivered' => 0, 'cancelled' => 0];
        $orderStatusDistribution = array_merge($statusDefaults, $orderStatusDistribution);

        // Monthly revenue (last 6 months)
        $monthlyRevenue = Order::where('payment_status', 'paid')
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('SUM(total) as revenue'))
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Ensure all months in the last 6 months are included, even with zero revenue
        $months = collect(range(0, 5))->map(function ($i) {
            return now()->subMonths($i)->format('Y-m');
        })->reverse()->values();
        $monthlyRevenue = $months->map(function ($month) use ($monthlyRevenue) {
            $data = $monthlyRevenue->firstWhere('month', $month);
            return (object) [
                'month' => $month,
                'revenue' => $data ? $data->revenue : 0
            ];
        });

        // Payment method distribution
        $paymentMethodDistribution = Order::select('payment_method', DB::raw('count(*) as count'))
            ->whereNotNull('payment_method')
            ->groupBy('payment_method')
            ->pluck('count', 'payment_method')
            ->toArray();

        // Debug data
        \Log::info('Dashboard Data', [
            'orderStatusDistribution' => $orderStatusDistribution,
            'topProducts' => $topProducts->toArray(),
            'monthlyRevenue' => $monthlyRevenue->toArray(),
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'paymentMethodDistribution' => $paymentMethodDistribution,
        ]);

        return view('admin.homepage', compact(
            'user',
            'totalClients',
            'recentClients',
            'genderDistribution',
            'totalProducts',
            'activeProducts',
            'lowStockProducts',
            'topProducts',
            'totalCategories',
            'totalSubcategories',
            'totalOrders',
            'pendingOrders',
            'deliveredOrders',
            'recentOrders',
            'totalRevenue',
            'orderStatusDistribution',
            'paymentMethodDistribution',
            'monthlyRevenue'
        ));
    }
}
