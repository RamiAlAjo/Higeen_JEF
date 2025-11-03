@extends('front.layouts.app')

@section('content')

<x-hero-section-component page="products.show"/>
<style>
.product-show {
  padding: 60px 0;
  background-color: #f8f9fa;
}

/* Main product image */
.main-img img {
  width: 100%;
  max-width: 400px;
  height: auto;
  object-fit: contain;
  transition: transform 0.3s ease;
}
.main-img img:hover {
  transform: scale(1.05);
}

/* Thumbnails */
.thumbs .thumb-box {
  cursor: pointer;
  transition: all 0.3s;
  border: 2px solid transparent;
}
.thumbs .thumb-box img {
  width: 70px;
  height: 70px;
  object-fit: cover;
}
.thumbs .thumb-box:hover, .thumbs .thumb-box.active {
  border-color: #843c24;
}

/* Product Info */
.product-title {
  font-size: 28px;
  font-weight: 700;
  margin-bottom: 8px;
  color: #333;
}
.product-price {
  font-size: 24px;
  color: #843c24;
  font-weight: 600;
}
.highlight {
  color: #c05040;
  font-weight: 600;
  text-decoration: underline;
}
.product-status .badge, .product-quantity span {
  font-size: 14px;
}
.product-desc {
  margin: 15px 0;
  font-size: 15px;
  line-height: 1.7;
  color: #555;
}

/* Cart Form */
.add-to-cart-form .input-group button {
  font-weight: bold;
}
.cart-btn {
  background: #1c2b45;
  color: #fff;
  border: none;
  padding: 12px 24px;
  font-size: 16px;
  border-radius: 5px;
  transition: background 0.3s;
}
.cart-btn:hover:not(:disabled) {
  background: #0d1a2e;
}
.cart-btn:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

/* Breadcrumb */
.breadcrumb {
  background: none;
  padding: 0;
  margin-bottom: 20px;
}
.breadcrumb-item a {
  color: #843c24;
}

/* Related Products */
.section-title {
  font-size: 22px;
  border-bottom: 2px solid #843c24;
  padding-bottom: 10px;
  margin-bottom: 20px;
}
.card {
  transition: transform 0.3s;
}
.card:hover {
  transform: translateY(-5px);
}

/* Share Icons */
.share-section a {
  font-size: 20px;
  color: #555;
  transition: color 0.3s;
}
.share-section a:hover {
  color: #843c24;
}
</style>

