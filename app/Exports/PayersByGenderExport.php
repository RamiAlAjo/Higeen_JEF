<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PayersByGenderExport implements FromCollection, WithHeadings, WithStyles
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = Client::select('clients.gender', \DB::raw('SUM(orders.total) as total_spent'), \DB::raw('COUNT(orders.id) as order_count'))
            ->join('orders', 'clients.id', '=', 'orders.client_id')
            ->where('orders.payment_status', 'paid')
            ->whereNotNull('clients.gender')
            ->groupBy('clients.gender');

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('orders.created_at', [$this->startDate, $this->endDate]);
        }

        $data = $query->get()
            ->keyBy('gender')
            ->map(function ($item) {
                return [
                    'gender' => ucfirst($item->gender),
                    'total_spent' => number_format($item->total_spent, 2),
                    'order_count' => $item->order_count,
                ];
            })
            ->toArray();

        $result = [
            ['gender' => 'Male', 'total_spent' => $data['male']['total_spent'] ?? '0.00', 'order_count' => $data['male']['order_count'] ?? 0],
            ['gender' => 'Female', 'total_spent' => $data['female']['total_spent'] ?? '0.00', 'order_count' => $data['female']['order_count'] ?? 0],
        ];

        return collect($result);
    }

    public function headings(): array
    {
        return [
            'Gender',
            'Total Spent ($)',
            'Order Count',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'color' => ['argb' => 'FFE5E7EB']]],
            'B2:B3' => ['numberFormat' => ['formatCode' => '#,##0.00']],
        ];
    }
}
