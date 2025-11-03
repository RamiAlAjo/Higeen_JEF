<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PayersByClientExport implements FromCollection, WithHeadings, WithStyles
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
        $query = Client::select('clients.name', \DB::raw('SUM(orders.total) as total_spent'), \DB::raw('COUNT(orders.id) as order_count'))
            ->join('orders', 'clients.id', '=', 'orders.client_id')
            ->where('orders.payment_status', 'paid')
            ->groupBy('clients.id', 'clients.name')
            ->orderByDesc('total_spent')
            ->take($this->limit);

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('orders.created_at', [$this->startDate, $this->endDate]);
        }

        return $query->get()->map(function ($item) {
            return [
                'name' => $item->name,
                'total_spent' => number_format($item->total_spent, 2),
                'order_count' => $item->order_count,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Client',
            'Total Spent ($)',
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
