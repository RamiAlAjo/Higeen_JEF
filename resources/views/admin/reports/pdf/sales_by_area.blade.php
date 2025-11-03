<!DOCTYPE html>
<html>
<head>
    <title>Top Sales by Area</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #1e293b;
            direction: {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }};
        }
        h1 { text-align: center; font-size: 24px; }
        .date-range { text-align: center; font-size: 14px; color: #4b5563; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #e5e7eb; padding: 12px; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }}; font-size: 14px; }
        th { background-color: #f1f5f9; font-weight: bold; text-transform: uppercase; }
        td { color: #4b5563; }
        .error { color: #dc2626; text-align: center; font-size: 14px; }
    </style>
</head>
<body>
    <h1>{{ __('Top :limit Sales by Area', ['limit' => $limit]) }}</h1>
    @if($startDate && $endDate)
        <p class="date-range">{{ __('Date Range: :start to :end', ['start' => $startDate, 'end' => $endDate]) }}</p>
    @endif
    @if($topSalesByArea->isEmpty())
        <p class="error">{{ __('No sales data available by area.') }}</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>{{ __('Area') }}</th>
                    <th>{{ __('Total Sales ($)') }}</th>
                    <th>{{ __('Order Count') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topSalesByArea as $area)
                    <tr>
                        <td>{{ $area->area ?? __('Unknown') }}</td>
                        <td>${{ number_format($area->total_sales, 2) }}</td>
                        <td>{{ $area->order_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