<section class="product-show">
  <div class="container">
    <div class="row">

      <!-- Left: Product Images -->
      <div class="col-md-5 text-center">
        <div class="main-img mb-3">
          <img id="mainProductImage" src="{{ $product->main_image_url }}"
               alt="{{ app()->getLocale() === 'ar' ? $product->product_name_ar : $product->product_name_en }}"
               class="img-fluid border rounded shadow-sm" loading="lazy">
        </div>

        {{-- Thumbnail gallery with click-to-zoom --}}
        @if(!empty($product->gallery_images) && count($product->gallery_images) > 1)
        <div class="thumbs mt-3 d-flex justify-content-center gap-2 flex-wrap">
          @foreach($product->gallery_images as $index => $thumb)
            <div class="thumb-box border rounded overflow-hidden {{ $index === 0 ? 'active' : '' }}"
                 data-image="{{ asset($thumb) }}"
                 onclick="changeMainImage(this)">
              <img src="{{ asset($thumb) }}" alt="Thumbnail {{ $index + 1 }}" class="img-thumbnail" />
            </div>
          @endforeach
        </div>
        @endif
      </div>

      <!-- Right: Product Details -->
      <div class="col-md-7">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('front.homepage') }}">{{ __('home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('front.product') }}">{{ __('products') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ app()->getLocale() === 'ar' ? $product->product_name_ar : $product->product_name_en }}</li>
          </ol>
        </nav>

        <h1 class="product-title">{{ app()->getLocale() === 'ar' ? $product->product_name_ar : $product->product_name_en }}</h1>

        <div class="d-flex align-items-center mb-3">
          <h3 class="product-price me-3">{{ number_format($product->price, 3) }} JD</h3>
          @if($product->quantity > 0 && $product->quantity <= 10)
            <span class="badge bg-warning text-dark">{{ __('Low Stock!') }}</span>
          @endif
        </div>

        <!-- Status -->
        <p class="product-status mb-2">
          <strong>{{ __('Availability') }}:</strong>
          <span class="badge bg-{{ $product->status === 'active' ? 'success' : ($product->status === 'inactive' ? 'danger' : 'warning') }}">
            {{ ucfirst($product->status) }}
          </span>
        </p>

        <!-- Category & Subcategory -->
        <p class="product-category mb-2">{{ __('Category') }}:
          <a href="{{ route('front.product') }}" class="highlight">
            {{ $product->category?->{"name_" . app()->getLocale()} ?? __('Uncategorized') }}
          </a>
        </p>

        @if($product->subcategory)
        <p class="product-category mb-2">{{ __('Subcategory') }}:
          <a href="{{ route('front.product') }}" class="highlight">
            {{ $product->subcategory?->{"name_" . app()->getLocale()} ?? __('N/A') }}
          </a>
        </p>
        @endif

        <!-- Quantity -->
        <p class="product-quantity mb-3">
          <strong>{{ __('In Stock') }}:</strong>
          <span class="{{ $product->quantity < 1 ? 'text-danger' : 'text-success' }}">{{ $product->quantity }} {{ __('items') }}</span>
        </p>

        <!-- Description (localized) -->
        <div class="description mb-4">
          <p class="product-desc">{{ $product->{"description_" . app()->getLocale()} ?: __('No description available.') }}</p>
        </div>

       <!-- Quantity Selector & Add to Cart (AJAX) -->
        <form method="POST" class="add-to-cart-form">
          @csrf
          <div class="input-group mb-3" style="max-width: 150px;">
            <button type="button" class="btn btn-outline-secondary qty-decrease" {{ $product->quantity < 1 ? 'disabled' : '' }} aria-label="{{ __('Decrease Quantity') }}">-</button>
            <input type="number" name="quantity" class="form-control text-center qty-input" value="1" min="1" max="{{ $product->quantity }}" readonly aria-label="{{ __('Quantity') }}">
            <button type="button" class="btn btn-outline-secondary qty-increase" {{ $product->quantity < 1 ? 'disabled' : '' }} aria-label="{{ __('Increase Quantity') }}">+</button>
          </div>

          <button type="button"
                  class="cart-btn btn btn-primary"
                  onclick="addToCart(event, {{ $product->id }})"
                  {{ $product->quantity < 1 ? 'disabled' : '' }}>
            {{ $product->quantity > 0 ? __('Add To Cart') : __('Out of Stock') }}
          </button>
        </form>

        <!-- Share Buttons -->
        <div class="share-section mt-4">
          <strong>{{ __('Share') }}:</strong>
          <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank" class="me-2" aria-label="{{ __('Share on Facebook') }}"><i class="fab fa-facebook"></i></a>
          <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ app()->getLocale() === 'ar' ? $product->product_name_ar : $product->product_name_en }}" target="_blank" class="me-2" aria-label="{{ __('Share on Twitter') }}"><i class="fab fa-twitter"></i></a>
          <a href="https://wa.me/?text={{ url()->current() }}" target="_blank" aria-label="{{ __('Share on WhatsApp') }}"><i class="fab fa-whatsapp"></i></a>
        </div>
      </div>

    </div>

    <!-- Related Products Section -->
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
    <div class="related-products mt-5">
      <h4 class="section-title">{{ __('Related Products') }}</h4>
      <div class="row">
        @foreach($relatedProducts as $related)
          <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm">
              <img src="{{ $related->main_image_url }}" class="card-img-top" alt="{{ app()->getLocale() === 'ar' ? $related->product_name_ar : $related->product_name_en }}">
              <div class="card-body">
                <h5 class="card-title">{{ Str::limit(app()->getLocale() === 'ar' ? $related->product_name_ar : $related->product_name_en, 30) }}</h5>
                <p class="card-text">{{ number_format($related->price, 3) }} JD</p>
                <a href="{{ route('front.product-details', $related->id) }}" class="btn btn-sm btn-outline-primary">{{ __('View') }}</a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
    @endif
  </div>
</section>


<script>
function changeMainImage(element) {
  const newSrc = element.getAttribute('data-image');
  document.getElementById('mainProductImage').src = newSrc;

  // Update active thumbnail
  document.querySelectorAll('.thumb-box').forEach(box => box.classList.remove('active'));
  element.classList.add('active');
}

// Quantity controls
document.querySelectorAll('.qty-increase').forEach(btn => {
  btn.addEventListener('click', function () {
    const input = this.parentElement.querySelector('.qty-input');
    let val = parseInt(input.value);
    const max = parseInt(input.max);
    if (val < max) input.value = val + 1;
  });
});

document.querySelectorAll('.qty-decrease').forEach(btn => {
  btn.addEventListener('click', function () {
    const input = this.parentElement.querySelector('.qty-input');
    let val = parseInt(input.value);
    if (val > 1) input.value = val - 1;
  });
});

function addToCart(event, productId) {
  event.preventDefault();

  const form = document.querySelector('.add-to-cart-form');
  const qtyInput = form.querySelector('.qty-input');
  const quantity = parseInt(qtyInput.value);

  if (!quantity || quantity < 1) {
    alert('Invalid quantity');
    return;
  }

  fetch('{{ route('cart.add') }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json'
    },
    body: JSON.stringify({
      product_id: productId,
      quantity: quantity
    })
  })
    .then(response => {
      if (!response.ok) throw new Error('Request failed');
      return response.json();
    })
    .then(data => {
      alert(data.message || 'Product added to cart!');

      // Update cart badge if exists
      const cartBadge = document.querySelector('.cart-badge');
      if (cartBadge) {
        cartBadge.textContent = data.cart_count;
        cartBadge.style.display = data.cart_count > 0 ? 'inline-block' : 'none';
      }

      window.dispatchEvent(new CustomEvent('cart-updated', { detail: data }));
    })
    .catch(error => {
      console.error('Add to cart failed:', error);
      alert('Failed to add product to cart.');
    });
}
</script>


@endsection
