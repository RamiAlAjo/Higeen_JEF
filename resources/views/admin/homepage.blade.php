@extends('admin.layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<style>
    body {
        background-color: #f1f5f9;
        color: #1e293b;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 20px;
    }

    .dashboard-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1e293b;
        text-align: center;
        margin-bottom: 25px;
        animation: fadeIn 0.8s ease-in;
    }

    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        background-color: #ffffff;
        overflow: hidden;
        cursor: pointer;
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
    }

    .card-header {
        background: linear-gradient(135deg, #9e6de0 0%, #7c3aed 100%);
        color: #ffffff;
        font-weight: 600;
        border-radius: 10px 10px 0 0;
        padding: 10px;
        font-size: 0.95rem;
        text-align: center;
    }

    .card-body {
        padding: 12px;
    }

    .card-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 6px;
        color: #1e293b;
    }

    .card-text {
        font-size: 1.4rem;
        font-weight: 700;
        color: #7f1d1d;
    }

    .list-group-item {
        border: none;
        padding: 8px 12px;
        font-size: 0.9rem;
        transition: background-color 0.3s ease;
        border-bottom: 1px solid #e5e7eb;
    }

    .list-group-item:last-child {
        border-bottom: none;
    }

    .list-group-item:hover {
        background-color: #f8fafc;
    }

    .table {
        background-color: #ffffff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    }

    .table thead {
        background: #f1f5f9;
    }

    .table th, .table td {
        padding: 10px;
        font-size: 0.9rem;
        vertical-align: middle;
    }

    .table th {
        font-weight: 600;
        color: #1e293b;
    }

    .table td {
        color: #4b5563;
    }

    .badge {
        font-size: 0.8rem;
        padding: 5px 10px;
        border-radius: 12px;
    }

    .badge-pending { background-color: #f59e0b; color: #ffffff; }
    .badge-confirmed { background-color: #3b82f6; color: #ffffff; }
    .badge-shipped { background-color: #8b5cf6; color: #ffffff; }
    .badge-delivered { background-color: #16a34a; color: #ffffff; }
    .badge-cancelled { background-color: #dc2626; color: #ffffff; }

    a {
        color: #7f1d1d;
        text-decoration: none;
        transition: color 0.3s;
    }

    a:hover {
        color: #991b1b;
        text-decoration: underline;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
        gap: 12px;
        margin-bottom: 25px;
    }

    .chart-container {
        max-width: 500px;
        margin: 0 auto 20px;
        position: relative;
    }

    .section-title {
        font-size: 1.4rem;
        font-weight: 600;
        color: #1e293b;
        margin: 20px 0 12px;
        text-align: center;
    }

    .gender-stats, .payment-stats {
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-top: 8px;
    }

    .gender-stats span, .payment-stats span {
        font-size: 0.85rem;
        color: #4b5563;
        background: #f8fafc;
        padding: 4px 8px;
        border-radius: 6px;
    }

    .error-message {
        color: #dc2626;
        font-size: 0.9rem;
        text-align: center;
        margin-top: 10px;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .dashboard-title {
            font-size: 1.6rem;
        }

        .card {
            margin-bottom: 12px;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .table {
            font-size: 0.8rem;
        }

        .chart-container {
            max-width: 100%;
        }

        .section-title {
            font-size: 1.2rem;
        }
    }
</style>

<div class="container">
    <h1 class="dashboard-title">Admin Dashboard</h1>

    <!-- Debug Data (Uncomment for debugging, remove in production) -->
    <!--
    <div class="card mb-4">
        <div class="card-header">Debug Data</div>
        <div class="card-body">
            <pre>Order Status: {{ print_r($orderStatusDistribution, true) }}</pre>
            <pre>Top Products: {{ print_r($topProducts->toArray(), true) }}</pre>
            <pre>Monthly Revenue: {{ print_r($monthlyRevenue->toArray(), true) }}</pre>
        </div>
    </div>
    -->

    <!-- Welcome Card -->
    <div class="card mb-4">
        <div class="card-header">Welcome</div>
        <div class="card-body">
            <h5 class="card-title">Hello, {{ $user->name }}</h5>
            <p class="card-text">Overview of your system's activity.</p>
        </div>
    </div>

    <!-- Statistics Grid -->
    <div class="stats-grid">
        <!-- Total Clients -->
        <div class="card" onclick="window.location.href='#'" title="View all clients">
            <div class="card-header">Total Clients</div>
            <div class="card-body">
                <h5 class="card-title">Registered Users</h5>
                <p class="card-text">{{ $totalClients }}</p>
            </div>
        </div>

        <!-- Total Products -->
        <div class="card" onclick="window.location.href='#'" title="View all products">
            <div class="card-header">Total Products</div>
            <div class="card-body">
                <h5 class="card-title">Available Products</h5>
                <p class="card-text">{{ $totalProducts }}</p>
            </div>
        </div>

        <!-- Active Products -->
        <div class="card" onclick="window.location.href='#'" title="View active products">
            <div class="card-header">Active Products</div>
            <div class="card-body">
                <h5 class="card-title">Published Products</h5>
                <p class="card-text">{{ $activeProducts }}</p>
            </div>
        </div>

        <!-- Low Stock Products -->
        <div class="card" onclick="window.location.href='#'" title="View low stock products">
            <div class="card-header">Low Stock</div>
            <div class="card-body">
                <h5 class="card-title">Products (≤10)</h5>
                <p class="card-text">{{ $lowStockProducts }}</p>
            </div>
        </div>

        <!-- Total Categories -->
        <div class="card" onclick="window.location.href='#'" title="View all categories">
            <div class="card-header">Categories</div>
            <div class="card-body">
                <h5 class="card-title">Product Categories</h5>
                <p class="card-text">{{ $totalCategories }}</p>
            </div>
        </div>

        <!-- Total Subcategories -->
        <div class="card" onclick="window.location.href='#'" title="View all subcategories">
            <div class="card-header">Subcategories</div>
            <div class="card-body">
                <h5 class="card-title">Product Subcategories</h5>
                <p class="card-text">{{ $totalSubcategories }}</p>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="card" onclick="window.location.href='#'" title="View all orders">
            <div class="card-header">Total Orders</div>
            <div class="card-body">
                <h5 class="card-title">All Orders</h5>
                <p class="card-text">{{ $totalOrders }}</p>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="card" onclick="window.location.href='#'" title="View pending orders">
            <div class="card-header">Pending Orders</div>
            <div class="card-body">
                <h5 class="card-title">Awaiting Action</h5>
                <p class="card-text">{{ $pendingOrders }}</p>
            </div>
        </div>

        <!-- Delivered Orders -->
        <div class="card" onclick="window.location.href='#'" title="View delivered orders">
            <div class="card-header">Delivered Orders</div>
            <div class="card-body">
                <h5 class="card-title">Completed Orders</h5>
                <p class="card-text">{{ $deliveredOrders }}</p>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="card" onclick="window.location.href='#'" title="View paid orders">
            <div class="card-header">Total Revenue</div>
            <div class="card-body">
                <h5 class="card-title">Paid Orders</h5>
                <p class="card-text">${{ number_format($totalRevenue, 2) }}</p>
            </div>
        </div>
    </div>

    <!-- Client Gender Distribution -->
    <h2 class="section-title">Client Demographics</h2>
    <div class="card mb-4">
        <div class="card-header">Gender Distribution</div>
        <div class="card-body">
            @if(empty($genderDistribution))
                <p class="text-center">No gender data available.</p>
            @else
                <div class="gender-stats">
                    <span>Male: {{ $genderDistribution['male'] ?? 0 }}</span>
                    <span>Female: {{ $genderDistribution['female'] ?? 0 }}</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Payment Method Distribution -->
    <h2 class="section-title">Payment Method Distribution</h2>
    <div class="card mb-4">
        <div class="card-header">Payment Methods Used</div>
        <div class="card-body">
            @if(empty($paymentMethodDistribution))
                <p class="text-center">No payment method data available.</p>
            @else
                <div class="payment-stats">
                    @foreach(['cod' => 'Cash on Delivery', 'card' => 'Card', 'paypal' => 'PayPal', 'stripe' => 'Stripe', 'bank_transfer' => 'Bank Transfer', 'apple_pay' => 'Apple Pay', 'google_pay' => 'Google Pay', 'wallet' => 'Wallet', 'klarna' => 'Klarna', 'cash' => 'Cash'] as $key => $label)
                        @if(isset($paymentMethodDistribution[$key]))
                            <span>{{ $label }}: {{ $paymentMethodDistribution[$key] }}</span>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Monthly Revenue Chart -->
    <h2 class="section-title">Revenue Trend</h2>
    <div class="card mb-4">
        <div class="card-header">Monthly Revenue (Last 6 Months)</div>
        <div class="card-body">
            @if($monthlyRevenue->isEmpty() || $monthlyRevenue->sum('revenue') == 0)
                <p class="text-center">No revenue data available.</p>
            @else
                <div class="chart-container">
                    <canvas id="monthlyRevenueChart"></canvas>
                </div>
            @endif
        </div>
    </div>

    <!-- Order Status Chart -->
    <h2 class="section-title">Order Status Distribution</h2>
    <div class="card mb-4">
        <div class="card-header">Order Status Overview</div>
        <div class="card-body">
            @if(empty($orderStatusDistribution) || array_sum($orderStatusDistribution) == 0)
                <p class="text-center">No order data available.</p>
            @else
                <div class="chart-container">
                    <canvas id="orderStatusChart"></canvas>
                </div>
            @endif
        </div>
    </div>

    <!-- Top Selling Products -->
    <h2 class="section-title">Top Selling Products</h2>
    <div class="card mb-4">
        <div class="card-header">Top 5 Products by Orders</div>
        <div class="card-body">
            @if($topProducts->isEmpty() || $topProducts->sum('order_count') == 0)
                <p class="text-center">No product sales data available.</p>
            @else
                <div class="chart-container">
                    <canvas id="topProductsChart"></canvas>
                </div>
                <ul class="list-group mt-3">
                    @foreach($topProducts as $product)
                        <li class="list-group-item">
                            {{ $product->product_name_en }}
                            <span class="float-end">{{ $product->order_count }} {{ $product->order_count == 1 ? 'order' : 'orders' }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <!-- Recent Orders -->
    <h2 class="section-title">Recent Orders</h2>
    <div class="card mb-4">
        <div class="card-header">Latest Orders</div>
        <div class="card-body">
            @if($recentOrders->isEmpty())
                <p class="text-center">No recent orders found.</p>
            @else
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Client</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                            <tr onclick="window.location.href='#'" style="cursor: pointer;" title="View order details">
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->full_name }}</td>
                                <td>${{ number_format($order->total, 2) }}</td>
                                <td>
                                    <span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                                </td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- Recent Clients -->
    <h2 class="section-title">Recent Clients</h2>
    <div class="card mb-4">
        <div class="card-header">Newly Registered Clients</div>
        <div class="card-body">
            @if($recentClients->isEmpty())
                <p class="text-center">No recent clients found.</p>
            @else
                <ul class="list-group">
                    @foreach($recentClients as $client)
                        <li class="list-group-item">
                            <a href="#">{{ $client->name }}</a>
                            <span class="text-muted"> ({{ $client->email }})</span>
                            <small class="float-end">{{ $client->created_at->format('M d, Y') }}</small>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
<!-- Chart.js (correct UMD version) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    // Ensure Chart.js is loaded
    if (typeof Chart === 'undefined') {
        console.error('Chart.js failed to load. Check the CDN or include the script locally.');
    } else {
        // Chart rendering logic here...
    }
</script>

<script>
    // Ensure Chart.js is loaded
    if (typeof Chart === 'undefined') {
        console.error('Chart.js failed to load. Check the CDN or include the script locally.');
    } else {
        // Order Status Chart (Pie)
        @if(!empty($orderStatusDistribution) && array_sum($orderStatusDistribution) > 0)
            try {
                const orderStatusCtx = document.getElementById('orderStatusChart');
                if (orderStatusCtx) {
                    new Chart(orderStatusCtx, {
                        type: 'pie',
                        data: {
                            labels: ['Pending', 'Confirmed', 'Shipped', 'Delivered', 'Cancelled'],
                            datasets: [{
                                data: [
                                    {{ $orderStatusDistribution['pending'] ?? 0 }},
                                    {{ $orderStatusDistribution['confirmed'] ?? 0 }},
                                    {{ $orderStatusDistribution['shipped'] ?? 0 }},
                                    {{ $orderStatusDistribution['delivered'] ?? 0 }},
                                    {{ $orderStatusDistribution['cancelled'] ?? 0 }}
                                ],
                                backgroundColor: ['#f59e0b', '#3b82f6', '#8b5cf6', '#16a34a', '#dc2626'],
                                borderColor: '#ffffff',
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        font: { size: 12 },
                                        color: '#1e293b'
                                    }
                                },
                                tooltip: {
                                    backgroundColor: '#1e293b',
                                    titleFont: { size: 12 },
                                    bodyFont: { size: 12 }
                                }
                            }
                        }
                    });
                } else {
                    console.error('Order Status Chart canvas not found.');
                }
            } catch (e) {
                console.error('Error initializing Order Status Chart:', e);
            }
        @else
            console.warn('Order Status Chart: No valid data available.');
        @endif

        // Monthly Revenue Chart (Line)
        @if(!$monthlyRevenue->isEmpty() && $monthlyRevenue->sum('revenue') > 0)
            try {
                const monthlyRevenueCtx = document.getElementById('monthlyRevenueChart');
                if (monthlyRevenueCtx) {
                    new Chart(monthlyRevenueCtx, {
                        type: 'line',
                        data: {
                            labels: [@foreach($monthlyRevenue as $data)"{{ $data->month }}",@endforeach],
                            datasets: [{
                                label: 'Revenue ($)',
                                data: [@foreach($monthlyRevenue as $data){{ $data->revenue }},@endforeach],
                                borderColor: '#7f1d1d',
                                backgroundColor: 'rgba(127, 29, 29, 0.1)',
                                fill: true,
                                tension: 0.4,
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: { color: '#1e293b' },
                                    grid: { color: '#e5e7eb' }
                                },
                                x: {
                                    ticks: { color: '#1e293b' },
                                    grid: { display: false }
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                    labels: {
                                        font: { size: 12 },
                                        color: '#1e293b'
                                    }
                                },
                                tooltip: {
                                    backgroundColor: '#1e293b',
                                    titleFont: { size: 12 },
                                    bodyFont: { size: 12 }
                                }
                            }
                        }
                    });
                } else {
                    console.error('Monthly Revenue Chart canvas not found.');
                }
            } catch (e) {
                console.error('Error initializing Monthly Revenue Chart:', e);
            }
        @else
            console.warn('Monthly Revenue Chart: No valid data available.');
        @endif

        // Top Selling Products Chart (Bar)
        @if(!$topProducts->isEmpty() && $topProducts->sum('order_count') > 0)
            try {
                const topProductsCtx = document.getElementById('topProductsChart');
                if (topProductsCtx) {
                    new Chart(topProductsCtx, {
                        type: 'bar',
                        data: {
                            labels: [@foreach($topProducts as $product)"{{ addslashes($product->product_name_en) }}",@endforeach],
                            datasets: [{
                                label: 'Number of Orders',
                                data: [@foreach($topProducts as $product){{ $product->order_count }},@endforeach],
                                backgroundColor: '#7f1d1d',
                                borderColor: '#7f1d1d',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: { stepSize: 1, color: '#1e293b' },
                                    grid: { color: '#e5e7eb' }
                                },
                                x: {
                                    ticks: { color: '#1e293b' },
                                    grid: { display: false }
                                }
                            },
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    backgroundColor: '#1e293b',
                                    titleFont: { size: 12 },
                                    bodyFont: { size: 12 }
                                }
                            }
                        }
                    });
                } else {
                    console.error('Top Products Chart canvas not found.');
                }
            } catch (e) {
                console.error('Error initializing Top Products Chart:', e);
            }
        @else
            console.warn('Top Products Chart: No valid data available.');
        @endif
    }
</script>

@endsection
