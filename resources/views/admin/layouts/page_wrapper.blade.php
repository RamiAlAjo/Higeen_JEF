    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard</title>

    <style>
        /* Modern font stack */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        /* Notification styling */
        .nav-notification {
            position: relative;
            margin-right: 1.2rem;
            transition: all 0.2s ease;
        }

        .nav-notification .nav-link {
            position: relative;
            padding: 0.6rem;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2.6rem;
            height: 2.6rem;
            border-radius: 12px;
            background-color: #ffffff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .nav-notification .nav-link:hover,
        .nav-notification .nav-link:focus {
            background-color: #f1f3f5;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .nav-notification .mdi-bell {
            font-size: 1.3rem;
            color: #6b7280;
            transition: color 0.3s ease;
        }

        .nav-notification .nav-link:hover .mdi-bell,
        .nav-notification .nav-link:focus .mdi-bell {
            color: #dc3545;
        }

        /* Notification badge */
        .nav-notification .badge {
            font-size: 0.65rem;
            font-weight: 700;
            padding: 0.3rem 0.5rem;
            min-width: 1.5rem;
            height: 1.5rem;
            line-height: 1rem;
            text-align: center;
            border-radius: 10px;
            position: absolute;
            top: -6px;
            right: -6px;
            background: linear-gradient(135deg, #ff4d4f, #dc2626);
            color: #fff;
            border: 2px solid #ffffff;
            box-shadow: 0 0 8px rgba(220, 53, 69, 0.3);
            animation: pulse 1.5s infinite ease-in-out;
        }

        .nav-notification .badge.d-none {
            animation: none;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.15); }
            100% { transform: scale(1); }
        }

        /* Loading spinner */
        .notification-loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 1.2rem;
            height: 1.2rem;
            border: 2px solid #6b7280;
            border-top-color: #dc3545;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            display: none;
        }

        @keyframes spin {
            to { transform: translate(-50%, -50%) rotate(360deg); }
        }

        /* Error message */
        .notification-error {
            font-size: 0.75rem;
            font-weight: 500;
            color: #dc3545;
            position: absolute;
            top: calc(100% + 8px);
            left: 50%;
            transform: translateX(-50%);
            background: #fef2f2;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: none;
            z-index: 1000;
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .notification-error.active {
            display: flex;
            align-items: center;
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        .notification-error-close,
        .notification-error-retry {
            margin-left: 0.5rem;
            background: none;
            border: none;
            font-size: 1rem;
            color: #dc3545;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .notification-error-retry {
            background: #dc3545;
            color: #fff;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
        }

        .notification-error-close:hover,
        .notification-error-retry:hover {
            color: #b91c1c;
        }

        .notification-error-retry:hover {
            background: #b91c1c;
        }

        /* Notification dropdown */
        .notification-dropdown {
            position: absolute;
            top: calc(100% + 12px);
            right: 0;
            width: 320px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s;
        }

        .nav-notification:hover .notification-dropdown,
        .nav-notification:focus-within .notification-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .notification-dropdown-header {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e5e7eb;
            font-size: 0.9rem;
            font-weight: 600;
            color: #1f2937;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .notification-dropdown-header .status-label {
            font-size: 0.75rem;
            background: #fef3c7;
            color: #d97706;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
        }

        .notification-dropdown-list {
            list-style: none;
            padding: 0;
            margin: 0;
            max-height: 240px;
            overflow-y: auto;
        }

        .notification-dropdown-list li {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #f3f4f6;
            transition: background-color 0.2s ease;
        }

        .notification-dropdown-list li:hover {
            background-color: #f9fafb;
        }

        .notification-dropdown-list li a {
            display: flex;
            flex-direction: column;
            color: #374151;
            text-decoration: none;
            font-size: 0.85rem;
        }

        .notification-dropdown-list li a .order-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .notification-dropdown-list li a .order-details .order-info {
            flex: 1;
        }

        .notification-dropdown-list li a .order-details .order-info .order-name {
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }

        .notification-dropdown-list li a .order-details .order-info .order-time {
            color: #6b7280;
            font-size: 0.75rem;
        }

        .notification-dropdown-list li a .order-details .order-total {
            font-weight: 600;
            color: #dc3545;
        }

        .notification-dropdown-list li a .order-items {
            font-size: 0.75rem;
            color: #6b7280;
            line-height: 1.4;
        }

        .notification-dropdown-list li a .order-items .item {
            margin-top: 0.25rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }

        .notification-dropdown-list .no-orders {
            padding: 1.5rem 1rem;
            text-align: center;
            color: #6b7280;
            font-size: 0.9rem;
            font-style: italic;
        }

        .notification-dropdown-list .no-orders i {
            margin-right: 0.5rem;
            font-size: 1rem;
            color: #6b7280;
        }

        .notification-dropdown-footer {
            padding: 0.75rem 1rem;
            border-top: 1px solid #e5e7eb;
            text-align: center;
        }

        .notification-dropdown-footer a {
            color: #dc3545;
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .notification-dropdown-footer a:hover {
            color: #b91c1c;
        }

        /* Ripple effect on click */
        .nav-notification .nav-link::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(220, 53, 69, 0.2) 10%, transparent 10.01%);
            border-radius: 12px;
            transform: scale(0);
            animation: ripple 0.5s ease-out;
            pointer-events: none;
        }

        @keyframes ripple {
            to {
                transform: scale(2.5);
                opacity: 0;
            }
        }

        /* RTL support */
        [dir="rtl"] .nav-notification {
            margin-right: 0;
            margin-left: 1.2rem;
        }

        [dir="rtl"] .nav-notification .badge {
            right: auto;
            left: -6px;
        }

        [dir="rtl"] .notification-dropdown {
            right: auto;
            left: 0;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .nav-notification {
                margin-right: 0.8rem;
            }

            .nav-notification .nav-link {
                width: 2.2rem;
                height: 2.2rem;
            }

            .nav-notification .mdi-bell {
                font-size: 1.1rem;
            }

            .notification-error {
                font-size: 0.7rem;
                padding: 0.4rem 0.8rem;
            }

            .notification-dropdown {
                width: 280px;
            }
        }

        /* Accessibility: High contrast mode */
        @media (prefers-contrast: high) {
            .nav-notification .nav-link {
                background-color: #ffffff;
                border: 1px solid #000000;
            }

            .nav-notification .mdi-bell {
                color: #000000;
            }

            .nav-notification .badge {
                background: #ff0000;
                border-color: #000000;
            }

            .notification-error {
                background: #ffffff;
                color: #ff0000;
                border: 1px solid #000000;
            }

            .notification-dropdown {
                background: #ffffff;
                border: 1px solid #000000;
            }
        }

        /* Ensure navbar is visible */
        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 1rem;
        }

        .navbar-right {
            margin-left: auto;
        }

        .nav.navbar-nav {
            display: flex;
            align-items: center;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .user-menu .dropdown-menu {
            min-width: 150px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .dropdown-link-item {
            color: #374151;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
        }

        .dropdown-link-item:hover {
            background-color: #f9fafb;
            color: #dc3545;
        }

        .dropdown-link-item i {
            margin-right: 0.5rem;
        }
    </style>

<div class="container-fluid">
        <!-- Header -->
        <header class="main-header" id="">
            <nav class="navbar navbar-expand-lg navbar-light" id="navbar">
                <!-- Sidebar toggle button -->
                <button id="sidebar-toggler" class="sidebar-toggle" aria-label="Toggle navigation">
                    <span class="sr-only">Toggle navigation</span>
                </button>

                <span class="page-title">Dashboard</span>

                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- Notification -->
                        @if (Auth::check() && Auth::user()->isAdmin())
                            <li class="nav-item nav-notification">
                                <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}"
                                   class="nav-link"
                                   aria-label="{{ __('navbar.new_orders') }}"
                                   title="{{ __('navbar.new_orders') }}"
                                   data-toggle="tooltip"
                                   data-placement="bottom"
                                   aria-haspopup="true"
                                   aria-expanded="false">
                                    <i class="mdi mdi-bell"></i>
                                    <span class="badge badge-danger notification-badge d-none" id="notificationBadge">0</span>
                                    <span class="notification-loading" id="notificationLoading"></span>
                                </a>
                                <div class="notification-error" id="notificationError" role="alert">
                                    <span>Error loading notifications</span>
                                    <button class="notification-error-retry" aria-label="Retry loading notifications">Retry</button>
                                    <button class="notification-error-close" aria-label="Close error message">&times;</button>
                                </div>
                                <div class="notification-dropdown" id="notificationDropdown" role="menu">
                                    <div class="notification-dropdown-header">
                                        <span>Pending Orders</span>
                                        <span class="status-label">Pending</span>
                                    </div>
                                    <ul class="notification-dropdown-list" id="notificationList"></ul>
                                    <div class="notification-dropdown-footer">
                                        <a href="{{ route('admin.orders.index') }}" aria-label="See all orders">See All Orders</a>
                                    </div>
                                </div>
                            </li>
                        @endif

                        <!-- User Account -->
                        <li class="dropdown user-menu">
                            <button class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false">
                                <span class="d-none d-lg-inline-block">{{ Auth::user()->name }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li>
                                    <a class="dropdown-link-item" href="{{ route('profile.edit') }}">
                                        <i class="mdi mdi-account-outline"></i>
                                        <span class="nav-text">My Profile</span>
                                    </a>
                                </li>
                                <li class="dropdown-footer">
                                    <a class="dropdown-link-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="mdi mdi-logout"></i> Log Out
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

        <!-- Content Wrapper -->
        <div class="content-wrapper" style="background-color: #f0f1f5;">
            <div class="content">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Animate notification badge
            function animateNotificationBadge() {
                const badge = document.getElementById('notificationBadge');
                if (badge) {
                    badge.classList.remove('pulse');
                    void badge.offsetWidth; // Force reflow
                    badge.classList.add('pulse');
                }
            }

            // Update notification badge, error, and dropdown
            function updateNotificationBadge(count, errorMessage = 'Error loading notifications', orders = []) {
                const badge = document.getElementById('notificationBadge');
                const error = document.getElementById('notificationError');
                const loading = document.getElementById('notificationLoading');
                const list = document.getElementById('notificationList');
                const navLink = document.querySelector('.nav-notification .nav-link');

                if (loading) loading.style.display = 'none';

                if (badge && count >= 0) {
                    badge.textContent = count;
                    badge.classList.toggle('d-none', count === 0);
                    if (count > 0) animateNotificationBadge();
                    if (error) {
                        error.classList.remove('active');
                        error.style.display = 'none';
                    }
                    // Populate dropdown with pending orders
                    if (list) {
                        list.innerHTML = '';
                        if (orders.length > 0) {
                            orders.forEach(order => {
                                const itemsPreview = order.items && order.items.length > 0
                                    ? order.items.map(item => `<div class="item">${item.quantity}x ${item.name}</div>`).join('')
                                    : `<div class="item">No items</div>`;
                                const moreItems = order.items_count > (order.items ? order.items.length : 0)
                                    ? `<div class="item">...and ${order.items_count - (order.items ? order.items.length : 0)} more item(s)</div>`
                                    : '';
                                const li = document.createElement('li');
                                li.innerHTML = `
                                    <a href="${'{{ route("admin.orders.index") }}?status=pending&id=' + order.id}"
                                       aria-label="View pending order #${order.id} for ${order.full_name}">
                                        <div class="order-details">
                                            <div class="order-info">
                                                <div class="order-name">${order.full_name} (#${order.id})</div>
                                                <div class="order-time">${order.created_at}</div>
                                            </div>
                                            <div class="order-total">JOD ${order.total}</div>
                                        </div>
                                        <div class="order-items">${itemsPreview}${moreItems}</div>
                                    </a>
                                `;
                                list.appendChild(li);
                            });
                        } else {
                            list.innerHTML = '<li class="no-orders"><i class="mdi mdi-bell-off-outline"></i> No pending orders</li>';
                        }
                    }
                    if (navLink) navLink.setAttribute('aria-expanded', orders.length > 0 ? 'true' : 'false');
                } else {
                    if (badge) badge.classList.add('d-none');
                    if (error) {
                        error.querySelector('span').textContent = errorMessage;
                        error.classList.add('active');
                        error.style.display = 'flex';
                        setTimeout(() => {
                            error.classList.remove('active');
                            error.style.display = 'none';
                        }, 5000);
                    }
                    if (list) list.innerHTML = '<li class="no-orders"><i class="mdi mdi-bell-off-outline"></i> No pending orders</li>';
                    if (navLink) navLink.setAttribute('aria-expanded', 'false');
                }
            }

            // Handle error close and retry buttons
            const closeButton = document.querySelector('.notification-error-close');
            const retryButton = document.querySelector('.notification-error-retry');
            if (closeButton) {
                closeButton.addEventListener('click', () => {
                    const error = document.getElementById('notificationError');
                    if (error) {
                        error.classList.remove('active');
                        error.style.display = 'none';
                    }
                });
            }
            if (retryButton) {
                retryButton.addEventListener('click', loadNotificationCount);
            }

            // Load notification count and orders
            function loadNotificationCount() {
                const loading = document.getElementById('notificationLoading');
                if (loading) loading.style.display = 'block';

                fetch('{{ route("admin.admin.orders.pending") }}', {
                    method: 'GET',
                    credentials: 'same-origin',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(res => {
                    if (!res.ok) {
                        return res.text().then(text => {
                            throw new Error(`HTTP error! Status: ${res.status}, Message: ${text || 'Unknown error'}`);
                        });
                    }
                    return res.json();
                })
                .then(data => {
                    console.log('API Response:', data); // Debug: Log API response
                    if (data.pending_count !== undefined && data.pending_orders !== undefined) {
                        updateNotificationBadge(data.pending_count, 'Error loading notifications', data.pending_orders);
                    } else {
                        console.error('Invalid response format:', data);
                        updateNotificationBadge(0, data.error || 'Invalid response format', []);
                    }
                })
                .catch(err => {
                    console.error('Notification fetch error:', err.message);
                    updateNotificationBadge(0, 'Failed to load notifications', []);
                });
            }

            // Initialize tooltips
            if (typeof bootstrap !== 'undefined') {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'));
                tooltipTriggerList.forEach(tooltipTriggerEl => {
                    new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }

            // Initial load and periodic refresh
            @if (Auth::check() && Auth::user()->isAdmin())
                loadNotificationCount();
                setInterval(loadNotificationCount, 30000); // Refresh every 60 seconds
            @endif
        });
    </script>
