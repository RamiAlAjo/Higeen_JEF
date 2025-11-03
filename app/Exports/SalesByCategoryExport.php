<?php

namespace App\Exports;

use App\Models\ProductCategory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesByCategoryExport implements FromCollection, WithHeadings, WithStyles
{
    protected $limit;
    protected $startDate;
    protected $endDate;

    public function __construct($limit, $startDate = null, $endDate = null)
    {
        $this->limit = $limit;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $nameField = app()->getLocale() === 'ar' ? 'name_ar' : 'name_en';

        $query = ProductCategory::select(
            'products_categories.id',
            "products_categories.$nameField as category_name",
            \DB::raw('SUM(order_items.quantity * order_items.price) as total_sales'),
            \DB::raw('COUNT(order_items.id) as order_count')
        )
            ->join('products', 'products_categories.id', '=', 'products.category_id')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.payment_status', 'paid')
            ->groupBy('products_categories.id', "products_categories.$nameField")
            ->orderByDesc('total_sales')
            ->take($this->limit);

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('orders.created_at', [$this->startDate, $this->endDate]);
        }

        return $query->get()->map(function ($item) {
            return [
                'category_name' => $item->category_name,
                'total_sales' => number_format($item->total_sales, 2),
                'order_count' => $item->order_count,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Category',
            'Total Sales ($)',
            'Order Count',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'color' => ['argb' => 'FFE5E7EB']]],
            'B2:B' . ($this->limit + 1) => ['numberFormat' => ['formatCode' => '#,##0.00']],
        ];
    }
}
