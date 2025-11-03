@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Orders Management</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" placeholder="Search by order ID or customer name" id="searchInput">
                            <div class="input-group-append">
                                <button class="btn btn-default" type="button" onclick="applyFilters()">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filters -->
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-3">
                                <select class="form-control" id="statusFilter">
                                    <option value="">All Statuses</option>
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="shipped">Shipped</option>
                                    <option value="delivered">Delivered</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" id="paymentStatusFilter">
                                    <option value="">All Payment Statuses</option>
                                    <option value="unpaid">Unpaid</option>
                                    <option value="paid">Paid</option>
                                    <option value="failed">Failed</option>
                                    <option value="refunded">Refunded</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" id="deliveryStatusFilter">
                                    <option value="">All Delivery Statuses</option>
                                    <option value="not_started">Not Started</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="delivered">Delivered</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="failed">Failed</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary btn-block" onclick="applyFilters()">Apply Filters</button>
                            </div>
                        </div>
                    </div>

                    <!-- Orders Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Email</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Delivery</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->full_name }}</td>
                                        <td>{{ $order->email }}</td>
                                        <td>{{ number_format($order->total, 2) }}</td>
                                        <td>
                                            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="update-status-form">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="update-payment-status-form">
                                                @csrf
                                                @method('PATCH')
                                                <select name="payment_status" class="form-control form-control-sm" onchange="this.form.submit()">
                                                    <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                                    <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                                    <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                                                    <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="update-delivery-status-form">
                                                @csrf
                                                @method('PATCH')
                                                <select name="delivery_status" class="form-control form-control-sm" onchange="this.form.submit()">
                                                    <option value="not_started" {{ $order->delivery_status == 'not_started' ? 'selected' : '' }}>Not Started</option>
                                                    <option value="in_progress" {{ $order->delivery_status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                    <option value="delivered" {{ $order->delivery_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                    <option value="cancelled" {{ $order->delivery_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                    <option value="failed" {{ $order->delivery_status == 'failed' ? 'selected' : '' }}>Failed</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info">View</a>
                                            <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No orders found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function applyFilters() {
        const status = document.getElementById('statusFilter').value;
        const paymentStatus = document.getElementById('paymentStatusFilter').value;
        const deliveryStatus = document.getElementById('deliveryStatusFilter').value;
        const search = document.getElementById('searchInput').value;

        let url = '{{ route("admin.orders.index") }}?';
        if (status) url += `status=${status}&`;
        if (paymentStatus) url += `payment_status=${paymentStatus}&`;
        if (deliveryStatus) url += `delivery_status=${deliveryStatus}&`;
        if (search) url += `search=${search}&`;

        window.location.href = url;
    }

    // Search on enter
    document.getElementById('searchInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            applyFilters();
        }
    });

    // Prevent multiple form submissions
    document.querySelectorAll('.update-status-form, .update-payment-status-form, .update-delivery-status-form').forEach(form => {
        form.addEventListener('submit', function() {
            const select = form.querySelector('select');
            select.disabled = true; // Disable to prevent double submission
            setTimeout(() => { select.disabled = false; }, 2000); // Re-enable after 2 seconds
        });
    });
</script>
@endsection
