@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Client Details: {{ $client->name }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.clients.index') }}" class="btn btn-light btn-sm me-2">
                            <i class="fas fa-arrow-left"></i> Back to Clients
                        </a>
                        <a href="{{ route('admin.clients.edit', $client->id) }}" class="btn btn-light btn-sm">
                            <i class="fas fa-edit"></i> Edit Client
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row g-4">
                        <!-- Client Information -->
                        <div class="col-lg-6">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Client Information</h4>
                                    <table class="table table-hover table-borderless">
                                        <tr>
                                            <th class="text-muted">ID</th>
                                            <td>{{ $client->id }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Name</th>
                                            <td>{{ $client->name }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Email</th>
                                            <td>{{ $client->email }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Phone Number</th>
                                            <td>{{ $client->phone_number ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Gender</th>
                                            <td>{{ $client->gender ? ucfirst($client->gender) : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Date of Birth</th>
                                            <td>{{ $client->date_of_birth ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Area</th>
                                            <td>{{ $client->area ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Shipping Address</th>
                                            <td>{{ $client->shipping_address ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Billing Address</th>
                                            <td>{{ $client->billing_address ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Preferred Payment Method</th>
                                            <td>{{ $client->preferred_payment_method ? ucfirst(str_replace('_', ' ', $client->preferred_payment_method)) : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Avatar</th>
                                            <td>
                                                @if ($client->avatar)
                                                    <img src="{{ asset('storage/' . $client->avatar) }}" alt="Avatar" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <span class="text-muted">No avatar</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Created At</th>
                                            <td>{{ $client->created_at->format('Y-m-d H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Client Orders -->
                        <div class="col-lg-6">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Client Orders</h4>
                                    @if ($client->orders->isNotEmpty())
                                        <div class="table-responsive">
                                            <table class="table table-hover table-borderless">
                                                <thead>
                                                    <tr>
                                                        <th>Order ID</th>
                                                        <th>Total</th>
                                                        <th>Status</th>
                                                        <th>Payment Status</th>
                                                        <th>Delivery Status</th>
                                                        <th>Date</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($client->orders as $order)
                                                        <tr class="animate__animated animate__fadeIn">
                                                            <td>{{ $order->id }}</td>
                                                            <td>{{ number_format($order->total, 2) }}</td>
                                                            <td>
                                                                <span class="badge badge-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }}">
                                                                    {{ ucfirst($order->status) }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-{{ $order->payment_status == 'paid' ? 'success' : ($order->payment_status == 'failed' || $order->payment_status == 'refunded' ? 'danger' : 'warning') }}">
                                                                    {{ ucfirst($order->payment_status) }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-{{ $order->delivery_status == 'delivered' ? 'success' : ($order->delivery_status == 'cancelled' || $order->delivery_status == 'failed' ? 'danger' : 'warning') }}">
                                                                    {{ ucfirst(str_replace('_', ' ', $order->delivery_status)) }}
                                                                </span>
                                                            </td>
                                                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                                            <td>
                                                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info">
                                                                    <i class="fas fa-eye"></i> View
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <p class="text-muted">No orders found for this client.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        transition: transform 0.2s ease-in-out;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .table th {
        font-weight: 500;
    }
    .alert {
        border-radius: 0.5rem;
    }
    .badge {
        font-size: 0.9rem;
        padding: 0.5em 0.75em;
    }
</style>
@endsection
