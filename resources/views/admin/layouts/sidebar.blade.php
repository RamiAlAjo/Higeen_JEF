<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

<aside class="left-sidebar sidebar-dark" id="left-sidebar">
    <div class="sidebar" id="sidebar">
        <!-- Application Brand -->
        <div class="app-brand">
            <a href="{{ route('admin.admin_home') }}" class="text-decoration-none" aria-label="Admin Dashboard">
                <span class="brand-name">Admin Dashboard</span>
            </a>
        </div>

        <!-- Sidebar Menu with Scroll -->
        <div class="sidebar-left" data-simplebar style="height: calc(100% - 60px);">
            <ul class="nav sidebar-inner" id="sidebar-menu">
                <!-- Dashboard -->
                <li class="{{ Route::is('admin.admin_home') ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{ route('admin.admin_home') }}" aria-label="Go to Dashboard" data-tooltip="Dashboard">
                        <span class="material-symbols-outlined">dashboard</span>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>

                <!-- Homepage Sections -->
                <li class="has-sub {{ Route::is('admin.hero_section.*', 'admin.about-sections.*') ? 'active' : '' }}">
                    <button class="sidenav-item-link" data-bs-toggle="collapse" data-bs-target="#homepage" aria-expanded="false" aria-controls="homepage" aria-label="Toggle Homepage Menu" data-tooltip="Homepage">
                        <span class="material-symbols-outlined">home</span>
                        <span class="nav-text">Homepage</span>
                        <span class="material-symbols-outlined caret">expand_more</span>
                    </button>
                    <ul class="collapse sub-menu" id="homepage">
                        <li class="{{ Route::is('admin.hero_section.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.hero_section.index') }}">Hero Section</a>
                        </li>
                        <li class="{{ Route::is('admin.about-sections.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.about-sections.index') }}">About Section</a>
                        </li>
                    </ul>
                </li>

                <!-- Content Management -->
                <li class="has-sub {{ Route::is('admin.about.*', 'admin.whyus.*') ? 'active' : '' }}">
                    <button class="sidenav-item-link" data-bs-toggle="collapse" data-bs-target="#content" aria-expanded="false" aria-controls="content" aria-label="Toggle Content Menu" data-tooltip="Content">
                        <span class="material-symbols-outlined">article</span>
                        <span class="nav-text">Content</span>
                        <span class="material-symbols-outlined caret">expand_more</span>
                    </button>
                    <ul class="collapse sub-menu" id="content">
                        <li class="{{ Route::is('admin.about.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.about.index') }}">About Page</a>
                        </li>
                        <li class="{{ Route::is('admin.whyus.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.whyus.index') }}">Why Us</a>
                        </li>
                    </ul>
                </li>

                <!-- Products -->
                <li class="has-sub {{ Route::is('admin.product_categories.*', 'admin.product_subcategories.*', 'admin.products.*') ? 'active' : '' }}">
                    <button class="sidenav-item-link" data-bs-toggle="collapse" data-bs-target="#products" aria-expanded="false" aria-controls="products" aria-label="Toggle Products Menu" data-tooltip="Products">
                        <span class="material-symbols-outlined">inventory</span>
                        <span class="nav-text">Products</span>
                        <span class="material-symbols-outlined caret">expand_more</span>
                    </button>
                    <ul class="collapse sub-menu" id="products">
                        <li class="{{ Route::is('admin.product_categories.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.product_categories.index') }}">Categories</a>
                        </li>
                        <li class="{{ Route::is('admin.product_subcategories.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.product_subcategories.index') }}">Subcategories</a>
                        </li>
                        <li class="{{ Route::is('admin.products.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.products.index') }}">Products</a>
                        </li>
                    </ul>
                </li>

                <!-- Images -->
                <li class="{{ Route::is('admin.images.*') ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{ route('admin.images.index') }}" aria-label="Go to Images" data-tooltip="Images">
                        <span class="material-symbols-outlined">image</span>
                        <span class="nav-text">Images</span>
                    </a>
                </li>

                <!-- Gallery -->
                <li class="{{ Route::is('admin.gallery.*') ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{ route('admin.gallery.index') }}" aria-label="Go to Gallery" data-tooltip="Gallery">
                        <span class="material-symbols-outlined">photo_library</span>
                        <span class="nav-text">Gallery</span>
                    </a>
                </li>

                <!-- Orders -->
                <li class="has-sub {{ Route::is('admin.orders.*') ? 'active' : '' }}">
                    <button class="sidenav-item-link" data-bs-toggle="collapse" data-bs-target="#orders" aria-expanded="false" aria-controls="orders" aria-label="Toggle Orders Menu" data-tooltip="Orders">
                        <span class="material-symbols-outlined">shopping_cart</span>
                        <span class="nav-text">Orders</span>
                        <span class="material-symbols-outlined caret">expand_more</span>
                    </button>
                    <ul class="collapse sub-menu" id="orders">
                        <li class="{{ Route::is('admin.orders.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.orders.index') }}">All Orders</a>
                        </li>
                        <li class="{{ Route::is('admin.orders.pending-count') ? 'active' : '' }}">
                            <a href="{{ route('admin.admin.orders.pending-count') }}">Pending Orders</a>
                        </li>
                    </ul>
                </li>

                <!-- Reports -->
                <li class="has-sub {{ Route::is('admin.reports.*') ? 'active' : '' }}">
                    <button class="sidenav-item-link" data-bs-toggle="collapse" data-bs-target="#reports" aria-expanded="false" aria-controls="reports" aria-label="Toggle Reports Menu" data-tooltip="Reports">
                        <span class="material-symbols-outlined">assessment</span>
                        <span class="nav-text">Reports</span>
                        <span class="material-symbols-outlined caret">expand_more</span>
                    </button>
                    <ul class="collapse sub-menu" id="reports">
                        <li class="{{ Route::is('admin.reports.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.reports.index') }}">All Reports</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.reports.sales_by_area.pdf') }}">Sales by Area (PDF)</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.reports.sales_by_product.excel') }}">Sales by Product (Excel)</a>
                        </li>
                    </ul>
                </li>

                <!-- Clients -->
                <li class="{{ Route::is('admin.clients.*') ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{ route('admin.clients.index') }}" aria-label="Go to Clients" data-tooltip="Clients">
                        <span class="material-symbols-outlined">groups</span>
                        <span class="nav-text">Clients</span>
                    </a>
                </li>

                <!-- Settings -->
                <li class="{{ Route::is('admin.setting.*') ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{ route('admin.setting.index') }}" aria-label="Go to Settings" data-tooltip="Settings">
                        <span class="material-symbols-outlined">settings</span>
                        <span class="nav-text">Settings</span>
                    </a>
                </li>

                <!-- Profile -->
                <li class="{{ Route::is('profile.*') ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{ route('profile.edit') }}" aria-label="Go to Profile" data-tooltip="Profile">
                        <span class="material-symbols-outlined">person</span>
                        <span class="nav-text">Profile</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Sidebar Footer -->
        <div class="sidebar-footer">
            <div class="sidebar-footer-content">
                <ul class="d-flex">
                    <li>
                        <a href="{{ route('admin.admin_home') }}" data-bs-toggle="tooltip" title="Dashboard" aria-label="Go to Dashboard">
                            <span class="material-symbols-outlined">dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('front.homepage') }}" data-bs-toggle="tooltip" title="Frontend Home" aria-label="Go to Frontend Home">
                            <span class="material-symbols-outlined">home</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" data-bs-toggle="tooltip" title="Logout" aria-label="Logout">
                            <span class="material-symbols-outlined">logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</aside>

