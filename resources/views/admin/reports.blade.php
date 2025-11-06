@extends('admin.layouts.app')

@section('title', __('Reports Dashboard'))

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --primary: #7c3aed;
        --danger: #dc2626;
        --success: #16a34a;
        --gray-100: #f1f5f9;
        --gray-200: #e5e7eb;
        --gray-700: #374151;
        --gray-900: #1e293b;
    }
    body { font-family: 'Inter', sans-serif; background: var(--gray-100); color: var(--gray-900); direction: {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}; }
    .container { max-width: 1280px; margin: 0 auto; padding: 2rem; }
    .reports-title { font-size: 2.25rem; font-weight: 700; text-align: center; margin-bottom: 2rem; }
    .card { border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); margin-bottom: 2rem; overflow: hidden; transition: transform .3s; }
    .card:hover { transform: translateY(-5px); }
    .card-header { background: linear-gradient(135deg, #9e6de0, var(--primary)); color: white; font-weight: 600; padding: 1rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: .5rem; }
    .card-body { padding: 1.5rem; }
    .table { background: white; border-radius: 8px; overflow: hidden; }
    .table th { background: var(--gray-100); text-transform: uppercase; font-size: .85rem; letter-spacing: .05em; color: var(--gray-700); }
    .table td { color: #4b5563; }
    .chart-container { position: relative; height: 300px; margin-bottom: 1.5rem; }
    .export-btn { padding: .5rem 1rem; border-radius: 6px; font-size: .9rem; text-decoration: none; display: inline-flex; align-items: center; gap: .5rem; }
    .export-btn.pdf { background: var(--danger); color: white; }
    .export-btn.pdf:hover { background: #b91c1c; }
    .export-btn.excel { background: var(--success); color: white; }
    .export-btn.excel:hover { background: #15803d; }
    .filter-form { display: flex; gap: 1rem; flex-wrap: wrap; align-items: end; }
    .filter-form label { font-weight: 600; }
    .filter-form input, .filter-form select, .filter-form button { padding: .5rem; border-radius: 6px; border: 1px solid var(--gray-200); font-size: .9rem; }
    .filter-form button { background: #3b82f6; color: white; border: none; cursor: pointer; }
    .filter-form button:hover { background: #2563eb; }
    @media (max-width: 768px) {
        .reports-title { font-size: 1.75rem; }
        .filter-form { flex-direction: column; }
        .filter-form > div { width: 100%; }
    }
</style>

<div class="container">
    <h1 class="reports-title">{{ __('Reports Dashboard') }}</h1>

    <!-- Filters -->
    <form class="filter-form mb-4" id="filterForm">
        @csrf
        <div>
            <label>{{ __('Show Top') }}</label>
            <select name="limit" onchange="updateURL()">
                @foreach([5,10,15,20] as $l)
                    <option value="{{ $l }}" {{ $limit == $l ? 'selected' : '' }}>{{ $l }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>{{ __('Start Date') }}</label>
            <input type="date" name="start_date" value="{{ $startDate ?? '' }}" onchange="updateURL()">
        </div>
        <div>
            <label>{{ __('End Date') }}</label>
            <input type="date" name="end_date" value="{{ $endDate ?? '' }}" onchange="updateURL()">
        </div>
        <div>
            <button type="submit">{{ __('Apply') }}</button>
        </div>
    </form>

    <!-- Top Sales by Area -->
   <x-report-card
    title="{{ __('Top :limit Sales by Area', ['limit' => $limit]) }}"
    :data="$topSalesByArea"
    chart-id="salesByAreaChart"
    pdf-route="admin.reports.sales_by_area.pdf"
    excel-route="admin.reports.sales_by_area.excel"
    :limit="$limit"
    :start-date="$startDate"
    :end-date="$endDate">

    <x-slot name="headers">
        <th>{{ __('Area') }}</th>
        <th>{{ __('Total Sales') }}</th>
        <th>{{ __('Orders') }}</th>
    </x-slot>

    @foreach($topSalesByArea as $area)
        <tr>
            {{-- Use the localized name from the relationship --}}
            <td>
                {{ $area->shippingArea?->name ?? $area->shipping_area ?? __('Unknown') }}
            </td>

            <td>{{ number_format($area->total_sales, 2) }} {{ __('JOD') }}</td>
            <td>{{ $area->order_count }}</td>
        </tr>
    @endforeach
</x-report-card>

    <!-- Top Sales by Product -->
    <x-report-card title="{{ __('Top :limit Products by Sales', ['limit' => $limit]) }}"
                   :data="$topSalesByProduct"
                   chart-id="salesByProductChart"
                   pdf-route="admin.reports.sales_by_product.pdf"
                   excel-route="admin.reports.sales_by_product.excel"
                   :limit="$limit"
                   :start-date="$startDate"
                   :end-date="$endDate">
        <x-slot name="headers">
            <th>{{ __('Product') }}</th>
            <th>{{ __('Total Sales') }}</th>
            <th>{{ __('Orders') }}</th>
        </x-slot>
        @foreach($topSalesByProduct as $p)
            <tr>
                <td>{{ $p->product_name }}</td>
                <td>{{ number_format($p->total_sales, 2) }} JOD</td>
                <td>{{ $p->order_count }}</td>
            </tr>
        @endforeach
    </x-report-card>

    <!-- Top Payers by Client -->
    <x-report-card title="{{ __('Top :limit Clients by Spending', ['limit' => $limit]) }}"
                   :data="$topPayersByClient"
                   chart-id="payersByClientChart"
                   pdf-route="admin.reports.payers_by_client.pdf"
                   excel-route="admin.reports.payers_by_client.excel"
                   :limit="$limit"
                   :start-date="$startDate"
                   :end-date="$endDate">
        <x-slot name="headers">
            <th>{{ __('Client') }}</th>
            <th>{{ __('Total Spent') }}</th>
            <th>{{ __('Orders') }}</th>
        </x-slot>
        @foreach($topPayersByClient as $c)
            <tr>
                <td>{{ $c->name }}</td>
                <td>{{ number_format($c->total_spent, 2) }} JOD</td>
                <td>{{ $c->order_count }}</td>
            </tr>
        @endforeach
    </x-report-card>

    <!-- Top Payers by Gender -->
    <x-report-card title="{{ __('Spending by Gender') }}"
                   :data="collect($topPayersByGender)"
                   chart-id="payersByGenderChart"
                   pdf-route="admin.reports.payers_by_gender.pdf"
                   excel-route="admin.reports.payers_by_gender.excel"
                   :start-date="$startDate"
                   :end-date="$endDate">
        <x-slot name="headers">
            <th>{{ __('Gender') }}</th>
            <th>{{ __('Total Spent') }}</th>
            <th>{{ __('Orders') }}</th>
        </x-slot>
        @foreach($topPayersByGender as $g => $d)
            <tr>
                <td>{{ __(ucfirst($g)) }}</td>
                <td>{{ number_format($d['total_spent'], 2) }} JOD</td>
                <td>{{ $d['order_count'] }}</td>
            </tr>
        @endforeach
    </x-report-card>

    <!-- Top Sales by Category -->
    <x-report-card title="{{ __('Top :limit Categories by Sales', ['limit' => $limit]) }}"
                   :data="$topSalesByCategory"
                   chart-id="salesByCategoryChart"
                   pdf-route="admin.reports.sales_by_category.pdf"
                   excel-route="admin.reports.sales_by_category.excel"
                   :limit="$limit"
                   :start-date="$startDate"
                   :end-date="$endDate">
        <x-slot name="headers">
            <th>{{ __('Category') }}</th>
            <th>{{ __('Total Sales') }}</th>
            <th>{{ __('Orders') }}</th>
        </x-slot>
        @foreach($topSalesByCategory as $c)
            <tr>
                <td>{{ $c->category_name }}</td>
                <td>{{ number_format($c->total_sales, 2) }} JOD</td>
                <td>{{ $c->order_count }}</td>
            </tr>
        @endforeach
    </x-report-card>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        const updateURL = () => {
            const form = document.getElementById('filterForm');
            const data = new FormData(form);
            const params = new URLSearchParams();
            for (const [k, v] of data) if (v) params.set(k, v);
            window.history.replaceState({}, '', `${window.location.pathname}?${params}`);
            form.submit();
        };
        window.updateURL = updateURL;

        // Helper: Create Chart
        const createChart = (id, type, labels, data, bg = '#7c3aed') => {
            const ctx = document.getElementById(id);
            if (!ctx) return;
            new Chart(ctx, {
                type,
                data: { labels, datasets: [{ data, backgroundColor: bg, borderColor: bg, borderWidth: 1 }] },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: type !== 'pie' && type !== 'doughnut' } },
                    scales: type === 'pie' ? {} : { y: { beginAtZero: true } }
                }
            });
        };

        // Render Charts
        @if(!$topSalesByArea->isEmpty())
            createChart('salesByAreaChart', 'bar',
                @json($topSalesByArea->pluck('shippingArea.name', 'area')->map(fn($n) => $n ?? __('Unknown'))->values()),
                @json($topSalesByArea->pluck('total_sales')->values())
            );
        @endif

        @if(!$topSalesByProduct->isEmpty())
            createChart('salesByProductChart', 'bar',
                @json($topSalesByProduct->pluck('product_name')->values()),
                @json($topSalesByProduct->pluck('total_sales')->values())
            );
        @endif

        @if(!$topPayersByClient->isEmpty())
            createChart('payersByClientChart', 'bar',
                @json($topPayersByClient->pluck('name')->values()),
                @json($topPayersByClient->pluck('total_spent')->values())
            );
        @endif

        @if(!empty($topPayersByGender))
            createChart('payersByGenderChart', 'pie',
                @json([__('Male'), __('Female')]),
                @json([$topPayersByGender['male']['total_spent'] ?? 0, $topPayersByGender['female']['total_spent'] ?? 0]),
                ['#3b82f6', '#f59e0b']
            );
        @endif

        @if(!$topSalesByCategory->isEmpty())
            createChart('salesByCategoryChart', 'bar',
                @json($topSalesByCategory->pluck('category_name')->values()),
                @json($topSalesByCategory->pluck('total_sales')->values())
            );
        @endif
    });
</script>
@endsection
