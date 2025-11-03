@extends('front.layouts.app')

@section('content')
<x-hero-section-component page="cart"/>

<section class="cart-section container my-5" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
  <div class="row">
    <div class="col-lg-8">
      <h2 class="fw-bold mb-4 text-primary-color">{{ __('cart.title') }}</h2>

      @if ($cartItems->count() > 0)
        <!-- Cart Table -->
        <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
          <div class="table-responsive">
            <table class="table cart-table align-middle text-nowrap mb-0">
              <thead class="bg-light">
                <tr>
                  <th class="border-0 py-3">{{ __('cart.product') }}</th>
                  <th class="text-center border-0 py-3">{{ __('cart.price') }}</th>
                  <th class="text-center border-0 py-3">{{ __('cart.quantity') }}</th>
                  <th class="text-center border-0 py-3">{{ __('cart.total') }}</th>
                  <th class="text-center border-0 py-3">{{ __('cart.actions') }}</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($cartItems as $item)
                  @php
                    $product = $item->product;
                    $locale = app()->getLocale();
                    $nameField = $locale === 'ar' ? 'product_name_ar' : 'product_name_en';
                    $descField = $locale === 'ar' ? 'description_ar' : 'description_en';
                    $productName = $product->{$nameField} ?? $product->product_name_en;
                    $productDesc = $product->{$descField} ?? $product->description_en;
                  @endphp
                  <tr data-item-id="{{ $item->id }}" class="border-bottom">
                    <td class="product-info py-4 d-flex align-items-center">
                      <img src="{{ $product->main_image_url }}" alt="{{ $productName }}" class="cart-img rounded shadow-sm">
                      <div class="ms-3">
                        <span class="product-name fw-semibold d-block">{{ $productName }}</span>
                        @if($productDesc)
                          <small class="text-muted d-block">{{ Str::limit($productDesc, 50) }}</small>
                        @endif
                        @if($product->quantity < $item->quantity)
                          <small class="text-danger d-block mt-1">
                            {{ __('cart.only_stock_left', ['stock' => $product->quantity]) }}
                          </small>
                        @endif
                      </div>
                    </td>
                    <td class="text-center price" data-price="{{ $item->price_at_time }}">
                      {{ number_format($item->price_at_time, 3) }} JD
                    </td>
                    <td class="text-center">
                      <div class="quantity-box d-inline-flex">
                        <button type="button" class="qty-btn minus rounded-start" aria-label="{{ __('cart.decrease_qty') }}" {{ $item->quantity <= 1 ? 'disabled' : '' }}>−</button>
                        <input type="number" value="{{ $item->quantity }}" min="1" max="{{ $product->quantity }}" class="qty-input form-control" aria-label="{{ __('cart.quantity') }}">
                        <button type="button" class="qty-btn plus rounded-end" aria-label="{{ __('cart.increase_qty') }}" {{ $item->quantity >= $product->quantity ? 'disabled' : '' }}>+</button>
                      </div>
                    </td>
                    <td class="text-center total fw-semibold text-primary-color">
                      {{ number_format($item->price_at_time * $item->quantity, 3) }} JD
                    </td>
                    <td class="text-center">
                      <button type="button" class="btn btn-sm btn-outline-danger remove-item rounded-pill px-3" data-id="{{ $item->id }}">
                        {{ __('cart.remove') }}
                      </button>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

        <!-- Update Cart -->
        <div class="mt-4 text-end">
          <button class="update-btn btn btn-outline-secondary rounded-pill px-4">{{ __('cart.update') }}</button>
        </div>

      @else
        <!-- Empty Cart -->
        <div class="text-center py-5">
          <div class="empty-cart-icon mb-4">
            <i class="bi bi-cart-x display-1 text-muted"></i>
          </div>
          <p class="lead text-muted">{{ __('cart.empty') }}</p>
          <a href="{{ route('front.product') }}" class="btn btn-primary rounded-pill px-5">{{ __('cart.continue') }}</a>
        </div>
      @endif
    </div>

    <!-- Cart Summary -->
    <div class="col-lg-4 mt-4 mt-lg-0">
      <div class="cart-total-box card shadow-sm border-0 rounded-3 sticky-top" style="top: 100px;">
        <div class="card-body p-4">
          <h4 class="mb-4 text-primary-color border-bottom pb-3">{{ __('cart.summary') }}</h4>
          <div class="d-flex justify-content-between py-2 border-bottom">
            <span>{{ __('cart.subtotal') }}:</span>
            <span id="subtotal" class="fw-semibold">{{ number_format($cartItems->sum(fn($i) => $i->price_at_time * $i->quantity), 3) }} JD</span>
          </div>
          <div class="d-flex justify-content-between py-2 border-bottom">
            <span>{{ __('cart.shipping') }}:</span>
            <span class="fw-semibold">{{ __('cart.free') }}</span>
          </div>
          <div class="d-flex justify-content-between py-2 border-bottom">
            <span>{{ __('cart.tax') }}:</span>
            <span id="tax" class="fw-semibold">0.000 JD</span>
          </div>
          <div class="d-flex justify-content-between fw-bold py-3 text-lg">
            <span>{{ __('cart.grand_total') }}:</span>
            <span id="grandtotal" class="text-primary-color">{{ number_format($cartItems->sum(fn($i) => $i->price_at_time * $i->quantity), 3) }} JD</span>
          </div>
          <a href="{{ route ('checkout.index') }}" class="proceed-btn btn btn-lg w-100 rounded-pill mt-3 shadow-sm">{{ __('cart.checkout') }}</a>
          <div class="mt-3 text-center">
            <small class="text-muted">{{ __('cart.secure_checkout') }} <i class="bi bi-lock-fill"></i></small>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

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

  .text-primary-color {
    color: var(--primary-color) !important;
  }

  /* Card Enhancements */
  .card {
    border: 1px solid var(--border-color);
    transition: box-shadow 0.3s ease;
  }
  .card:hover {
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
  }

  /* Table Styles */
  .cart-table {
    background-color: #fff;
  }
  .cart-table th {
    background: #fff4f2;
    color: var(--primary-color);
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.9rem;
    letter-spacing: 0.5px;
  }
  .cart-table td {
    vertical-align: middle;
    padding: 1.25rem 1rem;
  }
  .cart-table tr:hover {
    background-color: #fdf7f5;
  }

  /* Product Info */
  .product-info {
    display: flex;
    align-items: center;
    gap: 15px;
  }
  .cart-img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border: 1px solid #eee;
    transition: transform 0.3s ease;
  }
  .cart-img:hover {
    transform: scale(1.05);
  }
  .product-name {
    font-weight: 600;
    color: #333;
    font-size: 1rem;
  }

  /* Quantity Input */
  .quantity-box {
    border: 1px solid var(--border-color);
    border-radius: 8px;
    overflow: hidden;
    width: fit-content;
    background: #fff;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
  }
  .quantity-box input {
    width: 60px;
    text-align: center;
    border: none;
    outline: none;
    font-size: 1rem;
    padding: 8px 0;
    background: transparent;
  }
  .quantity-box button {
    background: var(--secondary-color);
    color: #fff;
    border: none;
    padding: 8px 14px;
    font-size: 1.2rem;
    cursor: pointer;
    transition: background 0.3s ease;
  }
  .quantity-box button:hover:not(:disabled) {
    background: #7b3a28;
  }
  .quantity-box button:disabled {
    background: #ccc;
    cursor: not-allowed;
  }

  /* Buttons */
  .remove-item {
    border-color: var(--danger-color);
    color: var(--danger-color);
    font-size: 0.85rem;
    transition: all 0.3s ease;
  }
  .remove-item:hover {
    background: var(--danger-color);
    color: #fff;
  }
  .update-btn {
    border-color: var(--border-color);
    color: var(--primary-color);
  }
  .update-btn:hover {
    background: var(--light-bg);
  }

  /* Totals Box */
  .cart-total-box {
    background: var(--light-bg);
    border: 1px solid var(--border-color);
  }
  .cart-total-box h4 {
    color: var(--primary-color);
  }
  .proceed-btn {
    background: var(--primary-color);
    transition: background 0.3s ease;
  }
  .proceed-btn:hover {
    background: var(--secondary-color);
  }

  /* Empty Cart */
  .empty-cart-icon i {
    opacity: 0.5;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .product-info {
      flex-direction: column;
      align-items: flex-start;
      gap: 10px;
    }
    .cart-img {
      width: 60px;
      height: 60px;
    }
    .quantity-box {
      width: 100%;
      justify-content: center;
    }
    .quantity-box input {
      flex: 1;
    }
    .cart-total-box {
      position: static !important;
    }
  }

  @media (max-width: 576px) {
    .table {
      font-size: 0.9rem;
    }
    .cart-table th, .cart-table td {
      padding: 0.75rem 0.5rem;
    }
    .product-info {
      gap: 8px;
    }
  }
