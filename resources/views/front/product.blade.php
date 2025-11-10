@extends('front.layouts.app')

@section('content')

<x-hero-section-component page="products.index"/>

<style>
  /* Page Title */
  .section-title {
    color: #8b3a2b;
    font-weight: 700;
    margin-bottom: 25px;
  }

  /* Product Card - GRID VIEW */
  .product-card {
    border: 1px solid #ddd;
    padding-top: 20px;
    text-align: center;
    transition: all 0.3s ease-in-out;
    background: #fff;
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  .product-card:hover {
    border-color: #2e3a59;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
  }

  .product-img {
    max-height: 200px;
    object-fit: contain;
    margin-bottom: 12px;
    transition: transform 0.3s ease-in-out;
    max-width: -webkit-fill-available;
  }

  .product-card:hover .product-img {
    transform: scale(1.05);
  }

  .product-title {
    font-size: 0.95rem;
    font-weight: 500;
    margin-bottom: 8px;
    color: #222;
    min-height: 38px;
  }

  .product-description {
    font-size: 0.8rem;
    color: #666;
    margin-bottom: 10px;
    line-height: 1.4;
    flex-grow: 1;
  }

  .read-more {
    color: #8b3a2b;
    font-size: 0.8rem;
    font-weight: 500;
    text-decoration: none;
    display: inline-block;
    margin-top: 6px;
    transition: color 0.2s ease;
  }

  .read-more:hover {
    color: #a04637;
    text-decoration: underline;
  }

  .price {
    font-weight: 600;
    color: #333;
    margin-bottom: auto;
    padding: 8px 0;
  }

  /* Cart Button */
  .add-to-cart {
    display: none;
    width: 100%;
    background: #2e3a59;
    color: #fff;
    padding: 10px 0;
    font-size: 0.9rem;
    border: none;
    border-radius: 2px;
    transition: background 0.3s;
    margin-top: auto;
  }

  .product-card:hover .add-to-cart {
    display: block;
  }

  .add-to-cart:hover {
    background: #1c243a;
  }

  @media (max-width: 768px) {
    .add-to-cart { display: block; }
  }

  /* Sidebar */
  .sidebar { padding-left: 20px; border-left: 1px solid #ddd; }
  .sidebar h5 { color: #8b3a2b; font-weight: 600; margin-bottom: 15px; }
  .sidebar ul { list-style: none; padding-left: 0; }
  .sidebar ul li { margin-bottom: 8px; }
  .sidebar ul li.active { color: #8b3a2b; font-weight: bold; }
  .sidebar .search-box input { border: 1px solid #8b3a2b; }
  .sidebar .search-box button { background: none; border: none; color: #8b3a2b; }

  /* Best Sellers & Pagination */
  .best-seller { display: flex; align-items: center; margin-bottom: 12px; }
  .best-seller img { width: 40px; height: 40px; object-fit: contain; margin-right: 10px; }
  .best-seller span { font-size: 0.9rem; line-height: 1.2; }
  .pagination .page-link { border: none; color: #8b3a2b; }
  .pagination .active .page-link { background: #8b3a2b; color: #fff; border-radius: 3px; }
</style>

<div class="container py-5 bg-light">
    <h2 class="section-title">Products</h2>

    <div class="row">
        <!-- Product Grid -->
        <div class="col-lg-9">
            <div class="row g-4" id="productsContainer">
                @foreach ($products as $product)
                    <div class="col-md-4 col-sm-6 d-flex">
                        <article class="product-card w-100">
                            <a href="{{ route('front.product-details', ['id' => $product->id]) }}" style="text-decoration: none; color: inherit;">
                                <img
                                    src="{{ $product->image && is_array($product->image) && !empty($product->image) ? asset($product->image[0]) : asset('Uploads/default.jpg') }}"
                                    class="product-img"
                                    alt="{{ $product->product_name_en ?? 'Unnamed Product' }}"
                                >
                                <div class="product-card-content px-3">
                                    <h6 class="product-title">{{ $product->product_name_en ?? 'Unnamed Product' }}</h6>

                                    <p class="product-description">
                                        {{ Str::limit($product->description_en ?? 'No description available.', 120) }}
                                    </p>

                                    @if(strlen($product->description_en ?? '') > 120)
                                        <a href="{{ route('front.product-details', ['id' => $product->id]) }}" class="read-more">
                                            Read more
                                        </a>
                                    @endif
                                </div>
                            </a>

                            <p class="price">{{ $product->display_price_formatted }} {{ $currency }}</p>

                            <button class="add-to-cart"
                                    data-product-id="{{ $product->id }}"
                                    onclick="addToCart({{ $product->id }})">
                                ADD TO CART <i class="fas fa-shopping-cart ms-1"></i>
                            </button>
                        </article>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <nav class="mt-4">
                {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
            </nav>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-3 sidebar">
            <h5>Categories</h5>
            <ul>
                @foreach ($categories as $category)
                    <li class="{{ request()->query('category') == $category->id ? 'active' : '' }}">
                        <a href="{{ route('front.product', ['category' => $category->id]) }}">{{ $category->name_en }}</a>
                    </li>
                @endforeach
            </ul>

            <h5 class="mt-4">Subcategories</h5>
            <ul>
                @foreach ($subcategories as $subcategory)
                    <li class="{{ request()->query('subcategory') == $subcategory->id ? 'active' : '' }}">
                        <a href="{{ route('front.product', ['subcategory' => $subcategory->id]) }}">{{ $subcategory->name_en }}</a>
                    </li>
                @endforeach
            </ul>

            <h5 class="mt-4">Search</h5>
            <form action="{{ route('front.product') }}" method="GET" class="search-box input-group">
                <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request()->query('search') }}">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                <a href="{{ route('front.product') }}" class="btn btn-secondary"><i class="fas fa-times"></i></a>
            </form>

            <h5 class="mt-4">Best Sellers</h5>
            @foreach ($bestSellers as $bestSeller)
                <div class="best-seller">
                    <img src="{{ $bestSeller->image && is_array($bestSeller->image) && !empty($bestSeller->image) ? asset($bestSeller->image[0]) : asset('Uploads/default.jpg') }}"
                         alt="{{ $bestSeller->product_name_en ?? 'Unnamed Product' }}">
                    <span>{{ $bestSeller->product_name_en ?? 'Unnamed Product' }}<br>{{ $bestSeller->display_price_formatted }} {{ $currency }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    function addToCart(productId) {
        fetch('{{ route('cart.add') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ product_id: productId, quantity: 1 }),
        })
        .then(response => {
            if (!response.ok) throw new Error('Network error');
            return response.json();
        })
        .then(data => {
            alert(data.message);
            updateCartBadge(data.cart_count);
        })
        .catch(() => alert('Failed to add product to cart.'));
    }

    function updateCartBadge(count) {
        document.querySelectorAll('.cart-badge').forEach(badge => {
            badge.textContent = count;
            badge.style.display = count > 0 ? 'block' : 'none';
        });

        if (count > 0 && !document.querySelector('.cart-badge')) {
            document.querySelectorAll('.nav-cart .bi-cart').forEach(icon => {
                const badge = document.createElement('span');
                badge.className = 'cart-badge';
                badge.textContent = count;
                icon.parentElement.appendChild(badge);
            });
        }
    }
</script>

@endsection