<style>
.left-sidebar {
    width: 250px;
    transition: width 0.3s ease;
}
.sidebar-left {
    overflow-y: auto;
}
.sidebar-inner {
    padding: 0;
    list-style: none;
}
.sidenav-item-link, .sidenav-item-link button {
    display: flex;
    align-items: center;
    padding: 12px 20px;
    color: #fff;
    text-decoration: none;
    transition: background 0.2s;
    width: 100%;
    border: none;
    background: none;
    text-align: left;
}
.sidenav-item-link:hover, .sidenav-item-link button:hover {
    background: rgba(255,255,255,0.1);
}
.nav-text {
    margin-left: 12px;
    font-size: 0.9rem;
}
.caret {
    margin-left: auto;
}
.sub-menu {
    padding-left: 30px;
    background: rgba(0,0,0,0.2);
}
.sub-menu li a {
    padding: 10px 20px;
    display: block;
    color: #ddd;
}
.active {
    background: rgba(255,255,255,0.2);
}
.sidebar-footer {
    position: sticky;
    bottom: 0;
    background: inherit;
}
.sidebar-footer-content ul {
    padding: 0;
    margin: 0;
    gap: 10px;
}
@media (max-width: 768px) {
    .left-sidebar {
        width: 70px;
    }
    .nav-text, .caret {
        display: none;
    }
    .sidenav-item-link, .sidenav-item-link button {
        justify-content: center;
    }
    .sidenav-item-link:hover:after, .sidenav-item-link button:hover:after {
        content: attr(data-tooltip);
        position: absolute;
        left: 80px;
        background: #333;
        color: #fff;
        padding: 5px 10px;
        border-radius: 4px;
        white-space: nowrap;
        z-index: 10;
    }
}
</style>
