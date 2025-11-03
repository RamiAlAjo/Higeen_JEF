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
                    <h3 class="card-title mb-0">Order Details #{{ $order->id }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-light btn-sm me-2">
                            <i class="fas fa-arrow-left"></i> Back to Orders
                        </a>
                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-light btn-sm">
                            <i class="fas fa-edit"></i> Edit Order
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row g-4">
                        <!-- Order Information -->
                        <div class="col-lg-6">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Order Information</h4>
                                    <table class="table table-hover table-borderless">
                                        <tr>
                                            <th class="text-muted">Order ID</th>
                                            <td>{{ $order->id }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Status</th>
                                            <td>
                                                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="update-status-form">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                    </select>
                                                    @error('status')
                                                        <span class="text-danger small">{{ $message }}</span>
                                                    @enderror
                                                </form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Payment Status</th>
                                            <td>
                                                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="update-payment-status-form">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="payment_status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                        <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                                        <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                                        <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                                                        <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                                    </select>
                                                    @error('payment_status')
                                                        <span class="text-danger small">{{ $message }}</span>
                                                    @enderror
                                                </form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Delivery Status</th>
                                            <td>
                                                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="update-delivery-status-form">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="delivery_status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                        <option value="not_started" {{ $order->delivery_status == 'not_started' ? 'selected' : '' }}>Not Started</option>
                                                        <option value="in_progress" {{ $order->delivery_status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                        <option value="delivered" {{ $order->delivery_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                        <option value="cancelled" {{ $order->delivery_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                        <option value="failed" {{ $order->delivery_status == 'failed' ? 'selected' : '' }}>Failed</option>
                                                    </select>
                                                    @error('delivery_status')
                                                        <span class="text-danger small">{{ $message }}</span>
                                                    @enderror
                                                </form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Payment Method</th>
                                            <td>{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Created At</th>
                                            <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Updated At</th>
                                            <td>{{ $order->updated_at->format('Y-m-d H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Information -->
                        <div class="col-lg-6">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Customer Information</h4>
                                    <table class="table table-hover table-borderless">
                                        <tr>
                                            <th class="text-muted">Full Name</th>
                                            <td>{{ $order->full_name }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Email</th>
                                            <td>{{ $order->email }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Phone Number</th>
                                            <td>{{ $order->phone_number }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Shipping Area</th>
                                            <td>{{ $order->shipping_area ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Shipping Address</th>
                                            <td>{{ $order->shipping_address }}</td>
                                        </tr>
                                        @if ($order->client_id)
                                            <tr>
                                                <th class="text-muted">Client</th>
                                                <td>
                                                    <a href="{{ route('admin.clients.show', $order->client_id) }}" class="text-decoration-none">
                                                        {{ $order->client ? $order->client->name : 'Client #' . $order->client_id }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted">Client Phone</th>
                                                <td>{{ $order->client ? $order->client->phone_number : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted">Client Area</th>
                                                <td>{{ $order->client ? $order->client->area : 'N/A' }}</td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing Details -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Pricing Details</h4>
                                    <table class="table table-hover table-borderless">
                                        <tr>
                                            <th class="text-muted">Subtotal</th>
                                            <td>{{ number_format($order->subtotal, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Shipping Cost</th>
                                            <td>{{ number_format($order->shipping_cost, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Discount</th>
                                            <td>
                                                {{ number_format($order->discount, 2) }}
                                                @if ($order->discount_type)
                                                    ({{ $order->discount_percent }}% - {{ ucfirst($order->discount_type) }})
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Total</th>
                                            <td><strong class="text-primary">{{ number_format($order->total, 2) }}</strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Order Items</h4>
                                    @if ($order->items->isNotEmpty())
                                        <div class="table-responsive">
                                            <table class="table table-hover table-borderless">
                                                <thead>
                                                    <tr>
                                                        <th>Item ID</th>
                                                        <th>Product</th>
                                                        <th>Quantity</th>
                                                        <th>Unit Price</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($order->items as $item)
                                                        <tr class="animate__animated animate__fadeIn">
                                                            <td>{{ $item->id }}</td>
                                                            <td>
                                                                @if (app()->getLocale() == 'ar')
                                                                    {{ $item->product_name_ar ?? $item->product->name ?? 'Product #' . $item->product_id }}
                                                                @else
                                                                    {{ $item->product_name_en ?? $item->product->name ?? 'Product #' . $item->product_id }}
                                                                @endif
                                                            </td>
                                                            <td>{{ $item->quantity }}</td>
                                                            <td>{{ number_format($item->price, 2) }}</td>
                                                            <td>{{ number_format($item->total, 2) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <p class="text-muted">No items found for this order.</p>
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
    .form-select-sm {
        max-width: 150px;
    }
    .alert {
        border-radius: 0.5rem;
    }
</style>

<script>
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
