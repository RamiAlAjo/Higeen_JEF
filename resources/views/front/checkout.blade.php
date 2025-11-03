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

<body class="bg-light" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="container checkout-section">
        <h2 class="section-title">{{ __('cart.checkout') }}</h2>

        <div class="row">
            <!-- Left: Checkout Form -->
            <div class="col-lg-8">
                @if (!Auth::guard('client')->check())
                    <div class="join-us-alert d-flex align-items-center justify-content-between">
                        <span>
                            <strong>{{ __('cart.already_account') }}</strong> {{ __('cart.log_in_or') }} <a href="{{ route('client.register') }}" class="join-us">{{ __('cart.join_us') }}</a> {{ __('cart.to_save_details') }}
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
                                       required placeholder="{{ __('cart.enter_full_name') }}" aria-required="true">
                                @error('full_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 form-group">
                                <label for="email">{{ __('cart.email') }} <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control"
                                       value="{{ Auth::guard('client')->check() ? Auth::guard('client')->user()->email : old('email') }}"
                                       required placeholder="{{ __('cart.enter_email') }}" aria-required="true">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Phone Number -->
                            <div class="col-md-6 form-group">
                                <label for="phone_number">{{ __('cart.phone_number') }} <span class="text-danger">*</span></label>
                                <input type="tel" name="phone_number" id="phone_number" class="form-control"
                                       value="{{ old('phone_number') }}" required placeholder="{{ __('cart.enter_phone_number') }}" aria-required="true">
                                @error('phone_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Shipping Area -->
                            <div class="col-md-6 form-group">
                                <label for="shipping_area">{{ __('cart.shipping_area') }} <span class="text-danger">*</span></label>
                                <select name="shipping_area" id="shipping_area" class="form-control" required>
                                    <option value="">{{ __('cart.select_shipping_area') }}</option>
                                    <option value="Amman" {{ old('shipping_area') == 'Amman' ? 'selected' : '' }}>Amman</option>
                                    <option value="Salt" {{ old('shipping_area') == 'Salt' ? 'selected' : '' }}>Salt</option>
                                    <option value="Irbid" {{ old('shipping_area') == 'Irbid' ? 'selected' : '' }}>Irbid</option>
                                </select>
                                @error('shipping_area')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Shipping Address -->
                            <div class="col-12 form-group">
                                <label for="shipping_address">{{ __('cart.shipping_address') }} <span class="text-danger">*</span></label>
                                <textarea name="shipping_address" id="shipping_address" class="form-control" rows="4"
                                          required placeholder="{{ __('cart.enter_shipping_address') }}" aria-required="true">{{ old('shipping_address') }}</textarea>
                                @error('shipping_address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Note -->
                            <div class="col-12 form-group">
                                <label for="note">{{ __('cart.note') }} ({{ __('cart.optional') }})</label>
                                <textarea name="note" id="note" class="form-control" rows="4"
                                          placeholder="{{ __('cart.enter_note') }}">{{ old('note') }}</textarea>
                                @error('note')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Payment Method -->
                            <div class="col-12 form-group">
                                <label>{{ __('cart.payment_method') }} <span class="text-danger">*</span></label>
                                <div class="payment-method">
                                    <label>
                                        <input type="radio" name="payment_method" value="cod" checked>
                                        <span><i class="fas fa-money-bill-wave"></i> {{ __('cart.cash_on_delivery') }}</span>
                                    </label>
                                    <label>
                                        <input type="radio" name="payment_method" value="card">
                                        <span><i class="fas fa-credit-card"></i> {{ __('cart.credit_debit_card') }}</span>
                                    </label>
                                    <label>
                                        <input type="radio" name="payment_method" value="paypal">
                                        <span><i class="fab fa-paypal"></i> {{ __('cart.paypal') }}</span>
                                    </label>
                                    <label>
                                        <input type="radio" name="payment_method" value="stripe">
                                        <span><i class="fas fa-stripe-s"></i> {{ __('cart.stripe') }}</span>
                                    </label>
                                    <label>
                                        <input type="radio" name="payment_method" value="bank_transfer">
                                        <span><i class="fas fa-university"></i> {{ __('cart.bank_transfer') }}</span>
                                    </label>
                                    <label>
                                        <input type="radio" name="payment_method" value="apple_pay">
                                        <span><i class="fab fa-apple-pay"></i> {{ __('cart.apple_pay') }}</span>
                                    </label>
                                    <label>
                                        <input type="radio" name="payment_method" value="google_pay">
                                        <span><i class="fab fa-google-pay"></i> {{ __('cart.google_pay') }}</span>
                                    </label>
                                    <label>
                                        <input type="radio" name="payment_method" value="wallet">
                                        <span><i class="fas fa-wallet"></i> {{ __('cart.wallet') }}</span>
                                    </label>
                                    <label>
                                        <input type="radio" name="payment_method" value="klarna">
                                        <span><i class="fas fa-money-check"></i> {{ __('cart.klarna') }}</span>
                                    </label>
                                    <label>
                                        <input type="radio" name="payment_method" value="cash">
                                        <span><i class="fas fa-money-bill"></i> {{ __('cart.cash_in_store') }}</span>
                                    </label>
                                </div>
                                @error('payment_method')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Submit Button -->
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
                        @if (isset($items) && is_array($items) && count($items) > 0)
                            <!-- Customer Information -->
                            <div class="customer-info">
                                <h5 class="section-title">{{ __('cart.customer_information') }}</h5>
                                <span><strong>{{ __('cart.full_name') }}:</strong> <span id="summary-full-name">{{ Auth::guard('client')->check() ? Auth::guard('client')->user()->name : old('full_name', __('cart.not_provided')) }}</span></span>
                                <span><strong>{{ __('cart.email') }}:</strong> <span id="summary-email">{{ Auth::guard('client')->check() ? Auth::guard('client')->user()->email : old('email', __('cart.not_provided')) }}</span></span>
                                <span><strong>{{ __('cart.phone_number') }}:</strong> <span id="summary-phone-number">{{ old('phone_number', __('cart.not_provided')) }}</span></span>
                                <span><strong>{{ __('cart.shipping_area') }}:</strong> <span id="summary-shipping-area">{{ old('shipping_area', __('cart.not_provided')) }}</span></span>
                                <span><strong>{{ __('cart.shipping_address') }}:</strong> <span id="summary-shipping-address">{{ old('shipping_address', __('cart.not_provided')) }}</span></span>
                            </div>

                            <!-- Payment Method -->
                            <div class="payment-info">
                                <h5 class="section-title">{{ __('cart.payment_method') }}</h5>
                                <span><strong>{{ __('cart.method') }}:</strong> <span id="summary-payment-method">{{ __('cart.cash_on_delivery') }}</span></span>
                            </div>

                            <!-- Itemized List -->
                            <h5 class="section-title">{{ __('cart.order_items') }}</h5>
                            @foreach ($items as $item)
                                <div class="cart-item">
                                    <span class="cart-item-name">{{ $item['name'] }}</span>
                                    <span class="cart-item-qty">x{{ $item['qty'] }}</span>
                                    <span class="cart-item-total">{{ $item['line_total'] }} {{ __('cart.currency') }}</span>
                                </div>
                            @endforeach

                            <!-- Totals -->
                            @php
                                $subtotalRaw = collect($items)->sum(fn($item) => $item['price'] * $item['qty']);
                                $subtotal = number_format($subtotalRaw, 3);
                                $tax = number_format($subtotalRaw * 0.16, 3);
                                $discount = 0;
                                $shippingCostLabels = [
                                    'Amman' => 2.00,
                                    'Salt' => 3.00,
                                    'Irbid' => 4.00,
                                ];
                                $selectedArea = old('shipping_area');
                                $shippingCost = isset($shippingCostLabels[$selectedArea]) ? number_format($shippingCostLabels[$selectedArea], 3) : '0.000';
                                $final_total = number_format($subtotalRaw + $subtotalRaw * 0.16 + (float)$shippingCost - $discount, 3);
                            @endphp
                            <div class="d-flex justify-content-between py-2 border-bottom mt-3">
                                <span>{{ __('cart.subtotal') }}:</span>
                                <span id="subtotal" class="fw-semibold">{{ $subtotal }} {{ __('cart.currency') }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span>{{ __('cart.shipping') }}:</span>
                                <span id="shipping-cost" class="fw-semibold">{{ $shippingCost }} {{ __('cart.currency') }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span>{{ __('cart.tax') }} (16%):</span>
                                <span id="tax" class="fw-semibold">{{ $tax }} {{ __('cart.currency') }}</span>
                            </div>
                            <div class="d-flex justify-content-between fw-bold py-3 text-lg">
                                <span>{{ __('cart.grand_total') }}:</span>
                                <span id="grandtotal" class="text-primary-color">{{ $final_total }} {{ __('cart.currency') }}</span>
                            </div>
                            <div class="mt-3 text-center">
                                <small class="text-muted">{{ __('cart.secure_checkout') }} <i class="bi bi-lock-fill"></i></small>
                            </div>
                        @else
                            <p class="text-muted">{{ __('cart.empty') }} <a href="{{ route('cart.index') }}">{{ __('cart.add_items') }}</a>.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('checkoutForm').addEventListener('submit', function(event) {
            const form = this;
            let isValid = true;
            const requiredFields = ['full_name', 'email', 'phone_number', 'shipping_area', 'shipping_address'];

            requiredFields.forEach(field => {
                const input = form.querySelector(`#${field}`);
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('is-invalid');
                    const error = input.nextElementSibling;
                    if (error && error.classList.contains('text-danger')) {
                        error.textContent = `${input.name.replace('_', ' ').replace(/^./, str => str.toUpperCase())} {{ __('cart.is_required') }}`;
                    } else {
                        const errorDiv = document.createElement('small');
                        errorDiv.className = 'text-danger';
                        errorDiv.textContent = `${input.name.replace('_', ' ').replace(/^./, str => str.toUpperCase())} {{ __('cart.is_required') }}`;
                        input.after(errorDiv);
                    }
                } else {
                    input.classList.remove('is-invalid');
                    const error = input.nextElementSibling;
                    if (error && error.classList.contains('text-danger')) {
                        error.remove();
                    }
                }
            });

            const paymentMethod = form.querySelector('input[name="payment_method"]:checked');
            if (!paymentMethod) {
                isValid = false;
                const paymentError = document.createElement('small');
                paymentError.className = 'text-danger';
                paymentError.textContent = '{{ __('cart.select_payment_method') }}';
                const existingError = form.querySelector('.payment-method + .text-danger');
                if (!existingError) {
                    form.querySelector('.payment-method').after(paymentError);
                }
            } else {
                const existingError = form.querySelector('.payment-method + .text-danger');
                if (existingError) {
                    existingError.remove();
                }
            }

            @if (!isset($items) || !is_array($items) || count($items) === 0)
                isValid = false;
                alert('{{ __('cart.empty_checkout') }}');
            @endif

            if (!isValid) {
                event.preventDefault();
            }
        });

        // Update Order Summary dynamically
        document.getElementById('checkoutForm').addEventListener('input', function(event) {
            const target = event.target;
            const summaryFields = {
                'full_name': 'summary-full-name',
                'email': 'summary-email',
                'phone_number': 'summary-phone-number',
                'shipping_area': 'summary-shipping-area',
                'shipping_address': 'summary-shipping-address'
            };

            if (summaryFields[target.id]) {
                const summaryElement = document.getElementById(summaryFields[target.id]);
                summaryElement.textContent = target.value || '{{ __('cart.not_provided') }}';
            }
        });

        // Update Payment Method in Summary
        document.querySelectorAll('input[name="payment_method"]').forEach(input => {
            input.addEventListener('change', function() {
                const paymentMethodMap = {
                    'cod': '{{ __('cart.cash_on_delivery') }}',
                    'card': '{{ __('cart.credit_debit_card') }}',
                    'paypal': '{{ __('cart.paypal') }}',
                    'stripe': '{{ __('cart.stripe') }}',
                    'bank_transfer': '{{ __('cart.bank_transfer') }}',
                    'apple_pay': '{{ __('cart.apple_pay') }}',
                    'google_pay': '{{ __('cart.google_pay') }}',
                    'wallet': '{{ __('cart.wallet') }}',
                    'klarna': '{{ __('cart.klarna') }}',
                    'cash': '{{ __('cart.cash_in_store') }}'
                };
                const summaryPaymentMethod = document.getElementById('summary-payment-method');
                summaryPaymentMethod.textContent = paymentMethodMap[this.value] || '{{ __('cart.not_provided') }}';
            });
        });

        // Update Shipping Cost and Grand Total
        const shippingRates = {
            'Amman': 2.00,
            'Salt': 3.00,
            'Irbid': 4.00
        };

        document.getElementById('shipping_area').addEventListener('change', function () {
            const selected = this.value;
            const shipping = shippingRates[selected] || 0;
            document.getElementById('shipping-cost').textContent = shipping.toFixed(3) + ' {{ __('cart.currency') }}';

            // Update grand total
            const subtotal = parseFloat('{{ $subtotalRaw }}');
            const tax = parseFloat('{{ $subtotalRaw * 0.16 }}');
            const grandTotal = subtotal + tax + shipping;
            document.getElementById('grandtotal').textContent = grandTotal.toFixed(3) + ' {{ __('cart.currency') }}';
        });
    </script>
</body>
@endsection
