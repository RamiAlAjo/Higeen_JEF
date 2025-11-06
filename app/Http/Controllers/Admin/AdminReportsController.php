<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Client;
use App\Models\Product;
use App\Models\ProductCategory;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesByAreaExport;
use App\Exports\SalesByProductExport;
use App\Exports\PayersByClientExport;
use App\Exports\PayersByGenderExport;
use App\Exports\SalesByCategoryExport;
use Illuminate\Http\Request;

class AdminReportsController extends Controller
{
    public function index(Request $request)
    {
        // Get limit and date range from request
        $limit = $request->input('limit', 5);
        $validLimits = [5, 10, 15, 20];
        $limit = in_array($limit, $validLimits) ? $limit : 5;

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Determine locale for name fields
        $productNameField = app()->getLocale() === 'ar' ? 'product_name_ar' : 'product_name_en';
        $categoryNameField = app()->getLocale() === 'ar' ? 'name_ar' : 'name_en';

        // Build query with optional date filtering
        $query = fn($q) => $startDate && $endDate ? $q->whereBetween('orders.created_at', [$startDate, $endDate]) : $q;

        // Top Sales by Area
$areaNameField = app()->getLocale() === 'ar' ? 'name_ar' : 'name_en';

$topSalesByArea = Order::select(
        'shipping_areas.id as shipping_area_id',
        "shipping_areas.$areaNameField as area_name",
        DB::raw('SUM(orders.total) as total_sales'),
        DB::raw('COUNT(orders.id) as order_count')
    )
    ->join('shipping_areas', 'orders.shipping_area_id', '=', 'shipping_areas.id')
    ->where('orders.payment_status', 'paid')
    ->whereNotNull('orders.shipping_area_id')
    ->groupBy('shipping_areas.id', "shipping_areas.$areaNameField")
    ->orderByDesc('total_sales')
    ->take($limit);

$topSalesByArea = $query($topSalesByArea)->get();

        // Top Sales by Product
        $topSalesByProduct = Product::select('products.id', "products.$productNameField as product_name", DB::raw('SUM(order_items.quantity * order_items.price) as total_sales'), DB::raw('COUNT(order_items.id) as order_count'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.payment_status', 'paid')
            ->groupBy('products.id', "products.$productNameField")
            ->orderByDesc('total_sales')
            ->take($limit);

        $topSalesByProduct = $query($topSalesByProduct)->get();

        // Top Payer by Client
        $topPayersByClient = Client::select('clients.id', 'clients.name', DB::raw('SUM(orders.total) as total_spent'), DB::raw('COUNT(orders.id) as order_count'))
            ->join('orders', 'clients.id', '=', 'orders.client_id')
            ->where('orders.payment_status', 'paid')
            ->groupBy('clients.id', 'clients.name')
            ->orderByDesc('total_spent')
            ->take($limit);

        $topPayersByClient = $query($topPayersByClient)->get();

        // Top Payer by Gender
        $topPayersByGender = Client::select('clients.gender', DB::raw('SUM(orders.total) as total_spent'), DB::raw('COUNT(orders.id) as order_count'))
            ->join('orders', 'clients.id', '=', 'orders.client_id')
            ->where('orders.payment_status', 'paid')
            ->whereNotNull('clients.gender')
            ->groupBy('clients.gender');

        $topPayersByGender = $query($topPayersByGender)
            ->get()
            ->keyBy('gender')
            ->map(function ($item) {
                return [
                    'total_spent' => $item->total_spent,
                    'order_count' => $item->order_count
                ];
            })
            ->toArray();

        $topPayersByGender = [
            'male' => [
                'total_spent' => $topPayersByGender['male']['total_spent'] ?? 0,
                'order_count' => $topPayersByGender['male']['order_count'] ?? 0
            ],
            'female' => [
                'total_spent' => $topPayersByGender['female']['total_spent'] ?? 0,
                'order_count' => $topPayersByGender['female']['order_count'] ?? 0
            ]
        ];

        // Top Sales by Product Category
        $topSalesByCategory = ProductCategory::select(
            'products_categories.id',
            "products_categories.$categoryNameField as category_name",
            DB::raw('SUM(order_items.quantity * order_items.price) as total_sales'),
            DB::raw('COUNT(order_items.id) as order_count')
        )
            ->join('products', 'products_categories.id', '=', 'products.category_id')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.payment_status', 'paid')
            ->groupBy('products_categories.id', "products_categories.$categoryNameField")
            ->orderByDesc('total_sales')
            ->take($limit);

        $topSalesByCategory = $query($topSalesByCategory)->get();

        // Debug data
        \Log::info('Reports Data', [
            'limit' => $limit,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'locale' => app()->getLocale(),
            'topSalesByArea' => $topSalesByArea->toArray(),
            'topSalesByProduct' => $topSalesByProduct->toArray(),
            'topPayersByClient' => $topPayersByClient->toArray(),
            'topPayersByGender' => $topPayersByGender,
            'topSalesByCategory' => $topSalesByCategory->toArray(),
        ]);

        return view('admin.reports', compact(
            'topSalesByArea',
            'topSalesByProduct',
            'topPayersByClient',
            'topPayersByGender',
            'topSalesByCategory',
            'limit',
            'startDate',
            'endDate'
        ));
    }

    // PDF Export Methods
    public function exportSalesByAreaPdf(Request $request, $limit = 5)
    {
        $validLimits = [5, 10, 15, 20];
        $limit = in_array($limit, $validLimits) ? $limit : 5;
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = fn($q) => $startDate && $endDate ? $q->whereBetween('orders.created_at', [$startDate, $endDate]) : $q;

        $topSalesByArea = Order::select('orders.shipping_area as area', DB::raw('SUM(orders.total) as total_sales'), DB::raw('COUNT(orders.id) as order_count'))
            ->where('orders.payment_status', 'paid')
            ->whereNotNull('orders.shipping_area')
            ->groupBy('orders.shipping_area')
            ->orderByDesc('total_sales')
            ->take($limit);

        $topSalesByArea = $query($topSalesByArea)->get();

        $pdf = Pdf::loadView('admin.reports.pdf.sales_by_area', compact('topSalesByArea', 'limit', 'startDate', 'endDate'));
        return $pdf->download('top_sales_by_area.pdf');
    }

    public function exportSalesByProductPdf(Request $request, $limit = 5)
    {
        $validLimits = [5, 10, 15, 20];
        $limit = in_array($limit, $validLimits) ? $limit : 5;
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $productNameField = app()->getLocale() === 'ar' ? 'product_name_ar' : 'product_name_en';

        $query = fn($q) => $startDate && $endDate ? $q->whereBetween('orders.created_at', [$startDate, $endDate]) : $q;

        $topSalesByProduct = Product::select('products.id', "products.$productNameField as product_name", DB::raw('SUM(order_items.quantity * order_items.price) as total_sales'), DB::raw('COUNT(order_items.id) as order_count'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.payment_status', 'paid')
            ->groupBy('products.id', "products.$productNameField")
            ->orderByDesc('total_sales')
            ->take($limit);

        $topSalesByProduct = $query($topSalesByProduct)->get();

        $pdf = Pdf::loadView('admin.reports.pdf.sales_by_product', compact('topSalesByProduct', 'limit', 'startDate', 'endDate'));
        return $pdf->download('top_sales_by_product.pdf');
    }

    public function exportPayersByClientPdf(Request $request, $limit = 5)
    {
        $validLimits = [5, 10, 15, 20];
        $limit = in_array($limit, $validLimits) ? $limit : 5;
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = fn($q) => $startDate && $endDate ? $q->whereBetween('orders.created_at', [$startDate, $endDate]) : $q;

        $topPayersByClient = Client::select('clients.id', 'clients.name', DB::raw('SUM(orders.total) as total_spent'), DB::raw('COUNT(orders.id) as order_count'))
            ->join('orders', 'clients.id', '=', 'orders.client_id')
            ->where('orders.payment_status', 'paid')
            ->groupBy('clients.id', 'clients.name')
            ->orderByDesc('total_spent')
            ->take($limit);

        $topPayersByClient = $query($topPayersByClient)->get();

        $pdf = Pdf::loadView('admin.reports.pdf.payers_by_client', compact('topPayersByClient', 'limit', 'startDate', 'endDate'));
        return $pdf->download('top_payers_by_client.pdf');
    }

    public function exportPayersByGenderPdf(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = fn($q) => $startDate && $endDate ? $q->whereBetween('orders.created_at', [$startDate, $endDate]) : $q;

        $topPayersByGender = Client::select('clients.gender', DB::raw('SUM(orders.total) as total_spent'), DB::raw('COUNT(orders.id) as order_count'))
            ->join('orders', 'clients.id', '=', 'orders.client_id')
            ->where('orders.payment_status', 'paid')
            ->whereNotNull('clients.gender')
            ->groupBy('clients.gender');

        $topPayersByGender = $query($topPayersByGender)
            ->get()
            ->keyBy('gender')
            ->map(function ($item) {
                return [
                    'total_spent' => $item->total_spent,
                    'order_count' => $item->order_count
                ];
            })
            ->toArray();

        $topPayersByGender = [
            'male' => [
                'total_spent' => $topPayersByGender['male']['total_spent'] ?? 0,
                'order_count' => $topPayersByGender['male']['order_count'] ?? 0
            ],
            'female' => [
                'total_spent' => $topPayersByGender['female']['total_spent'] ?? 0,
                'order_count' => $topPayersByGender['female']['order_count'] ?? 0
            ]
        ];

        $pdf = Pdf::loadView('admin.reports.pdf.payers_by_gender', compact('topPayersByGender', 'startDate', 'endDate'));
        return $pdf->download('top_payers_by_gender.pdf');
    }

    public function exportSalesByCategoryPdf(Request $request, $limit = 5)
    {
        $validLimits = [5, 10, 15, 20];
        $limit = in_array($limit, $validLimits) ? $limit : 5;
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $categoryNameField = app()->getLocale() === 'ar' ? 'name_ar' : 'name_en';

        $query = fn($q) => $startDate && $endDate ? $q->whereBetween('orders.created_at', [$startDate, $endDate]) : $q;

        $topSalesByCategory = ProductCategory::select(
            'products_categories.id',
            "products_categories.$categoryNameField as category_name",
            DB::raw('SUM(order_items.quantity * order_items.price) as total_sales'),
            DB::raw('COUNT(order_items.id) as order_count')
        )
            ->join('products', 'products_categories.id', '=', 'products.category_id')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.payment_status', 'paid')
            ->groupBy('products_categories.id', "products_categories.$categoryNameField")
            ->orderByDesc('total_sales')
            ->take($limit);

        $topSalesByCategory = $query($topSalesByCategory)->get();

        $pdf = Pdf::loadView('admin.reports.pdf.sales_by_category', compact('topSalesByCategory', 'limit', 'startDate', 'endDate'));
        return $pdf->download('top_sales_by_category.pdf');
    }

    // Excel Export Methods
    public function exportSalesByAreaExcel(Request $request, $limit = 5)
    {
        $validLimits = [5, 10, 15, 20];
        $limit = in_array($limit, $validLimits) ? $limit : 5;
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        return Excel::download(new SalesByAreaExport($limit, $startDate, $endDate), 'top_sales_by_area.xlsx');
    }

    public function exportSalesByProductExcel(Request $request, $limit = 5)
    {
        $validLimits = [5, 10, 15, 20];
        $limit = in_array($limit, $validLimits) ? $limit : 5;
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        return Excel::download(new SalesByProductExport($limit, $startDate, $endDate), 'top_sales_by_product.xlsx');
    }

    public function exportPayersByClientExcel(Request $request, $limit = 5)
    {
        $validLimits = [5, 10, 15, 20];
        $limit = in_array($limit, $validLimits) ? $limit : 5;
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        return Excel::download(new PayersByClientExport($limit, $startDate, $endDate), 'top_payers_by_client.xlsx');
    }

    public function exportPayersByGenderExcel(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        return Excel::download(new PayersByGenderExport($startDate, $endDate), 'top_payers_by_gender.xlsx');
    }

    public function exportSalesByCategoryExcel(Request $request, $limit = 5)
    {
        $validLimits = [5, 10, 15, 20];
        $limit = in_array($limit, $validLimits) ? $limit : 5;
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        return Excel::download(new SalesByCategoryExport($limit, $startDate, $endDate), 'top_sales_by_category.xlsx');
    }
}
