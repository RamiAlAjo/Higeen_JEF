@extends('admin.layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<style>
    body {
        background-color: #f1f5f9;
        color: #1e293b;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        direction: {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }};
    }

    .container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 2rem;
    }

    .reports-title {
        font-size: 2.25rem;
        font-weight: 700;
        color: #1e293b;
        text-align: center;
        margin-bottom: 2rem;
        animation: fadeIn 0.8s ease-in;
    }

    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background-color: #ffffff;
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }

    .card-header {
        background: linear-gradient(135deg, #9e6de0 0%, #7c3aed 100%);
        color: #ffffff;
        font-weight: 600;
        font-size: 1.1rem;
        padding: 1rem;
        border-radius: 12px 12px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    .table {
        background-color: #ffffff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
    }

    .table thead {
        background: #f1f5f9;
    }

    .table th, .table td {
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        vertical-align: middle;
        text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};
    }

    .table th {
        font-weight: 600;
        color: #1e293b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .table td {
        color: #4b5563;
    }

    .table tr:hover {
        background-color: #f8fafc;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1e293b;
        margin: 2.5rem 0 1rem;
        text-align: center;
    }

    .chart-container {
        max-width: 600px;
        margin: 0 auto 1.5rem;
        position: relative;
    }

    .error-message {
        color: #dc2626;
        font-size: 0.95rem;
        text-align: center;
        margin: 1rem 0;
    }

    .controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .limit-select, .date-input {
        padding: 0.5rem;
        border-radius: 6px;
        border: 1px solid #d1d5db;
        background-color: #ffffff;
        font-size: 0.9rem;
        color: #1e293b;
    }

    .export-btn {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        text-decoration: none;
        font-size: 0.9rem;
        transition: background-color 0.3s ease;
    }

    .export-btn.pdf {
        background-color: #7f1d1d;
        color: #ffffff;
    }

    .export-btn.pdf:hover {
        background-color: #991b1b;
    }

    .export-btn.excel {
        background-color: #16a34a;
        color: #ffffff;
    }

    .export-btn.excel:hover {
        background-color: #15803d;
    }

    .export-btn i {
        margin-right: 0.5rem;
    }

    .filter-form {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .filter-form label {
        font-weight: 600;
        color: #1e293b;
    }

    .filter-form button {
        padding: 0.5rem 1rem;
        background-color: #3b82f6;
        color: #ffffff;
        border: none;
        border-radius: 6px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .filter-form button:hover {
        background-color: #2563eb;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .reports-title {
            font-size: 1.75rem;
        }

        .section-title {
            font-size: 1.25rem;
        }

        .card-header {
            font-size: 1rem;
        }

        .table th, .table td {
            font-size: 0.85rem;
        }

        .chart-container {
            max-width: 100%;
        }

        .controls, .filter-form {
            flex-direction: column;
            gap: 0.5rem;
        }

        .limit-select, .date-input, .export-btn, .filter-form button {
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="container">
    <h1 class="reports-title">{{ __('Reports Dashboard') }}</h1>

    <!-- Filters -->
    <div class="controls">
        <div>
            <label for="limit-select" class="font-semibold">{{ __('Show Top') }}:</label>
            <select id="limit-select" class="limit-select" name="limit" onchange="this.form.submit()">
                <option value="5" {{ $limit == 5 ? 'selected' : '' }}>5</option>
                <option value="10" {{ $limit == 10 ? 'selected' : '' }}>10</option>
                <option value="15" {{ $limit == 15 ? 'selected' : '' }}>15</option>
                <option value="20" {{ $limit == 20 ? 'selected' : '' }}>20</option>
            </select>
        </div>
        <form class="filter-form" method="GET" action="{{ route('admin.reports.index') }}">
            <input type="hidden" name="limit" value="{{ $limit }}">
            <div>
                <label for="start_date">{{ __('Start Date') }}:</label>
                <input type="date" id="start_date" name="start_date" class="date-input" value="{{ $startDate ?? '' }}">
            </div>
            <div>
                <label for="end_date">{{ __('End Date') }}:</label>
                <input type="date" id="end_date" name="end_date" class="date-input" value="{{ $endDate ?? '' }}">
            </div>
            <button type="submit">{{ __('Apply Filter') }}</button>
        </form>
    </div>

    <!-- Top Sales by Area -->
    <h2 class="section-title">{{ __('Top Sales by Area') }}</h2>
    <div class="card">
        <div class="card-header">
            <span>{{ __('Top :limit Sales by Geographic Area', ['limit' => $limit]) }}</span>
            <div>
                <a href="{{ route('admin.reports.sales_by_area.pdf', ['limit' => $limit, 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="export-btn pdf"><i class="fas fa-file-pdf"></i> {{ __('Export as PDF') }}</a>
                <a href="{{ route('admin.reports.sales_by_area.excel', ['limit' => $limit, 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="export-btn excel"><i class="fas fa-file-excel"></i> {{ __('Export as Excel') }}</a>
            </div>
        </div>
        <div class="card-body">
            @if($topSalesByArea->isEmpty())
                <p class="error-message">{{ __('No sales data available by area.') }}</p>
            @else
                <div class="chart-container">
                    <canvas id="salesByAreaChart"></canvas>
                </div>
                <table class="table table-hover">
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
        </div>
    </div>

    <!-- Top Sales by Product -->
    <h2 class="section-title">{{ __('Top Sales by Product') }}</h2>
    <div class="card">
        <div class="card-header">
            <span>{{ __('Top :limit Products by Sales', ['limit' => $limit]) }}</span>
            <div>
                <a href="{{ route('admin.reports.sales_by_product.pdf', ['limit' => $limit, 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="export-btn pdf"><i class="fas fa-file-pdf"></i> {{ __('Export as PDF') }}</a>
                <a href="{{ route('admin.reports.sales_by_product.excel', ['limit' => $limit, 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="export-btn excel"><i class="fas fa-file-excel"></i> {{ __('Export as Excel') }}</a>
            </div>
        </div>
        <div class="card-body">
            @if($topSalesByProduct->isEmpty())
                <p class="error-message">{{ __('No product sales data available.') }}</p>
            @else
                <div class="chart-container">
                    <canvas id="salesByProductChart"></canvas>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ __('Product') }}</th>
                            <th>{{ __('Total Sales ($)') }}</th>
                            <th>{{ __('Order Count') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topSalesByProduct as $product)
                            <tr>
                                <td>{{ $product->product_name }}</td>
                                <td>${{ number_format($product->total_sales, 2) }}</td>
                                <td>{{ $product->order_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- Top Payer by Client -->
    <h2 class="section-title">{{ __('Top Payer by Client') }}</h2>
    <div class="card">
        <div class="card-header">
            <span>{{ __('Top :limit Clients by Total Spending', ['limit' => $limit]) }}</span>
            <div>
                <a href="{{ route('admin.reports.payers_by_client.pdf', ['limit' => $limit, 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="export-btn pdf"><i class="fas fa-file-pdf"></i> {{ __('Export as PDF') }}</a>
                <a href="{{ route('admin.reports.payers_by_client.excel', ['limit' => $limit, 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="export-btn excel"><i class="fas fa-file-excel"></i> {{ __('Export as Excel') }}</a>
            </div>
        </div>
        <div class="card-body">
            @if($topPayersByClient->isEmpty())
                <p class="error-message">{{ __('No client spending data available.') }}</p>
            @else
                <div class="chart-container">
                    <canvas id="payersByClientChart"></canvas>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ __('Client') }}</th>
                            <th>{{ __('Total Spent ($)') }}</th>
                            <th>{{ __('Order Count') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topPayersByClient as $client)
                            <tr>
                                <td>{{ $client->name }}</td>
                                <td>${{ number_format($client->total_spent, 2) }}</td>
                                <td>{{ $client->order_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- Top Payer by Gender -->
    <h2 class="section-title">{{ __('Top Payer by Gender') }}</h2>
    <div class="card">
        <div class="card-header">
            <span>{{ __('Spending by Gender') }}</span>
            <div>
                <a href="{{ route('admin.reports.payers_by_gender.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="export-btn pdf"><i class="fas fa-file-pdf"></i> {{ __('Export as PDF') }}</a>
                <a href="{{ route('admin.reports.payers_by_gender.excel', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="export-btn excel"><i class="fas fa-file-excel"></i> {{ __('Export as Excel') }}</a>
            </div>
        </div>
        <div class="card-body">
            @if(empty($topPayersByGender))
                <p class="error-message">{{ __('No gender spending data available.') }}</p>
            @else
                <div class="chart-container">
                    <canvas id="payersByGenderChart"></canvas>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ __('Gender') }}</th>
                            <th>{{ __('Total Spent ($)') }}</th>
                            <th>{{ __('Order Count') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topPayersByGender as $gender => $data)
                            <tr>
                                <td>{{ __(ucfirst($gender)) }}</td>
                                <td>${{ number_format($data['total_spent'], 2) }}</td>
                                <td>{{ $data['order_count'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- Top Sales by Product Category -->
    <h2 class="section-title">{{ __('Top Sales by Product Category') }}</h2>
    <div class="card">
        <div class="card-header">
            <span>{{ __('Top :limit Categories by Sales', ['limit' => $limit]) }}</span>
            <div>
                <a href="{{ route('admin.reports.sales_by_category.pdf', ['limit' => $limit, 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="export-btn pdf"><i class="fas fa-file-pdf"></i> {{ __('Export as PDF') }}</a>
                <a href="{{ route('admin.reports.sales_by_category.excel', ['limit' => $limit, 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="export-btn excel"><i class="fas fa-file-excel"></i> {{ __('Export as Excel') }}</a>
            </div>
        </div>
        <div class="card-body">
            @if($topSalesByCategory->isEmpty())
                <p class="error-message">{{ __('No category sales data available.') }}</p>
            @else
                <div class="chart-container">
                    <canvas id="salesByCategoryChart"></canvas>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Total Sales ($)') }}</th>
                            <th>{{ __('Order Count') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topSalesByCategory as $category)
                            <tr>
                                <td>{{ $category->category_name }}</td>
                                <td>${{ number_format($category->total_sales, 2) }}</td>
                                <td>{{ $category->order_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    if (typeof Chart === 'undefined') {
        console.error('Chart.js failed to load. Check the CDN or include the script locally.');
    } else {
        // Top Sales by Area Chart (Bar)
        @if(!$topSalesByArea->isEmpty())
            try {
                const salesByAreaCtx = document.getElementById('salesByAreaChart');
                if (salesByAreaCtx) {
                    new Chart(salesByAreaCtx, {
                        type: 'bar',
                        data: {
                            labels: [@foreach($topSalesByArea as $area)"{{ addslashes($area->area ?? __('Unknown')) }}",@endforeach],
                            datasets: [{
                                label: '{{ __('Total Sales ($)') }}',
                                data: [@foreach($topSalesByArea as $area){{ $area->total_sales }},@endforeach],
                                backgroundColor: '#7f1d1d',
                                borderColor: '#7f1d1d',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: { beginAtZero: true, ticks: { color: '#1e293b' }, grid: { color: '#e5e7eb' } },
                                x: { ticks: { color: '#1e293b' }, grid: { display: false } }
                            },
                            plugins: {
                                legend: { display: false },
                                tooltip: { backgroundColor: '#1e293b', titleFont: { size: 12 }, bodyFont: { size: 12 } }
                            }
                        }
                    });
                } else {
                    console.error('Sales by Area Chart canvas not found.');
                }
            } catch (e) {
                console.error('Error initializing Sales by Area Chart:', e);
            }
        @else
            console.warn('Sales by Area Chart: No valid data available.');
        @endif

        // Top Sales by Product Chart (Bar)
        @if(!$topSalesByProduct->isEmpty())
            try {
                const salesByProductCtx = document.getElementById('salesByProductChart');
                if (salesByProductCtx) {
                    new Chart(salesByProductCtx, {
                        type: 'bar',
                        data: {
                            labels: [@foreach($topSalesByProduct as $product)"{{ addslashes($product->product_name) }}",@endforeach],
                            datasets: [{
                                label: '{{ __('Total Sales ($)') }}',
                                data: [@foreach($topSalesByProduct as $product){{ $product->total_sales }},@endforeach],
                                backgroundColor: '#7f1d1d',
                                borderColor: '#7f1d1d',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: { beginAtZero: true, ticks: { color: '#1e293b' }, grid: { color: '#e5e7eb' } },
                                x: { ticks: { color: '#1e293b' }, grid: { display: false } }
                            },
                            plugins: {
                                legend: { display: false },
                                tooltip: { backgroundColor: '#1e293b', titleFont: { size: 12 }, bodyFont: { size: 12 } }
                            }
                        }
                    });
                } else {
                    console.error('Sales by Product Chart canvas not found.');
                }
            } catch (e) {
                console.error('Error initializing Sales by Product Chart:', e);
            }
        @else
            console.warn('Sales by Product Chart: No valid data available.');
        @endif

        // Top Payer by Client Chart (Bar)
        @if(!$topPayersByClient->isEmpty())
            try {
                const payersByClientCtx = document.getElementById('payersByClientChart');
                if (payersByClientCtx) {
                    new Chart(payersByClientCtx, {
                        type: 'bar',
                        data: {
                            labels: [@foreach($topPayersByClient as $client)"{{ addslashes($client->name) }}",@endforeach],
                            datasets: [{
                                label: '{{ __('Total Spent ($)') }}',
                                data: [@foreach($topPayersByClient as $client){{ $client->total_spent }},@endforeach],
                                backgroundColor: '#7f1d1d',
                                borderColor: '#7f1d1d',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: { beginAtZero: true, ticks: { color: '#1e293b' }, grid: { color: '#e5e7eb' } },
                                x: { ticks: { color: '#1e293b' }, grid: { display: false } }
                            },
                            plugins: {
                                legend: { display: false },
                                tooltip: { backgroundColor: '#1e293b', titleFont: { size: 12 }, bodyFont: { size: 12 } }
                            }
                        }
                    });
                } else {
                    console.error('Payers by Client Chart canvas not found.');
                }
            } catch (e) {
                console.error('Error initializing Payers by Client Chart:', e);
            }
        @else
            console.warn('Payers by Client Chart: No valid data available.');
        @endif

        // Top Payer by Gender Chart (Pie)
        @if(!empty($topPayersByGender))
            try {
                const payersByGenderCtx = document.getElementById('payersByGenderChart');
                if (payersByGenderCtx) {
                    new Chart(payersByGenderCtx, {
                        type: 'pie',
                        data: {
                            labels: ['{{ __('Male') }}', '{{ __('Female') }}'],
                            datasets: [{
                                data: [
                                    {{ $topPayersByGender['male']['total_spent'] ?? 0 }},
                                    {{ $topPayersByGender['female']['total_spent'] ?? 0 }}
                                ],
                                backgroundColor: ['#3b82f6', '#f59e0b'],
                                borderColor: '#ffffff',
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: { font: { size: 12 }, color: '#1e293b' }
                                },
                                tooltip: { backgroundColor: '#1e293b', titleFont: { size: 12 }, bodyFont: { size: 12 } }
                            }
                        }
                    });
                } else {
                    console.error('Payers by Gender Chart canvas not found.');
                }
            } catch (e) {
                console.error('Error initializing Payers by Gender Chart:', e);
            }
        @else
            console.warn('Payers by Gender Chart: No valid data available.');
        @endif

        // Top Sales by Category Chart (Bar)
        @if(!$topSalesByCategory->isEmpty())
            try {
                const salesByCategoryCtx = document.getElementById('salesByCategoryChart');
                if (salesByCategoryCtx) {
                    new Chart(salesByCategoryCtx, {
                        type: 'bar',
                        data: {
                            labels: [@foreach($topSalesByCategory as $category)"{{ addslashes($category->category_name) }}",@endforeach],
                            datasets: [{
                                label: '{{ __('Total Sales ($)') }}',
                                data: [@foreach($topSalesByCategory as $category){{ $category->total_sales }},@endforeach],
                                backgroundColor: '#7f1d1d',
                                borderColor: '#7f1d1d',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: { beginAtZero: true, ticks: { color: '#1e293b' }, grid: { color: '#e5e7eb' } },
                                x: { ticks: { color: '#1e293b' }, grid: { display: false } }
                            },
                            plugins: {
                                legend: { display: false },
                                tooltip: { backgroundColor: '#1e293b', titleFont: { size: 12 }, bodyFont: { size: 12 } }
                            }
                        }
                    });
                } else {
                    console.error('Sales by Category Chart canvas not found.');
                }
            } catch (e) {
                console.error('Error initializing Sales by Category Chart:', e);
            }
        @else
            console.warn('Sales by Category Chart: No valid data available.');
        @endif
    }
</script>
@endsection
