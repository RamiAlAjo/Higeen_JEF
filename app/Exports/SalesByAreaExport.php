<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesByAreaExport implements FromCollection, WithHeadings, WithStyles
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
        $query = Order::select('orders.shipping_area as area', \DB::raw('SUM(orders.total) as total_sales'), \DB::raw('COUNT(orders.id) as order_count'))
            ->where('orders.payment_status', 'paid')
            ->whereNotNull('orders.shipping_area')
            ->groupBy('orders.shipping_area')
            ->orderByDesc('total_sales')
            ->take($this->limit);

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('orders.created_at', [$this->startDate, $this->endDate]);
        }

        return $query->get()->map(function ($item) {
            return [
                'area' => $item->area ?? 'Unknown',
                'total_sales' => number_format($item->total_sales, 2),
                'order_count' => $item->order_count,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Area',
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
