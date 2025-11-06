@extends('front.layouts.app')

@section('content')
<x-hero-section-component page="checkout"/>

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

    .checkout-section {
        padding: 50px 0;
        background: var(--light-bg);
    }

    .section-title {
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 30px;
        font-size: 2rem;
        text-align: center;
    }

    .checkout-form-card {
        background: #fff;
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--border-color);
    }

    .checkout-form .form-control {
        border: 1px solid var(--border-color);
        border-radius: 6px;
        padding: 12px;
        font-size: 0.95rem;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    .checkout-form .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 8px rgba(139, 58, 43, 0.2);
    }

    .checkout-form label {
        font-weight: 600;
        color: #2e3a59;
        margin-bottom: 10px;
    }

    .checkout-form .form-group {
        margin-bottom: 25px;
    }

    .payment-method {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        margin-bottom: 25px;
    }

    .payment-method label {
        display: flex;
        align-items: center;
        padding: 10px;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        background: #fff;
        cursor: pointer;
        transition: background 0.3s, border-color 0.3s;
    }

    .payment-method label:hover,
    .payment-method input[type="radio"]:checked + span {
        background: var(--primary-color);
        color: #fff;
        border-color: var(--primary-color);
    }

    .payment-method input[type="radio"] {
        display: none;
    }

    .payment-method i {
        margin-right: 8px;
        font-size: 1.2rem;
    }

    .cart-total-box {
        background: var(--light-bg);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        position: sticky;
        top: 100px;
    }

    .cart-total-box h4 {
        color: var(--primary-color);
        font-weight: 600;
        margin-bottom: 20px;
        font-size: 1.25rem;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 15px;
    }

    .cart-total-box .d-flex {
        padding: 10px 0;
        font-size: 1rem;
        color: #2e3a59;
    }

    .cart-total-box .fw-semibold {
        font-weight: 600;
    }

    .cart-total-box .text-primary-color {
        color: var(--primary-color);
    }

    .cart-total-box .cart-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid var(--border-color);
        font-size: 0.95rem;
    }

    .cart-total-box .cart-item-name {
        flex: 1;
        color: #2e3a59;
    }

    .cart-total-box .cart-item-qty {
        margin: 0 10px;
        color: var(--text-muted);
    }

    .cart-total-box .cart-item-total {
        font-weight: 600;
    }

    .cart-total-box .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 15px 0 10px;
        color: var(--primary-color);
    }

    .cart-total-box .customer-info, .cart-total-box .payment-info {
        font-size: 0.95rem;
        color: #2e3a59;
        margin-bottom: 10px;
    }

    .cart-total-box .customer-info span, .cart-total-box .payment-info span {
        display: block;
        padding: 5px 0;
    }

    .join-us-alert {
        background: var(--light-bg);
        border: 1px solid var(--border-color);
        border-radius: 6px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .join-us {
        color: var(--primary-color);
        font-weight: 600;
        text-decoration: none;
        transition: color 0.3s;
    }

    .join-us:hover {
        color: var(--secondary-color);
        text-decoration: underline;
    }

    .btn-primary {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: #fff;
        padding: 12px 30px;
        font-size: 1rem;
        border-radius: 25px;
        transition: background 0.3s, transform 0.3s, box-shadow 0.3s;
    }

    .btn-primary:hover {
        background: var(--secondary-color);
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .btn-outline-primary {
        border-color: var(--primary-color);
        color: var(--primary-color);
        padding: 12px 30px;
        font-size: 1rem;
        border-radius: 25px;
        transition: background 0.3s, color 0.3s, transform 0.3s;
    }

    .btn-outline-primary:hover {
        background: var(--primary-color);
        color: #fff;
        transform: translateY(-3px);
    }

    @media (max-width: 768px) {
        .checkout-section {
            padding: 30px 0;
        }

        .checkout-form-card,
        .cart-total-box {
            padding: 15px;
        }

        .cart-total-box {
            position: static;
        }

        .payment-method {
            grid-template-columns: 1fr;
        }

        .btn-primary,
        .btn-outline-primary {
            width: 100%;
            margin-bottom: 10px;
        }
    }

    @media (max-width: 576px) {
        .section-title {
            font-size: 1.5rem;
        }

        .cart-total-box .cart-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .cart-total-box .cart-item-qty,
        .cart-total-box .cart-item-total {
            margin-top: 5px;
        }
    }
</style>

{{-- resources/views/front/checkout.blade.php --}}
<body class="bg-light" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="container checkout-section">
        <h2 class="section-title">{{ __('cart.checkout') }}</h2>

        <div class="row">
            <!-- Left: Checkout Form -->
            <div class="col-lg-8">
                @if (!Auth::guard('client')->check())
                    <div class="join-us-alert d-flex align-items-center justify-content-between">
                        <span>
                            <strong>{{ __('cart.already_account') }}</strong> {{ __('cart.log_in_or') }}
                            <a href="{{ route('client.register') }}" class="join-us">{{ __('cart.join_us') }}</a>
                            {{ __('cart.to_save_details') }}
                        </span>
                        <a href="{{ route('client.login') }}" class="btn btn-outline-primary btn-sm">{{ __('cart.log_in') }}</a>
                    </div>
                @endif

                <div class="checkout-form-card">
                    <form action="{{ route('checkout.store') }}" method="POST" class="checkout-form" id="checkoutForm">
                        @csrf

                        <h5 class="mb-4">{{ __('cart.shipping_information') }}</h5>
                        <div class="row">

                            <!-- Full Name -->
                            <div class="col-md-6 form-group">
                                <label for="full_name">{{ __('cart.full_name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="full_name" id="full_name" class="form-control"
                                       value="{{ Auth::guard('client')->check() ? Auth::guard('client')->user()->name : old('full_name') }}"
                                       required placeholder="{{ __('cart.enter_full_name') }}">
                                @error('full_name')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 form-group">
                                <label for="email">{{ __('cart.email') }} <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control"
                                       value="{{ Auth::guard('client')->check() ? Auth::guard('client')->user()->email : old('email') }}"
                                       required placeholder="{{ __('cart.enter_email') }}">
                                @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>

                            <!-- Phone Number -->
                            <div class="col-md-6 form-group">
                                <label for="phone_number">{{ __('cart.phone_number') }} <span class="text-danger">*</span></label>
                                <input type="tel" name="phone_number" id="phone_number" class="form-control"
                                       value="{{ old('phone_number') }}" required placeholder="{{ __('cart.enter_phone_number') }}">
                                @error('phone_number')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>

                            <!-- Shipping Area (Dynamic) -->
                            <div class="col-md-6 form-group">
                                <label for="shipping_area_id">{{ __('cart.shipping_area') }} <span class="text-danger">*</span></label>
                                <select name="shipping_area_id" id="shipping_area_id" class="form-control" required>
                                    <option value="">{{ __('cart.select_shipping_area') }}</option>
                                    @foreach($shippingAreas as $area)
                                        <option value="{{ $area->id }}"
                                                data-cost="{{ $area->cost }}"
                                                {{ old('shipping_area_id') == $area->id ? 'selected' : '' }}>
                                            {{ $area->getNameAttribute() }} ({{ number_format($area->cost, 2) }} JOD)
                                        </option>
                                    @endforeach
                                </select>
                                @error('shipping_area_id')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>

                          <!-- Shipping Address -->
<div class="col-12 form-group">
    <label for="shipping_address">
        {{ __('cart.shipping_address') }} <span class="text-danger">*</span>
    </label>

    <textarea
        name="shipping_address"
        id="shipping_address"
        class="form-control"
        rows="4"
        required
        placeholder="{{ __('') }} (e.g., Street name, Building number, Floor, Apartment)"
    >{{ old('shipping_address') }}</textarea>

    @error('shipping_address')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>


                            <!-- Note -->
                            <div class="col-12 form-group">
                                <label for="note">{{ __('cart.note') }} ({{ __('cart.optional') }})</label>
                                <textarea name="note" id="note" class="form-control" rows="4"
                                          placeholder="{{ __('cart.enter_note') }}">{{ old('note') }}</textarea>
                            </div>

                            <!-- Payment Method -->
                            <div class="col-12 form-group">
                                <label>{{ __('cart.payment_method') }} <span class="text-danger">*</span></label>
                                <div class="payment-method">
                                    @php
                                        $methods = ['cod','card','paypal','stripe','bank_transfer','apple_pay','google_pay','wallet','cash'];
                                    @endphp
                                    @foreach($methods as $method)
                                        <label>
                                            <input type="radio" name="payment_method" value="{{ $method }}"
                                                {{ old('payment_method', 'cod') == $method ? 'checked' : '' }}>
                                            <span>
                                                <i class="fas {{
                                                    $method == 'cod' ? 'fa-money-bill-wave' :
                                                    ($method == 'card' ? 'fa-credit-card' :
                                                    ($method == 'paypal' ? 'fa-paypal' :
                                                    ($method == 'stripe' ? 'fa-stripe-s' :
                                                    ($method == 'bank_transfer' ? 'fa-university' :
                                                    ($method == 'apple_pay' ? 'fa-apple-pay' :
                                                    ($method == 'google_pay' ? 'fa-google-pay' :
                                                    ($method == 'wallet' ? 'fa-wallet' :
                                                    ($method == 'klarna' ? 'fa-money-check' : 'fa-money-bill'))))))))
                                                }}"></i>
                                                {{ __('cart.' . $method) }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('payment_method')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>

                            <!-- Submit -->
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">{{ __('cart.place_order') }}</button>
                                <a href="{{ route('cart.index') }}" class="btn btn-outline-primary ms-2">{{ __('cart.back_to_cart') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right: Order Summary -->
            <div class="col-lg-4">
                <div class="cart-total-box card shadow-sm border-0 rounded-3 sticky-top" style="top: 100px;">
                    <div class="card-body p-4">
                        <h4 class="mb-4 text-primary-color border-bottom pb-3">{{ __('cart.summary') }}</h4>

                        @if (isset($items) && count($items) > 0)
                            <!-- Customer Info -->
                            <div class="customer-info">
                                <h5 class="section-title">{{ __('cart.customer_information') }}</h5>
                                <div><strong>{{ __('cart.full_name') }}:</strong> <span id="summary-full-name">{{ Auth::guard('client')->check() ? Auth::guard('client')->user()->name : old('full_name', __('cart.not_provided')) }}</span></div>
                                <div><strong>{{ __('cart.email') }}:</strong> <span id="summary-email">{{ Auth::guard('client')->check() ? Auth::guard('client')->user()->email : old('email', __('cart.not_provided')) }}</span></div>
                                <div><strong>{{ __('cart.phone_number') }}:</strong> <span id="summary-phone-number">{{ old('phone_number', __('cart.not_provided')) }}</span></div>
                                <div><strong>{{ __('cart.shipping_area') }}:</strong> <span id="summary-shipping-area">
                                    @if(old('shipping_area_id'))
                                        {{ $shippingAreas->firstWhere('id', old('shipping_area_id'))?->getNameAttribute() ?? __('cart.not_provided') }}
                                    @else
                                        {{ __('cart.not_provided') }}
                                    @endif
                                </span></div>
                                <div><strong>{{ __('cart.shipping_address') }}:</strong> <span id="summary-shipping-address">{{ old('shipping_address', __('cart.not_provided')) }}</span></div>
                            </div>

                            <!-- Payment Method -->
                            <div class="payment-info mt-3">
                                <h5 class="section-title">{{ __('cart.payment_method') }}</h5>
                                <div><strong>{{ __('cart.method') }}:</strong> <span id="summary-payment-method">{{ __('cart.cash_on_delivery') }}</span></div>
                            </div>

                            <!-- Items -->
                            <h5 class="section-title mt-3">{{ __('cart.order_items') }}</h5>
                            @foreach ($items as $item)
                                <div class="cart-item d-flex justify-content-between">
                                    <span class="cart-item-name">{{ $item['name'] }}</span>
                                    <span class="cart-item-qty">x{{ $item['qty'] }}</span>
                                    <span class="cart-item-total">{{ $item['line_total'] }} {{ __('cart.currency') }}</span>
                                </div>
                            @endforeach

                            <!-- Totals -->
                            @php
                                $subtotalRaw = collect($items)->sum(fn($i) => $i['price'] * $i['qty']);
                                $tax = number_format($subtotalRaw * 0.16, 3);
                                $selectedArea = $shippingAreas->firstWhere('id', old('shipping_area_id'));
                                $shippingCost = $selectedArea?->cost ?? 0;
                                $grandTotal = number_format($subtotalRaw + ($subtotalRaw * 0.16) + $shippingCost, 3);
                            @endphp

                            <div class="d-flex justify-content-between py-2 border-bottom mt-3">
                                <span>{{ __('cart.subtotal') }}:</span>
                                <span id="subtotal" class="fw-semibold">{{ number_format($subtotalRaw, 3) }} {{ __('cart.currency') }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span>{{ __('cart.shipping') }}:</span>
                                <span id="shipping-cost" class="fw-semibold">{{ number_format($shippingCost, 3) }} {{ __('cart.currency') }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span>{{ __('cart.tax') }} (16%):</span>
                                <span id="tax" class="fw-semibold">{{ $tax }} {{ __('cart.currency') }}</span>
                            </div>
                            <div class="d-flex justify-content-between fw-bold py-3 text-lg">
                                <span>{{ __('cart.grand_total') }}:</span>
                                <span id="grandtotal" class="text-primary-color">{{ $grandTotal }} {{ __('cart.currency') }}</span>
                            </div>
                            <div class="mt-3 text-center">
                                <small class="text-muted">{{ __('cart.secure_checkout') }} <i class="bi bi-lock-fill"></i></small>
                            </div>
                                          @else
                            <p class="text-muted">
                                {{ __('cart.empty') }} <a href="{{ route('cart.index') }}">{{ __('cart.add_items') }}</a>.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

   @php
    // Define all payment labels in PHP to avoid Blade parsing issues
    $paymentLabels = collect([
        'cod', 'card', 'paypal', 'stripe', 'bank_transfer',
        'apple_pay', 'google_pay', 'wallet', 'klarna', 'cash'
    ])->mapWithKeys(fn($m) => [$m => __('cart.' . $m)])->toArray();
@endphp

<!-- Live Update Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('checkoutForm');
        const summaryMap = {
            full_name: 'summary-full-name',
            email: 'summary-email',
            phone_number: 'summary-phone-number',
            shipping_address: 'summary-shipping-address'
        };

        // Text fields live update
        form.addEventListener('input', function (e) {
            const field = e.target;
            if (summaryMap[field.id]) {
                document.getElementById(summaryMap[field.id]).textContent =
                    field.value || '{{ __("cart.not_provided") }}';
            }
        });

        // Shipping area selection
        const shippingSelect = document.getElementById('shipping_area_id');
        shippingSelect.addEventListener('change', function () {
            const opt = this.options[this.selectedIndex];
            const areaName = opt.text.split(' (')[0];
            document.getElementById('summary-shipping-area').textContent =
                areaName || '{{ __("cart.not_provided") }}';

            const cost = parseFloat(opt.dataset.cost) || 0;
            document.getElementById('shipping-cost').textContent =
                cost.toFixed(3) + ' {{ __("cart.currency") }}';

            const subtotal = {{ $subtotalRaw }};
            const tax = subtotal * 0.16;
            const total = subtotal + tax + cost;

            document.getElementById('grandtotal').textContent =
                total.toFixed(3) + ' {{ __("cart.currency") }}';
        });

        // Injected from PHP (no Blade syntax errors!)
        const paymentLabels = @json($paymentLabels);

        // Payment method updates
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', function () {
                document.getElementById('summary-payment-method').textContent =
                    paymentLabels[this.value] || '{{ __("cart.not_provided") }}';
            });
        });

        // Trigger initial update (if a value is preselected)
        if (shippingSelect.value) {
            shippingSelect.dispatchEvent(new Event('change'));
        }
    });
</script>

</body>
@endsection
