{{-- resources/views/admin/orders/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Orders Management')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                    <h3 class="mb-0 fw-bold">Orders Management</h3>
                    <div class="input-group input-group-sm" style="width: 280px;">
                        <input type="text" class="form-control" placeholder="Search order..." id="searchInput">
                        <button class="btn btn-light" onclick="applyFilters()">Search</button>
                    </div>
                </div>

                <div class="card-body p-4">

                    <!-- Filters -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-2">
                            <select class="form-select form-select-sm" id="statusFilter">
                                <option value="">All Status</option>
                                @foreach(['pending','confirmed','shipped','delivered','cancelled'] as $s)
                                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>
                                        {{ ucfirst($s) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select form-select-sm" id="paymentStatusFilter">
                                <option value="">Payment</option>
                                @foreach(['unpaid','paid'] as $p)
                                    <option value="{{ $p }}" {{ request('payment_status') == $p ? 'selected' : '' }}>
                                        {{ ucfirst($p) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select form-select-sm" id="hesabateFilter">
                                <option value="">Hesabate</option>
                                <option value="sent" {{ request('hesabate') == 'sent' ? 'selected' : '' }}>Sent</option>
                                <option value="not_sent" {{ request('hesabate') == 'not_sent' ? 'selected' : '' }}>Not Sent</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary btn-sm w-100" onclick="applyFilters()">Apply</button>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Delivery</th>
                                    <th>Hesabate Sync</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td><strong>#{{ $order->id }}</strong></td>
                                        <td>
                                            <div>
                                                <div class="fw-semibold">{{ $order->full_name }}</div>
                                                <small class="text-muted">{{ $order->email }}</small>
                                            </div>
                                        </td>
                                        <td><strong class="text-success">{{ number_format($order->total, 2) }} JOD</strong></td>

                                        <!-- Status -->
                                        <td>
                                            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="d-inline update-form">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="field" value="status">
                                                <select name="value" class="form-select form-select-sm status-select" onchange="updateField(this)">
                                                    @foreach(['pending','confirmed','shipped','delivered','cancelled'] as $s)
                                                        <option value="{{ $s }}" {{ $order->status == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </td>

                                        <!-- Payment -->
                                        <td>
                                            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="d-inline update-form">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="field" value="payment_status">
                                                <select name="value" class="form-select form-select-sm" onchange="updateField(this)">
                                                    @foreach(['unpaid','paid','failed','refunded'] as $p)
                                                        <option value="{{ $p }}" {{ $order->payment_status == $p ? 'selected' : '' }}>{{ ucfirst($p) }}</option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </td>

                                        <!-- Delivery -->
                                        <td>
                                            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="d-inline update-form">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="field" value="delivery_status">
                                                <select name="value" class="form-select form-select-sm" onchange="updateField(this)">
                                                    @foreach(['not_started','in_progress','delivered','cancelled','failed'] as $d)
                                                        <option value="{{ $d }}" {{ $order->delivery_status == $d ? 'selected' : '' }}>
                                                            {{ ucfirst(str_replace('_', ' ', $d)) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </td>

                                        <!-- Hesabate Sync (Using Model Accessor) -->
                                        <td>
                                            @if($order->can_send_to_hesabate)
                                                <button class="btn btn-sm btn-outline-success send-to-hesabate"
                                                        data-order-id="{{ $order->id }}"
                                                        data-total="{{ $order->total }}">
                                                    Send to Hesabate
                                                </button>
                                            @else
                                                {!! $order->hesabate_badge !!}
                                            @endif
                                        </td>

                                        <td>{{ $order->created_at->format('M d, Y') }}</td>

                                        <td>
                                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-info btn-sm">View</a>
                                            <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-warning btn-sm">Edit</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-5 text-muted">No orders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $orders->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function applyFilters() {
        const params = new URLSearchParams();
        ['statusFilter', 'paymentStatusFilter', 'hesabateFilter'].forEach(id => {
            const val = document.getElementById(id)?.value;
            if (val) {
                const key = id === 'hesabateFilter' ? 'hesabate' : id.replace('Filter', '').replace('paymentS', 'payment_s');
                params.append(key, val);
            }
        });
        const search = document.getElementById('searchInput')?.value.trim();
        if (search) params.append('search', search);
        window.location = '{{ route("admin.orders.index") }}?' + params.toString();
    }

    async function updateField(select) {
        const form = select.closest('form');
        const formData = new FormData(form);
        select.disabled = true;
        try {
            const res = await fetch(form.action, { method: 'POST', body: formData });
            const data = await res.json();
            if (!data.success) showToast('Update failed', 'danger');
        } catch (e) {
            showToast('Network error', 'danger');
        } finally {
            select.disabled = false;
        }
    }

    // Send to Hesabate
    document.querySelectorAll('.send-to-hesabate').forEach(btn => {
        btn.addEventListener('click', async () => {
            const orderId = btn.dataset.orderId;
            const total = btn.dataset.total;
            btn.disabled = true;
            btn.innerHTML = 'Sending...';

            const formData = new FormData();
            formData.append('token', 'Vmc2QUhQak9WOGFoOGtmNXp5cEo4L3g4MHBmZE5uSGdKbk9LcnU0ZDdOWUZhRytna1BaTmxRSThEUEhLTWd3aTRUVk9acXlKK0hOWGQvKzFMbzJnRVNQOFBLZ2piWTZPakpUNEd2RVFqdVE9');
            formData.append('action', 'upload');
            formData.append('invoice_type', '0');
            formData.append('transfer_price', '0');
            formData.append('customer_level', '2');
            formData.append('price_show', '1');
            formData.append('invoice_update', '0');
            formData.append('store_id', '0');
            formData.append('invoices', JSON.stringify({
                [orderId]: {
                    id: orderId,
                    total: parseFloat(total),
                    paid: parseFloat(total),
                    c_name: "Customer #" + orderId,
                    c_telephone: "+962790000000",
                    track_no: orderId,
                    order_details: []
                }
            }));

            try {
                const res = await fetch('https://test.hesabate.com/store_api.php', { method: 'POST', body: formData });
                const text = await res.text();
                if (res.ok || text.includes('success')) {
                    await fetch('{{ route("admin.orders.hesabate.sent") }}', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
                        body: JSON.stringify({ order_id: orderId })
                    });
                    btn.closest('td').innerHTML = `<span class="badge bg-success">Sent just now</span>`;
                    showToast('Sent to Hesabate!', 'success');
                } else {
                    showToast('API Error: ' + text.substring(0, 80), 'danger');
                }
            } catch (e) {
                showToast('Failed to send', 'danger');
            } finally {
                btn.disabled = false;
            }
        });
    });

    function showToast(msg, type = 'info') {
        const toast = `<div class="toast align-items-center text-white bg-${type} border-0 position-fixed top-0 end-0 m-3" style="z-index: 9999;">
            <div class="d-flex"><div class="toast-body">${msg}</div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button></div></div>`;
        document.body.insertAdjacentHTML('beforeend', toast);
        new bootstrap.Toast(document.querySelector('.toast')).show();
    }

    document.getElementById('searchInput')?.addEventListener('keypress', e => e.key === 'Enter' && applyFilters());
</script>
@endsection
