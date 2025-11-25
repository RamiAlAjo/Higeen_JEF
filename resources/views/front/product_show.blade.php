{{-- resources/views/front/products/show.blade.php --}}
@extends('front.layouts.app')

@section('content')
<x-hero-section-component page="products.show" />

<style>
    .product-show { padding: 60px 0; background-color: #f8f9fa; }
    .main-img img { width: 100%; max-width: 450px; height: auto; object-fit: contain; transition: transform 0.3s ease; border-radius: 12px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
    .main-img img:hover { transform: scale(1.04); }

    .thumbs .thumb-box { cursor: pointer; transition: all 0.3s; border: 3px solid transparent; border-radius: 8px; overflow: hidden; }
    .thumbs .thumb-box img { width: 80px; height: 80px; object-fit: cover; }
    .thumbs .thumb-box:hover, .thumbs .thumb-box.active { border-color: #8b3a2b; transform: scale(1.05); }

    .product-title { font-size: 32px; font-weight: 700; color: #333; }
    .product-price { font-size: 28px; color: #8b3a2b; font-weight: 700; }
    .highlight { color: #c05040; font-weight: 600; text-decoration: underline; }
    .product-desc { font-size: 16px; line-height: 1.8; color: #555; }

    .cart-btn {
        background: #8b3a2b;
        color: #fff;
        border: none;
        padding: 14px 36px;
        font-size: 17px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
        min-width: 180px;
    }
    .cart-btn:hover:not(:disabled) { background: #6d2e22; }
    .cart-btn:disabled { background: #aaa; cursor: not-allowed; opacity: 0.7; }

    .share-section a { font-size: 24px; color: #666; margin: 0 8px; transition: color 0.3s; }
    .share-section a:hover { color: #8b3a2b; }

    .section-title {
        font-size: 26px;
        font-weight: 700;
        border-bottom: 3px solid #8b3a2b;
        padding-bottom: 10px;
        display: inline-block;
    }

    .qty-btn {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<section class="product-show">
    <div class="container">
        <div class="row">
            <!-- Product Images -->
            <div class="col-lg-5 text-center mb-5 mb-lg-0">
                <div class="main-img mb-4">
                    <img id="mainProductImage"
                         src="{{ $product->main_image_url }}"
                         alt="{{ app()->getLocale() === 'ar' ? $product->product_name_ar : $product->product_name_en }}"
                         class="img-fluid shadow-lg">
                </div>

                @if(!empty($product->gallery_images) && count($product->gallery_images) > 1)
                <div class="thumbs d-flex justify-content-center flex-wrap gap-3">
                    @foreach($product->gallery_images as $index => $thumb)
                    <div class="thumb-box {{ $index === 0 ? 'active' : '' }}"
                         data-image="{{ asset($thumb) }}"
                         onclick="changeMainImage(this)">
                        <img src="{{ asset($thumb) }}" alt="Thumb {{ $index + 1 }}" class="img-thumbnail">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Product Details -->
            <div class="col-lg-7">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('front.homepage') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('front.product') }}">{{ __('Products') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ app()->getLocale() === 'ar' ? $product->product_name_ar : $product->product_name_en }}
                        </li>
                    </ol>
                </nav>

                <h1 class="product-title mt-3">
                    {{ app()->getLocale() === 'ar' ? $product->product_name_ar : $product->product_name_en }}
                </h1>

                <div class="d-flex align-items-center my-3">
                    <h3 class="product-price me-4">{{ $product->display_price_formatted }} {{ $currency }}</h3>
                    @if($product->quantity > 0 && $product->quantity <= 10)
                        <span class="badge bg-warning text-dark fs-6">{{ __('Only :qty left!', ['qty' => $product->quantity]) }}</span>
                    @endif
                </div>

                <p class="mb-2">
                    <strong>{{ __('Availability') }}:</strong>
                    <span class="badge bg-{{ $product->quantity > 0 ? 'success' : 'danger' }} fs-6">
                        {{ $product->quantity > 0 ? __('In Stock') : __('Out of Stock') }}
                    </span>
                </p>

                @if($product->category)
                <p class="mb-2">
                    <strong>{{ __('Category') }}:</strong>
                    <a href="{{ route('front.product', ['category' => $product->category->id]) }}" class="highlight">
                        {{ $product->category->{'name_' . app()->getLocale()} }}
                    </a>
                </p>
                @endif

                <div class="description my-4 p-4 bg-white rounded shadow-sm">
                    <p class="product-desc">
                        {!! nl2br(e($product->{'description_' . app()->getLocale()} ?? __('No description available.'))) !!}
                    </p>
                </div>

                <!-- Add to Cart Form – FIXED & INSTANT -->
                <form id="addToCartForm" class="d-flex align-items-center gap-3 flex-wrap">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="input-group" style="width: 160px;">
                        <button type="button" class="btn btn-outline-secondary qty-decrease qty-btn" {{ $product->quantity <= 0 ? 'disabled' : '' }}>-</button>
                        <input type="number" name="quantity" class="form-control text-center fw-bold qty-input"
                               value="1" min="1" max="{{ $product->quantity }}" readonly>
                        <button type="button" class="btn btn-outline-secondary qty-increase qty-btn" {{ $product->quantity <= 0 ? 'disabled' : '' }}>+</button>
                    </div>

                    <button type="submit" class="cart-btn position-relative" {{ $product->quantity <= 0 ? 'disabled' : '' }}>
                        <span class="btn-text">{{ __('Add to Cart') }}</span>
                        <span class="spinner-border spinner-border-sm ms-2 d-none" role="status"></span>
                    </button>
                </form>

                @if($product->quantity <= 0)
                    <div class="alert alert-danger mt-3">{{ __('This product is currently out of stock.') }}</div>
                @endif

                <!-- Share -->
                <div class="share-section mt-5">
                    <strong class="me-3">{{ __('Share') }}:</strong>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="text-facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($product->product_name_en) }}" target="_blank" class="text-info"><i class="fab fa-twitter"></i></a>
                    <a href="https://wa.me/?text={{ urlencode(url()->current()) }}" target="_blank" class="text-success"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
        <div class="related-products mt-5">
            <h4 class="section-title">{{ __('Related Products') }}</h4>
            <div class="row">
                @foreach($relatedProducts as $related)
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card h-100 shadow-sm border-0 hover-shadow">
                        <img src="{{ $related->main_image_url }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title">{{ Str::limit(app()->getLocale() === 'ar' ? $related->product_name_ar : $related->product_name_en, 40) }}</h6>
                            <p class="text-danger fw-bold mt-auto">{{ $related->display_price_formatted }} {{ $currency }}</p>
                            <a href="{{ route('front.product-details', $related->id) }}" class="btn btn-outline-danger btn-sm mt-2">{{ __('View Details') }}</a>
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
    // Change main image
    function changeMainImage(el) {
        document.getElementById('mainProductImage').src = el.dataset.image;
        document.querySelectorAll('.thumb-box').forEach(t => t.classList.remove('active'));
        el.classList.add('active');
    }

    // Quantity controls
    document.querySelectorAll('.qty-increase').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = btn.closest('.input-group').querySelector('.qty-input');
            const max = parseInt(input.max);
            if (parseInt(input.value) < max) input.value = parseInt(input.value) + 1;
        });
    });

    document.querySelectorAll('.qty-decrease').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = btn.closest('.input-group').querySelector('.qty-input');
            if (parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;
        });
    });

    // ADD TO CART – FULLY FIXED (works instantly, no refresh needed)
    document.getElementById('addToCartForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = this;
        const btn = form.querySelector('.cart-btn');
        const btnText = btn.querySelector('.btn-text');
        const spinner = btn.querySelector('.spinner-border');

        btn.disabled = true;
        btnText.classList.add('d-none');
        spinner.classList.remove('d-none');

        const formData = new FormData(form);

        fetch('{{ route('cart.add') }}', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(r => {
            if (!r.ok) return r.json().then(err => { throw err; });
            return r.json();
        })
        .then(data => {
            // Success feedback
            btnText.textContent = 'Added!';
            btn.classList.add('btn-success');
            setTimeout(() => {
                btnText.textContent = '{{ __("Add to Cart") }}';
                btn.classList.remove('btn-success');
            }, 2000);

            // Update cart badge instantly
            const count = data.cart_count ?? data.item_count ?? 0;
            document.querySelectorAll('.cart-badge, .cart-count, #cart-count, .cart-items-count').forEach(badge => {
                if (badge) {
                    badge.textContent = count;
                    badge.style.display = count > 0 ? 'inline-block' : 'none';
                }
            });

            // Dispatch global event (for mini-cart, Livewire, Alpine, etc.)
            document.dispatchEvent(new CustomEvent('cart-updated', { detail: { count, data } }));
        })
        .catch(err => {
            console.error('Add to cart error:', err);
            let msg = err.message || err.error || 'Failed to add item to cart.';
            if (err.errors) msg = Object.values(err.errors).flat().join(' ');
            alert(msg);
        })
        .finally(() => {
            btn.disabled = {{ $product->quantity <= 0 ? 'true' : 'false' }};
            spinner.classList.add('d-none');
            btnText.classList.remove('d-none');
        });
    });
</script>
@endsection