</style>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const csrfToken = '{{ csrf_token() }}';
    const subtotalEl = document.getElementById('subtotal');
    const taxEl = document.getElementById('tax');
    const grandtotalEl = document.getElementById('grandtotal');
    const taxRate = 0.16; // 16% VAT

    // Function to update row total
    function updateRowTotal(row) {
      const qtyInput = row.querySelector('.qty-input');
      const priceCell = row.querySelector('.price');
      const totalCell = row.querySelector('.total');
      let qty = parseInt(qtyInput.value) || 1;
      const maxStock = parseInt(qtyInput.max);
      if (qty > maxStock) qty = maxStock;
      qtyInput.value = qty;

      // Disable buttons based on stock
      row.querySelector('.minus').disabled = qty <= 1;
      row.querySelector('.plus').disabled = qty >= maxStock;

      const price = parseFloat(priceCell.dataset.price);
      const newTotal = (qty * price).toFixed(3);
      totalCell.textContent = `${newTotal} JD`;

      // Update server
      const itemId = row.dataset.itemId;
      fetch(`{{ url('/cart/update') }}/${itemId}`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrfToken,
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ quantity: qty, _method: 'PATCH' })
      }).then(res => res.json()).then(data => {
        console.log(data.message);
        updateCartTotals();
        showToast(data.message || 'Cart updated!', 'success');
        // Trigger mini cart update
        window.dispatchEvent(new CustomEvent('cart-updated', { detail: data }));
      }).catch(err => {
        console.error(err);
        showToast('Update failed!', 'error');
      });
    }

    // Update totals with tax
    function updateCartTotals() {
      let subtotal = 0;
      document.querySelectorAll('.cart-table tbody tr').forEach(row => {
        const totalText = row.querySelector('.total').textContent.replace(' JD', '');
        const totalVal = parseFloat(totalText);
        if (!isNaN(totalVal)) subtotal += totalVal;
      });
      subtotal = parseFloat(subtotal.toFixed(3));
      const tax = parseFloat((subtotal * taxRate).toFixed(3));
      const grandtotal = parseFloat((subtotal + tax).toFixed(3));

      subtotalEl.textContent = `${subtotal.toFixed(3)} JD`;
      taxEl.textContent = `${tax.toFixed(3)} JD`;
      grandtotalEl.textContent = `${grandtotal.toFixed(3)} JD`;
    }

    // Toast function (Bootstrap toast)
    function showToast(message, type = 'success') {
      const toastHTML = `
        <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
            <div class="toast-body">${message}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>`;
      const toastContainer = document.createElement('div');
      toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
      toastContainer.innerHTML = toastHTML;
      document.body.appendChild(toastContainer);
      const toast = new bootstrap.Toast(toastContainer.querySelector('.toast'), { delay: 3000 });
      toast.show();
      setTimeout(() => toastContainer.remove(), 4000);
    }

    // Event delegation
    document.querySelector('.cart-section').addEventListener('click', (e) => {
      const row = e.target.closest('tr');
      if (!row) return;

      if (e.target.classList.contains('plus')) {
        const input = row.querySelector('.qty-input');
        input.value = parseInt(input.value) + 1;
        updateRowTotal(row);
      } else if (e.target.classList.contains('minus')) {
        const input = row.querySelector('.qty-input');
        const current = parseInt(input.value);
        if (current > 1) {
          input.value = current - 1;
          updateRowTotal(row);
        }
      } else if (e.target.classList.contains('remove-item')) {
        const itemId = e.target.dataset.id;
        if (confirm('{{ __("Remove this item?") }}')) {
          fetch(`{{ url('/cart/remove') }}/${itemId}`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': csrfToken,
              'X-Requested-With': 'XMLHttpRequest',
              'Accept': 'application/json',
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({ _method: 'DELETE' })
          }).then(res => res.json()).then(data => {
            row.remove();
            updateCartTotals();
            showToast(data.message || 'Item removed!', 'success');
            if (document.querySelectorAll('.cart-table tbody tr').length === 0) {
              location.reload();
            }
            window.dispatchEvent(new CustomEvent('cart-updated', { detail: data }));
          }).catch(err => {
            console.error(err);
            showToast('Removal failed!', 'error');
          });
        }
      } else if (e.target.classList.contains('update-btn')) {
        showToast('Cart updated!', 'success');
      }
    });

    // Input change
    document.querySelectorAll('.qty-input').forEach(input => {
      input.addEventListener('change', () => {
        let val = parseInt(input.value);
        const min = parseInt(input.min);
        const max = parseInt(input.max);
        if (isNaN(val) || val < min) val = min;
        if (val > max) val = max;
        input.value = val;
        updateRowTotal(input.closest('tr'));
      });
    });

    // Initial totals
    updateCartTotals();
  });
</script>

@endsection
