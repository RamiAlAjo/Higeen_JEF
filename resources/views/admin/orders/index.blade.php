@extends('admin.layouts.app')

@section('title', 'Orders Management')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Orders Management</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <input type="text" class="form-control" placeholder="Search by ID or name" id="searchInput">
                            <button class="btn btn-light" onclick="applyFilters()">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filters -->
                    <div class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <select class="form-select" id="statusFilter">
                                    <option value="">All Statuses</option>
                                    @foreach(['pending','confirmed','shipped','delivered','cancelled'] as $s)
                                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>
                                            {{ ucfirst($s) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="paymentStatusFilter">
                                    <option value="">All Payment</option>
                                    @foreach(['unpaid','paid','failed','refunded'] as $p)
                                        <option value="{{ $p }}" {{ request('payment_status') == $p ? 'selected' : '' }}>
                                            {{ ucfirst($p) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="deliveryStatusFilter">
                                    <option value="">All Delivery</option>
                                    @foreach(['not_started','in_progress','delivered','cancelled','failed'] as $d)
                                        <option value="{{ $d }}" {{ request('delivery_status') == $d ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('_', ' ', $d)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary w-100" onclick="applyFilters()">Apply</button>
                            </div>
                        </div>
                    </div>

                    <!-- Orders Table -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
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
                                        <td><strong>#{{ $order->id }}</strong></td>
                                        <td>{{ $order->full_name }}</td>
                                        <td>{{ $order->email }}</td>
                                        <td><strong>{{ number_format($order->total, 2) }} JOD</strong></td>

                                        <!-- Status -->
                                        <td>
                                            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="d-inline update-form">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="field" value="status">
                                                <select name="value" class="form-select form-select-sm status-select"
                                                        onchange="updateField(this)">
                                                    @foreach(['pending','confirmed','shipped','delivered','cancelled'] as $s)
                                                        <option value="{{ $s }}" {{ $order->status == $s ? 'selected' : '' }}>
                                                            {{ ucfirst($s) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </td>

                                        <!-- Payment Status -->
                                        <td>
                                            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="d-inline update-form">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="field" value="payment_status">
                                                <select name="value" class="form-select form-select-sm payment-select"
                                                        onchange="updateField(this)">
                                                    @foreach(['unpaid','paid','failed','refunded'] as $p)
                                                        <option value="{{ $p }}" {{ $order->payment_status == $p ? 'selected' : '' }}>
                                                            {{ ucfirst($p) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </td>

                                        <!-- Delivery Status -->
                                        <td>
                                            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="d-inline update-form">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="field" value="delivery_status">
                                                <select name="value" class="form-select form-select-sm delivery-select"
                                                        onchange="updateField(this)">
                                                    @foreach(['not_started','in_progress','delivered','cancelled','failed'] as $d)
                                                        <option value="{{ $d }}" {{ $order->delivery_status == $d ? 'selected' : '' }}>
                                                            {{ ucfirst(str_replace('_', ' ', $d)) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </td>

                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info">
                                                View
                                            </a>
                                            <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-sm btn-warning">
                                                Edit
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4 text-muted">No orders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $orders->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function applyFilters() {
        const params = new URLSearchParams();
        const status = document.getElementById('statusFilter').value;
        const payment = document.getElementById('paymentStatusFilter').value;
        const delivery = document.getElementById('deliveryStatusFilter').value;
        const search = document.getElementById('searchInput').value.trim();

        if (status) params.append('status', status);
        if (payment) params.append('payment_status', payment);
        if (delivery) params.append('delivery_status', delivery);
        if (search) params.append('search', search);

        window.location = '{{ route("admin.orders.index") }}?' + params.toString();
    }

    // Instant update via AJAX
    async function updateField(select) {
        const form = select.closest('form');
        const formData = new FormData(form);
        const field = formData.get('field');
        const value = formData.get('value');

        // Disable select
        select.disabled = true;

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            const data = await response.json();

            if (data.success) {
                // Optional: show toast
                showToast(`Order ${field.replace('_', ' ')} updated to "${value}"`, 'success');
            } else {
                showToast(data.message || 'Update failed', 'danger');
                // Revert
                select.value = select.dataset.previous;
            }
        } catch (e) {
            showToast('Network error', 'danger');
            select.value = select.dataset.previous;
        } finally {
            select.disabled = false;
        }
    }

    // Store previous value
    document.querySelectorAll('.status-select, .payment-select, .delivery-select').forEach(s => {
        s.dataset.previous = s.value;
        s.addEventListener('change', function() {
            this.dataset.previous = this.value;
        });
    });

    // Toast helper (Bootstrap 5)
    function showToast(message, type = 'info') {
        const toast = `
            <div class="toast align-items-center text-white bg-${type} border-0" role="alert" style="position: fixed; top: 1rem; right: 1rem; z-index: 9999;">
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>`;
        document.body.insertAdjacentHTML('beforeend', toast);
        new bootstrap.Toast(document.querySelector('.toast')).show();
    }

    // Search on Enter
    document.getElementById('searchInput').addEventListener('keypress', e => {
        if (e.key === 'Enter') applyFilters();
    });
</script>
@endsection
