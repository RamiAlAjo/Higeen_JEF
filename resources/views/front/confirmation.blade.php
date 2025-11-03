@extends('front.layouts.app')

@section('content')
<x-hero-section-component page="confirmation"/>

<style>
    :root {
        --primary-color: #8B3C2B;
        --secondary-color: #a0522d;
        --light-bg: #fff8f6;
        --border-color: #d9b09c;
        --text-muted: #6c757d;
        --success-color: #28a745;
        --danger-color: #dc3545;
    }
    .confirmation-section { padding: 50px 0; background: var(--light-bg); }
    .section-title { color: var(--primary-color); font-weight: 700; margin-bottom: 30px; font-size: 2rem; text-align: center; }
    .confirmation-card { background: #fff; border-radius: 8px; padding: 25px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); border: 1px solid var(--border-color); }
    .confirmation-card .success-message { color: var(--success-color); font-size: 1.2rem; font-weight: 600; margin-bottom: 20px; text-align: center; }
    .confirmation-card .summary-box { background: var(--light-bg); border: 1px solid var(--border-color); border-radius: 6px; padding: 15px; margin-bottom: 25px; text-align: center; }
    .confirmation-card .summary-box h5 { color: var(--primary-color); font-size: 1.1rem; font-weight: 600; margin-bottom: 15px; }
    .confirmation-card .summary-box p { margin: 5px 0; font-size: 0.95rem; color: #2e3a59; }
    .confirmation-card .summary-box .grand-total { font-size: 1.2rem; font-weight: 700; color: var(--primary-color); }
    .confirmation-card .order-details, .confirmation-card .customer-info, .confirmation-card .payment-info { font-size: 0.95rem; color: #2e3a59; margin-bottom: 20px; }
    .confirmation-card .order-details span, .confirmation-card .customer-info span, .confirmation-card .payment-info span { display: block; padding: 5px 0; }
    .confirmation-card .section-title { font-size: 1.1rem; font-weight: 600; margin: 15px 0 10px; color: var(--primary-color); }
    .confirmation-card .cart-item { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid var(--border-color); font-size: 0.95rem; }
    .confirmation-card .cart-item img { width: 40px; height: 40px; object-fit: cover; margin-right: 10px; }
    .confirmation-card .cart-item-name { flex: 1; color: #2e3a59; }
    .confirmation-card .cart-item-qty { margin: 0 10px; color: var(--text-muted); }
    .confirmation-card .cart-item-total { font-weight: 600; }
    .confirmation-card .d-flex { padding: 10px 0; font-size: 1rem; color: #2e3a59; }
    .confirmation-card .fw-semibold { font-weight: 600; }
    .confirmation-card .text-primary-color { color: var(--primary-color); }
    .btn-primary { background: var(--primary-color); border-color: var(--primary-color); color: #fff; padding: 12px 30px; font-size: 1rem; border-radius: 25px; transition: background 0.3s, transform 0.3s, box-shadow 0.3s; }
    .btn-primary:hover { background: var(--secondary-color); transform: translateY(-3px); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); }
    .btn-group { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
    @media (max-width: 768px) {
        .confirmation-section { padding: 30px 0; }
        .confirmation-card { padding: 15px; }
        .btn-group { flex-direction: column; align-items: center; }
        .btn-primary { width: 100%; margin-bottom: 10px; }
    }
    @media (max-width: 576px) {
        .section-title { font-size: 1.5rem; }
        .confirmation-card .cart-item { flex-direction: column; align-items: flex-start; }
        .confirmation-card .cart-item-qty, .confirmation-card .cart-item-total { margin-top: 5px; }
        .confirmation-card .summary-box { padding: 10px; }
    }
    [dir="rtl"] .confirmation-card .cart-item img { margin-right: 0; margin-left: 10px; }
    [dir="rtl"] .confirmation-card .d-flex { flex-direction: row-reverse; }
    [dir="rtl"] .confirmation-card .text-end { text-align: start; }
</style>

<body class="bg-light" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="container confirmation-section">
        <h2 class="section-title">{{ __('cart.order_confirmation') }}</h2>
        <div class="confirmation-card">
            <div class="success-message">
                <i class="bi bi-check-circle-fill me-2"></i> {{ __('cart.order_placed') }} {{ __('cart.awaiting_confirmation') }}
            </div>
            @if (isset($order) && $order)
                <div class="summary-box">
                    <h5>{{ __('cart.order_summary') }}</h5>
                    <p><strong>{{ __('cart.order_number') }}:</strong> {{ $orderNumber }}</p>
                    <p><strong>{{ __('cart.order_status') }}:</strong> {{ __('cart.' . $order->status) }}</p>
                    <p><strong>{{ __('cart.payment_status') }}:</strong> {{ __('cart.' . $order->payment_status) }}</p>
                    <p><strong>{{ __('cart.item_count') }}:</strong> {{ array_sum(array_column($items, 'qty')) }}</p>
                    <p class="grand-total">{{ __('cart.grand_total') }}: {{ number_format($order->total, 3) }} {{ __('cart.currency') }}</p>
                </div>
                <p class="text-muted text-center mb-4">{{ __('cart.awaiting_confirmation_note') }}</p>
                <div class="order-details">
                    <h5 class="section-title">{{ __('cart.order_details') }}</h5>
                    <span><strong>{{ __('cart.order_number') }}:</strong> {{ $orderNumber }}</span>
                    <span><strong>{{ __('cart.order_date') }}:</strong> {{ $order->created_at->format('Y-m-d H:i:s') }}</span>
                </div>
                <div class="customer-info">
                    <h5 class="section-title">{{ __('cart.customer_information') }}</h5>
                    <span><strong>{{ __('cart.full_name') }}:</strong> {{ $order->full_name }}</span>
                    <span><strong>{{ __('cart.email') }}:</strong> {{ $order->email }}</span>
                    <span><strong>{{ __('cart.phone_number') }}:</strong> {{ $order->phone_number }}</span>
                    <span><strong>{{ __('cart.shipping_area') }}:</strong> {{ $order->shipping_area ?? __('cart.not_provided') }}</span>
                    <span><strong>{{ __('cart.shipping_address') }}:</strong> {{ $order->shipping_address }}</span>
                </div>
                <div class="payment-info">
                    <h5 class="section-title">{{ __('cart.payment_method') }}</h5>
                    <span><strong>{{ __('cart.method') }}:</strong> {{ __('cart.' . $order->payment_method) }}</span>
                </div>
                <h5 class="section-title">{{ __('cart.order_items') }}</h5>
                @foreach ($items as $item)
                    <div class="cart-item">
                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px;">
                        <span class="cart-item-name">{{ $item['name'] }}</span>
                        <span class="cart-item-qty">x{{ $item['qty'] }}</span>
                        <span class="cart-item-total">{{ $item['line_total'] }} {{ __('cart.currency') }}</span>
                    </div>
                @endforeach
                <div class="d-flex justify-content-between py-2 border-bottom mt-3">
                    <span>{{ __('cart.subtotal') }}:</span>
                    <span class="fw-semibold">{{ number_format($order->subtotal, 3) }} {{ __('cart.currency') }}</span>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>{{ __('cart.shipping') }}:</span>
                    <span class="fw-semibold">{{ number_format($order->shipping_cost, 3) }} {{ __('cart.currency') }}</span>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>{{ __('cart.tax') }} (16%):</span>
                    <span class="fw-semibold">{{ number_format($order->subtotal * 0.16, 3) }} {{ __('cart.currency') }}</span>
                </div>
                <div class="d-flex justify-content-between fw-bold py-3 text-lg">
                    <span>{{ __('cart.grand_total') }}:</span>
                    <span class="text-primary-color">{{ number_format($order->total, 3) }} {{ __('cart.currency') }}</span>
                </div>
                <div class="mt-4 btn-group">
                    <a href="{{ route('front.homepage') }}" class="btn btn-primary">{{ __('cart.continue_shopping') }}</a>
                    @auth('client')
                        <a href="{{ route('client.dashboard') }}" class="btn btn-primary">{{ __('cart.client_dashboard') }}</a>
                    @endauth
                </div>
            @else
                <p class="text-muted">{{ __('cart.no_order_found') }}</p>
                <div class="btn-group">
                    <a href="{{ route('front.homepage') }}" class="btn btn-primary">{{ __('cart.continue_shopping') }}</a>
                </div>
            @endif
        </div>
    </div>
</body>
@endsection
