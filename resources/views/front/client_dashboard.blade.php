@extends('front.layouts.app')

@section('content')
<x-hero-section-component pageTitle="client_dashboard" />

<style>
    :root {
        --primary: #8b3a2b;
        --secondary: #2e3a59;
        --light: #f8f9fa;
        --dark: #212529;
        --success: #28a745;
        --warning: #ffc107;
        --info: #17a2b8;
        --danger: #dc3545;
    }

    .dashboard-wrapper {
        padding: 60px 0;
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e9ee 100%);
        min-height: 100vh;
        font-family: 'Segoe UI', sans-serif;
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--secondary);
        text-align: center;
        margin-bottom: 40px;
        background: linear-gradient(to right, var(--primary), var(--secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: fadeInDown 0.8s ease-out;
    }

    .profile-card {
        background: #fff;
        border-radius: 16px;
        padding: 35px;
        box-shadow: 0 12px 35px rgba(0,0,0,0.1);
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .profile-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 8px;
        height: 100%;
        background: linear-gradient(to bottom, var(--primary), var(--secondary));
    }

    .profile-card:hover {
        transform: translateY(-10px);
    }

    .profile-header {
        display: flex;
        align-items: center;
        gap: 25px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .avatar-container {
        position: relative;
    }

    .avatar {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid #fff;
        box-shadow: 0 8px 20px rgba(139,58,43,0.2);
        background: #f0f0f0;
    }

    .avatar-fallback {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2.5rem;
        font-weight: bold;
        box-shadow: 0 8px 20px rgba(139,58,43,0.2);
    }

    .user-info h3 {
        margin: 0;
        color: var(--secondary);
        font-size: 1.9rem;
        font-weight: 700;
    }

    .user-info p {
        margin: 6px 0;
        color: #6c757d;
        font-size: 1rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 18px;
        margin: 30px 0;
    }

    .info-item {
        background: #f8f9fa;
        padding: 16px 20px;
        border-radius: 12px;
        border-left: 5px solid var(--primary);
        transition: all 0.3s;
    }

    .info-item:hover {
        background: #e9f5ff;
        transform: translateX(5px);
    }

    .info-item strong {
        color: var(--secondary);
        display: block;
        margin-bottom: 6px;
        font-size: 0.95rem;
        font-weight: 600;
    }

    .info-item span {
        color: #495057;
        font-size: 1rem;
    }

    .gender-icon {
        margin-right: 8px;
        font-size: 1.1rem;
    }

    .text-pink { color: #e91e63; }

    /* Stats Grid - Only 3 cards now */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin: 40px 0;
    }

    .stat-card {
        background: #fff;
        padding: 25px;
        border-radius: 14px;
        text-align: center;
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::after {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 100px;
        height: 100px;
        background: var(--primary);
        opacity: 0.05;
        border-radius: 50%;
        transform: translate(30%, -30%);
    }

    .stat-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(139, 58, 43, 0.15);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 15px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: white;
    }

    .stat-total { background: linear-gradient(135deg, #8b3a2b, #a04535); }
    .stat-pending { background: linear-gradient(135deg, #ffc107, #ffb300); }
    .stat-delivered { background: linear-gradient(135deg, #28a745, #218838); }

    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: var(--secondary);
        margin: 10px 0;
    }

    .stat-label {
        color: #6c757d;
        font-size: 0.95rem;
        font-weight: 500;
    }

    /* Orders Card */
    .orders-card {
        background: #fff;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        margin-top: 30px;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .card-header h3 {
        margin: 0;
        color: var(--secondary);
        font-size: 1.5rem;
    }

    .filter-select {
        padding: 10px 16px;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        font-size: 0.95rem;
        min-width: 180px;
        transition: all 0.3s;
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(139, 58, 43, 0.15);
    }

    .orders-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 12px;
    }

    .orders-table thead {
        background: var(--secondary);
        color: white;
    }

    .orders-table th {
        padding: 16px 12px;
        font-weight: 600;
        text-align: left;
    }

    .orders-table tbody tr {
        background: #f8f9fa;
        transition: all 0.3s ease;
    }

    .orders-table tbody tr:hover {
        background: #e9f5ff;
        transform: scale(1.01);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }

    .orders-table td {
        padding: 16px 12px;
        color: var(--dark);
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.88rem;
        font-weight: 600;
        text-transform: capitalize;
    }

    .status-pending { background: #ffc107; color: #212529; }
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

    .btn-view {
        background: var(--primary);
        color: white;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.3s;
        display: inline-block;
    }

    .btn-view:hover {
        background: var(--secondary);
        transform: translateY(-2px);
    }

    .btn-edit, .btn-logout {
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s;
        margin-right: 12px;
        text-decoration: none;
        display: inline-block;
    }

    .btn-edit {
        background: var(--secondary);
        color: white;
    }

    .btn-logout {
        background: #dc3545;
        color: white;
        border: none;
        cursor: pointer;
    }

    .btn-edit:hover, .btn-logout:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .section-title { font-size: 2rem; }
        .profile-header { flex-direction: column; text-align: center; }
        .info-grid { grid-template-columns: 1fr; }
        .stats-grid { grid-template-columns: repeat(3, 1fr); }
        .card-header { flex-direction: column; align-items: stretch; }
        .filter-select { width: 100%; }

        .orders-table thead { display: none; }
        .orders-table tbody tr {
            display: block;
            margin-bottom: 20px;
            background: #f8f9fa;
            border-radius: 12px;
            padding: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .orders-table td {
            display: block;
            text-align: right;
            padding: 8px 0;
            border: none;
        }
        .orders-table td::before {
            content: attr(data-label) ": ";
            float: left;
            font-weight: 600;
            color: var(--secondary);
        }
    }

    @media (max-width: 576px) {
        .stats-grid { grid-template-columns: 1fr; }
    }

    .avatar-container {
        position: relative;
    }

    .avatar {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid #fff;
        box-shadow: 0 8px 20px rgba(139,58,43,0.2);
        background: #f0f0f0;
    }

    .avatar-fallback {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2.5rem;
        font-weight: bold;
        box-shadow: 0 8px 20px rgba(139,58,43,0.2);
    }

    /* Add this for better mobile avatar */
    @media (max-width: 768px) {
        .avatar, .avatar-fallback {
            width: 90px;
            height: 90px;
            font-size: 2rem;
        }
    }
</style>

<div class="container dashboard-wrapper">
    <h2 class="section-title">Client Dashboard</h2>

    <!-- Profile Card -->
    <div class="profile-card">
        <div class="profile-header">
            <div class="avatar-container">
                @php
                    $client = Auth::guard('client')->user();
                    $avatarPath = $client->avatar ? public_path('uploads/avatars/' . $client->avatar) : null;
                @endphp

                @if($client->avatar && file_exists($avatarPath))
                    <img src="{{ asset('uploads/avatars/' . $client->avatar) }}" alt="Avatar" class="avatar">
                @else
                    <div class="avatar-fallback">
                        {{ substr($client->name ?? 'G', 0, 1) }}
                    </div>
                @endif
            </div>

            <div class="user-info">
                <h3>Welcome back, {{ $client->name ?? 'Guest' }}!</h3>
                <p>Here's your account overview</p>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-item">
                <strong>Email</strong>
                <span>{{ $client->email ?? 'N/A' }}</span>
            </div>

            <div class="info-item">
                <strong>Phone Number</strong>
                <span>{{ $client->phone_number ?? 'Not provided' }}</span>
            </div>

            <div class="info-item">
                <strong>Gender</strong>
                <span>
                    @if($client->gender)
                        <i class="fas fa-{{ $client->gender == 'male' ? 'mars text-primary' : 'venus text-pink' }} gender-icon"></i>
                        {{ ucfirst($client->gender) }}
                    @else
                        Not specified
                    @endif
                </span>
            </div>

            <div class="info-item">
                <strong>Date of Birth</strong>
                <span>
                    @if($client->date_of_birth)
                        @php
                            $dob = is_string($client->date_of_birth)
                                ? \Carbon\Carbon::parse($client->date_of_birth)
                                : $client->date_of_birth;
                        @endphp
                        {{ $dob->format('M d, Y') }}
                        <small class="text-muted">(Age {{ $dob->age }})</small>
                    @else
                        Not provided
                    @endif
                </span>
            </div>

            <div class="info-item">
                <strong>Shipping Address</strong>
                <span>{{ $client->shipping_address ?? 'Not set' }}</span>
            </div>

            <div class="info-item">
                <strong>Billing Address</strong>
                <span>{{ $client->billing_address ?? 'Same as shipping' }}</span>
            </div>

            <div class="info-item">
                <strong>Area / City</strong>
                <span>{{ $client->area ?? 'Not specified' }}</span>
            </div>

            <div class="info-item">
                <strong>Preferred Payment</strong>
                <span>{{ ucfirst(str_replace('_', ' ', $client->preferred_payment_method ?? 'Not set')) }}</span>
            </div>
        </div>

        <div class="mt-4">
            <a href="#" class="btn-edit">Edit Profile</a>
            <form action="{{ route('client.logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </div>

    <!-- Stats Grid - Only 3 Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon stat-total"><i class="fas fa-shopping-bag"></i></div>
            <div class="stat-value">{{ $orders->count() }}</div>
            <div class="stat-label">Total Orders</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-pending"><i class="fas fa-clock"></i></div>
            <div class="stat-value">{{ $orders->where('status', 'pending')->count() }}</div>
            <div class="stat-label">Pending Orders</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-delivered"><i class="fas fa-check-circle"></i></div>
            <div class="stat-value">{{ $orders->where('status', 'delivered')->count() }}</div>
            <div class="stat-label">Delivered Orders</div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="orders-card">
        <div class="card-header">
            <h3>Your Recent Orders</h3>
            <form action="{{ route('client.dashboard') }}" method="GET">
                <select name="status" class="filter-select" onchange="this.form.submit()">
                    <option value="">All Orders</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </form>
        </div>

        @if ($orders->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                <p class="text-muted h5">No orders yet. Time to shop!</p>
                <a href="{{ route('front.product') }}" class="btn-edit mt-3">Start Shopping</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Delivery</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td data-label="Order">#{{ $order->id }}</td>
                                <td data-label="Date">{{ $order->created_at->format('M d, Y') }}</td>
                                <td data-label="Total">${{ number_format($order->total, 2) }}</td>
                                <td data-label="Status">
                                    <span class="status-badge status-{{ $order->status }}">
                                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                </td>
                                <td data-label="Payment">
                                    <span class="status-badge status-{{ $order->payment_status }}">
                                        {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                                    </span>
                                </td>
                                <td data-label="Delivery">
                                    <span class="status-badge status-{{ $order->delivery_status }}">
                                        {{ ucfirst(str_replace('_', ' ', $order->delivery_status)) }}
                                    </span>
                                </td>
                                <td data-label="Action">
                                    <a href="{{ route('confirmation.index', $order->id) }}" class="btn-view">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@endsection
