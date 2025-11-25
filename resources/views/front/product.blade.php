@extends('front.layouts.app')

@section('content')
<x-hero-section-component page="products.index"/>

<style>
    :root {
        --brand: #8b3a2b;
        --brand-dark: #6d2e22;
        --brand-light: #a55847;
        --gray-100: #f8f9fa;
        --gray-200: #e9ecef;
        --gray-600: #6c757d;
        --gray-800: #343a40;
        --success: #2d8b52;
        --radius: 18px;
        --shadow-sm: 0 8px 25px rgba(0,0,0,0.08);
        --shadow-lg: 0 25px 50px rgba(139,58,43,0.18);
        --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .products-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 3rem;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .section-title {
        font-size: 2.4rem;
        font-weight: 800;
        color: var(--gray-800);
        margin: 0;
        letter-spacing: -0.8px;
    }

    .results-count {
        color: var(--gray-600);
        font-weight: 500;
        font-size: 1.05rem;
    }

    /* View Toggle */
    .view-toggle {
        background: white;
        border: 2px solid var(--brand);
        border-radius: 50px;
        overflow: hidden;
        display: inline-flex;
        box-shadow: var(--shadow-sm);
    }

    .view-btn {
        padding: 14px 32px;
        border: none;
        background: transparent;
        color: var(--brand);
        font-weight: 700;
        font-size: 0.95rem;
        transition: var(--transition);
        cursor: pointer;
    }

    .view-btn.active {
        background: var(--brand);
        color: white;
    }

    .view-btn:hover:not(.active) {
        background: rgba(139, 58, 43, 0.1);
    }

    /* Products Container */
    #productsContainer {
        transition: all 0.6s ease;
    }

    .grid-view {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 32px;
    }

    .list-view {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    /* Product Card */
    .product-card {
        background: white;
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        height: 100%;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-14px);
        box-shadow: var(--shadow-lg);
    }

    .product-img-wrapper {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #fdfbfb, #f5f5f5);
    }

    .product-img {
        width: 100%;
        height: 270px;
        object-fit: contain;
        padding: 30px;
        transition: transform 0.7s ease;
    }

    .product-card:hover .product-img {
        transform: scale(1.15);
    }

    .badge-new {
        position: absolute;
        top: 16px;
        left: 16px;
        background: var(--brand);
        color: white;
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 700;
        z-index: 2;
    }

    .product-card-content {
        padding: 26px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .product-title {
        font-size: 1.28rem;
        font-weight: 700;
        color: var(--gray-800);
        margin-bottom: 12px;
        line-height: 1.3;
    }

    .product-description {
        font-size: 0.96rem;
        color: var(--gray-600);
        line-height: 1.65;
        flex-grow: 1;
        margin-bottom: 16px;
    }

    .price {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--brand);
        margin: 14px 0;
    }

    .add-to-cart {
        background: var(--brand);
        color: white;
        border: none;
        padding: 16px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: var(--transition);
        margin-top: auto;
        position: relative;
        overflow: hidden;
    }

    .add-to-cart:hover {
        background: var(--brand-dark);
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(139, 58, 43, 0.35);
    }

    .add-to-cart.loading::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        border: 3px solid transparent;
        border-top-color: white;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        inset: 0;
        margin: auto;
    }

    .add-to-cart.added {
        background: var(--success);
    }

    /* List Mode */
    .product-card.list-mode {
        flex-direction: row;
        padding: 24px;
        gap: 30px;
        align-items: center;
    }

    .product-card.list-mode .product-img-wrapper {
        flex: 0 0 240px;
        height: 240px;
    }

    .product-card.list-mode .product-img {
        height: 100%;
        padding: 20px;
    }

    .product-card.list-mode .add-to-cart {
        min-width: 190px;
        padding: 16px 36px;
    }

    /* Pagination – Perfect #8b3a2b */
    .pagination {
        justify-content: center;
        margin-top: 4rem;
        gap: 10px;
    }

    .page-item .page-link {
        color: var(--brand);
        background: white;
        border: 2px solid transparent;
        border-radius: 50px !important;
        width: 52px;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.05rem;
        transition: var(--transition);
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    }

    .page-item .page-link:hover {
        background: rgba(139, 58, 43, 0.12);
        border-color: var(--brand);
        color: var(--brand);
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(139, 58, 43, 0.2);
    }

    .page-item.active .page-link {
        background: var(--brand) !important;
        color: white !important;
        border-color: var(--brand) !important;
        box-shadow: 0 12px 30px rgba(139, 58, 43, 0.35);
        transform: translateY(-4px);
    }

    .page-item:first-child .page-link,
    .page-item:last-child .page-link {
        font-size: 1.5rem;
        color: var(--brand);
    }

    .page-item:first-child .page-link:hover,
    .page-item:last-child .page-link:hover {
        background: var(--brand);
        color: white;
    }

    .page-item.disabled .page-link {
        color: #aaa;
        background: #f5f5f5;
        cursor: not-allowed;
    }

    /* Sidebar */
    .sidebar-card {
        background: white;
        padding: 28px;
        border-radius: var(--radius);
        margin-bottom: 28px;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(139, 58, 43, 0.08);
    }

    .sidebar-card h5 {
        color: var(--brand);
        font-weight: 800;
        font-size: 1.35rem;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 3px solid var(--brand);
        display: inline-block;
    }

    .sidebar-card ul li a {
        display: block;
        padding: 14px 18px;
        color: var(--gray-800);
        font-weight: 500;
        border-radius: 12px;
        transition: var(--transition);
    }

    .sidebar-card ul li a:hover,
    .sidebar-card ul li.active a {
        background: rgba(139, 58, 43, 0.12);
        color: var(--brand);
        font-weight: 700;
        padding-left: 24px;
    }

    .best-seller {
        display: flex;
        align-items: center;
        padding: 18px;
        border-radius: 16px;
        transition: var(--transition);
        border: 1px solid var(--gray-200);
    }

    .best-seller:hover {
        border-color: var(--brand);
        background: rgba(139, 58, 43, 0.06);
        transform: translateY(-4px);
    }

    .best-seller img {
        width: 74px;
        height: 74px;
        object-fit: contain;
        border-radius: 14px;
        margin-right: 18px;
        border: 2px solid var(--gray-200);
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    @media (max-width: 992px) {
        .grid-view { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 768px) {
        .products-header { flex-direction: column; text-align: center; }
        .section-title { font-size: 2rem; }
        .grid-view { grid-template-columns: 1fr 1fr; gap: 24px; }
        .product-card.list-mode { flex-direction: column; text-align: center; }
    }

    @media (max-width: 480px) {
        .grid-view { grid-template-columns: 1fr; }
        .page-item .page-link { width: 44px; height: 44px; font-size: 0.95rem; }
    }
</style>

<div class="container py-5">
    <div class="products-header">
        <div>
            <h2 class="section-title">Our Collection</h2>
            <p class="results-count">{{ $products->total() }} exquisite products</p>
        </div>

        <div class="view-toggle">
            <button class="view-btn active" data-view="grid">Grid</button>
            <button class="view-btn" data-view="list">List</button>
        </div>
    </div>

    <div class="row">
        <!-- Products -->
        <div class="col-lg-9">
            <div id="productsContainer" class="grid-view">
                @foreach ($products as $product)
                    <article class="product-card" data-id="{{ $product->id }}">
                        @if($product->is_new ?? false)
                            <span class="badge-new">NEW</span>
                        @endif

                        <a href="{{ route('front.product-details', $product->id) }}" class="text-decoration-none">
                            <div class="product-img-wrapper">
                                <img src="{{ $product->image && is_array($product->image) ? asset($product->image[0]) : asset('Uploads/default.jpg') }}"
                                     class="product-img"
                                     alt="{{ $product->product_name_en }}">
                            </div>
                        </a>

                        <div class="product-card-content">
                            <a href="{{ route('front.product-details', $product->id) }}" class="text-decoration-none text-dark">
                                <h3 class="product-title">{{ $product->product_name_en }}</h3>
                                <p class="product-description">
                                    {{ Str::limit($product->description_en ?? 'Handcrafted with premium materials and timeless design.', 110) }}
                                </p>
                            </a>

                            <div class="price">{{ $product->display_price_formatted }} {{ $currency }}</div>

                            <button class="add-to-cart w-100"
        onclick="event.preventDefault(); addToCart(this, {{ $product->id }})">
    Add to Cart
</button>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Beautiful #8b3a2b Pagination -->
            <nav aria-label="Products pagination">
                {{ $products->appends(request()->query())->links() }}
            </nav>
        </div>

        <!-- Luxury Sidebar -->
        <div class="col-lg-3">
            <div class="sidebar-card">
                <h5>Categories</h5>
                <ul class="list-unstyled mb-0">
                    <li class="{{ !request()->has('category') ? 'active' : '' }}">
                        <a href="{{ route('front.product') }}">All Products</a>
                    </li>
                    @foreach ($categories as $category)
                        <li class="{{ request()->get('category') == $category->id ? 'active' : '' }}">
                            <a href="{{ route('front.product', ['category' => $category->id]) }}">{{ $category->name_en }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            @if($subcategories->count() > 0)
            <div class="sidebar-card">
                <h5>Subcategories</h5>
                <ul class="list-unstyled mb-0">
                    @foreach ($subcategories as $subcategory)
                        <li class="{{ request()->get('subcategory') == $subcategory->id ? 'active' : '' }}">
                            <a href="{{ route('front.product', ['subcategory' => $subcategory->id]) }}">{{ $subcategory->name_en }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="sidebar-card">
                <h5>Search Collection</h5>
                <form action="{{ route('front.product') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Search..." value="{{ request()->get('search') }}">
                    <button type="submit" class="btn btn-outline-danger border-2 fw-bold">Go</button>
                </form>
            </div>

            <div class="sidebar-card">
                <h5>Best Sellers</h5>
                @foreach ($bestSellers as $bestSeller)
                    <div class="best-seller mb-3">
                        <img src="{{ $bestSeller->image && is_array($bestSeller->image) ? asset($bestSeller->image[0]) : asset('Uploads/default.jpg') }}"
                             alt="{{ $bestSeller->product_name_en }}">
                        <div>
                            <div class="fw-bold text-dark">{{ $bestSeller->product_name_en }}</div>
                            <div class="text-danger fw-bold">{{ $bestSeller->display_price_formatted }} {{ $currency }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('productsContainer');
        const viewBtns = document.querySelectorAll('.view-btn');
        const savedView = localStorage.getItem('productView') || 'grid';

        // Apply saved view
        container.className = savedView + '-view';
        document.querySelector(`[data-view="${savedView}"]`)?.classList.add('active');

        viewBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const view = this.dataset.view;
                container.className = view + '-view';

                viewBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                localStorage.setItem('productView', view);

                document.querySelectorAll('.product-card').forEach(card => {
                    card.classList.toggle('list-mode', view === 'list');
                });
            });
        });

        // Apply list-mode class if needed
        if (savedView === 'list') {
            document.querySelectorAll('.product-card').forEach(c => c.classList.add('list-mode'));
        }
    });

    // ──────────────────────────────────────────────────────────────
    //  ADD TO CART – FIXED & ROBUST VERSION
    // ──────────────────────────────────────────────────────────────
    function addToCart(button, productId) {
        const originalText = button.innerHTML.trim();

        // UI: loading state
        button.disabled = true;
        button.classList.add('loading');
        button.innerHTML = ''; // spinner is added via CSS

        fetch('{{ route('cart.add') }}', {   // make sure this route points to FrontCartController@add
            method: 'POST',
            credentials: 'same-origin',           // essential for session cookie
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: 1
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            // Success – update UI
            button.classList.remove('loading');
            button.classList.add('added');
            button.innerHTML = 'Added!';

            // Update cart badge (supports both cart_count & item_count)
            const count = data.cart_count ?? data.item_count ?? 0;
            updateCartBadge(count);

            // Optional: dispatch event so mini-cart can refresh
            document.dispatchEvent(new CustomEvent('cart-updated', { detail: { count, data } }));

            // Revert button after 2 seconds
            setTimeout(() => {
                button.classList.remove('added');
                button.innerHTML = originalText;
                button.disabled = false;
            }, 2000);
        })
        .catch(err => {
            console.error('Add to cart failed:', err);

            // Reset button
            button.classList.remove('loading');
            button.innerHTML = originalText;
            button.disabled = false;

            // User-friendly message
            const message = err.message || err.error || 'Failed to add item to cart. Please try again.';
            alert(message);
        });
    }

    // ──────────────────────────────────────────────────────────────
    //  UPDATE CART BADGE (header counter)
    // ──────────────────────────────────────────────────────────────
    function updateCartBadge(count) {
        document.querySelectorAll('.cart-badge').forEach(badge => {
            badge.textContent = count;
            badge.style.display = count > 0 ? 'inline-block' : 'none';
        });
    }

    // Optional: Listen for cart updates elsewhere (e.g. mini-cart dropdown)
    document.addEventListener('cart-updated', function (e) {
        // Example: refresh mini-cart via another endpoint
        // if (typeof refreshMiniCart === 'function') refreshMiniCart();
    });
</script>
@endsection
