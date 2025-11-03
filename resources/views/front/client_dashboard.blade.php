@extends('front.layouts.app')

@section('content')
<x-hero-section-component pageTitle="client_dashboard" />
<style>
    .dashboard-section {
        padding: 50px 0;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
    }

    .section-title {
        color: #8b3a2b;
        font-weight: 700;
        margin-bottom: 30px;
        font-size: 2rem;
        text-align: center;
        animation: fadeIn 0.5s ease-in;
    }

    .dashboard-card {
        background: #fff;
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        animation: slideUp 0.6s ease-out;
        max-width: 1000px;
        margin: 0 auto;
    }

    .dashboard-card h3 {
        color: #2e3a59;
        font-weight: 600;
        margin-bottom: 20px;
    }

    .dashboard-card p {
        color: #2e3a59;
        font-size: 1rem;
        margin-bottom: 10px;
    }

    .dashboard-card .btn {
        background: #8b3a2b;
        border-color: #8b3a2b;
        color: #fff;
        padding: 10px 20px;
        font-size: 0.95rem;
        border-radius: 6px;
        transition: background 0.3s, transform 0.3s, box-shadow 0.3s;
        margin-right: 10px;
    }

    .dashboard-card .btn:hover {
        background: #2e3a59;
        border-color: #2e3a59;
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .orders-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .orders-table th, .orders-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #e9ecef;
    }

    .orders-table th {
        background: #2e3a59;
        color: #fff;
        font-weight: 600;
    }

    .orders-table td {
        color: #2e3a59;
    }

    .orders-table tr:hover {
        background: #f8f9fa;
    }

    .filter-section {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
        justify-content: space-between;
        align-items: center;
    }

    .filter-section select {
        padding: 10px;
        border-radius: 6px;
        border: 1px solid #e9ecef;
        font-size: 0.95rem;
        color: #2e3a59;
        min-width: 150px;
    }

    .status-badge {
        padding: 5px 10px;
        border-radius: 12px;
        font-size: 0.85rem;
        color: #fff;
        display: inline-block;
    }

    .status-pending { background: #ffc107; }
    .status-confirmed { background: #17a2b8; }
    .status-shipped { background: #007bff; }
    .status-delivered { background: #28a745; }
    .status-cancelled { background: #dc3545; }
    .status-unpaid { background: #6c757d; }
    .status-paid { background: #28a745; }
    .status-failed { background: #dc3545; }
    .status-refunded { background: #6c757d; }
    .status-not_started { background: #6c757d; }
    .status-in_progress { background: #007bff; }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    /* Improved Responsive Design */
    @media (max-width: 768px) {
        .dashboard-section {
            padding: 20px 10px;
        }

        .section-title {
            font-size: 1.75rem;
        }

        .dashboard-card {
            padding: 15px;
        }

        .filter-section {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-section select {
            width: 100%;
        }

        .orders-table {
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }

        .orders-table th, .orders-table td {
            font-size: 0.85rem;
            padding: 8px;
        }

        .dashboard-card .btn {
            width: 100%;
            margin-bottom: 10px;
        }
    }

    @media (max-width: 576px) {
        .section-title {
            font-size: 1.5rem;
        }

        .orders-table th, .orders-table td {
            font-size: 0.8rem;
            padding: 6px;
        }
    }
</style>

<body class="bg-light">
    <div class="container dashboard-section">
        <h2 class="section-title">Client Dashboard</h2>

        <div class="dashboard-card">
            <h3>Welcome, {{ Auth::guard('client')->user()->name ?? 'Guest' }}</h3>
            <p><strong>Email:</strong> {{ Auth::guard('client')->user()->email ?? 'N/A' }}</p>
            <p><strong>Phone Number:</strong> {{ Auth::guard('client')->user()->phone_number ?? 'Not provided' }}</p>
            <p><strong>Shipping Address:</strong> {{ Auth::guard('client')->user()->shipping_address ?? 'Not provided' }}</p>
            <p><strong>Billing Address:</strong> {{ Auth::guard('client')->user()->billing_address ?? 'Not provided' }}</p>
            <p><strong>Preferred Payment Method:</strong> {{ Auth::guard('client')->user()->preferred_payment_method ?? 'Not provided' }}</p>
            <p><strong>Area:</strong> {{ Auth::guard('client')->user()->area ?? 'Not provided' }}</p> <!-- Added Area Display -->

            <div class="mt-4">
                <a href="#" class="btn">Edit Profile</a>
                <form action="{{ route('client.logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn">Logout</button>
                </form>
            </div>

            <h3 class="mt-5">Your Orders</h3>
            <!-- Filter Section -->
            <div class="filter-section">
                <form action="{{ route('client.dashboard') }}" method="GET">
                    <select name="status" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </form>
            </div>

            @if ($orders->isEmpty())
                <p>No orders found.</p>
            @else
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Payment Method</th>
                            <th>Payment Status</th>
                            <th>Delivery Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td>${{ number_format($order->total, 2) }}</td>
                                <td><span class="status-badge status-{{ $order->status }}">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span></td>
                                <td>{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</td>
                                <td><span class="status-badge status-{{ $order->payment_status }}">{{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}</span></td>
                                <td><span class="status-badge status-{{ $order->delivery_status }}">{{ ucfirst(str_replace('_', ' ', $order->delivery_status)) }}</span></td>
                                <td>
                                    <a href="{{ route('confirmation.index', $order->id) }}" class="btn btn-sm">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</body>

@endsection
