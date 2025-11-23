<style>
    :root {
        --primary-color: #A13A28;
        --secondary-color: #7A2A1C;
        --text-color: #333333;
        --light-bg: #FFFFFF;
        --border-color: #E0E0E0;
        --shadow-sm: 0 4px 16px rgba(0, 0, 0, 0.08);
        --shadow-md: 0 6px 24px rgba(0, 0, 0, 0.12);
        --transition: all 0.3s ease-in-out;
        --font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* Container Fluid */
    .container-fluid {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }

    /* Top Strip */
    .top-strip {
        background: linear-gradient(135deg, var(--primary-color) 20%, var(--secondary-color) 80%);
        z-index: 1100;
        font-family: var(--font-family);
        width: 100%;
        padding: 0.9rem 0;
        box-shadow: var(--shadow-sm);
    }
    .top-strip .container-fluid {
        padding: 0 2rem;
    }
    .top-strip span {
        font-size: 0.95rem;
        color: #FFFFFF;
        font-weight: 600;
        letter-spacing: 0.06rem;
        text-transform: uppercase;
        transition: var(--transition);
    }
    .top-strip img {
        height: 36px;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        transition: transform var(--transition);
    }
    .top-strip img:hover {
        transform: scale(1.1) rotate(2deg);
    }
    @media (max-width: 576px) {
        .top-strip span {
            font-size: 0.9rem;
        }
        .top-strip img {
            height: 30px;
        }
        .top-strip .container-fluid {
            padding: 0 1rem;
        }
    }
    [dir="rtl"] .top-strip span {
        margin-left: 0.75rem;
        margin-right: 0;
    }

    /* Navbar */
    .NAVBAR {
        backdrop-filter: saturate(200%) blur(24px);
        background-color: rgba(255, 255, 255, 0.95);
        border-bottom: 1px solid rgba(161, 58, 40, 0.25);
        transition: var(--transition);
        z-index: 1099;
        position: sticky;
        top: 0;
        box-shadow: var(--shadow-sm);
    }
    .NAVBAR.sticky-shadow {
        box-shadow: var(--shadow-md);
        background-color: rgba(255, 255, 255, 1);
    }
    .navbar-brand {
        flex: 0 1 auto;
        max-width: 200px;
        margin: 0 1rem;
        text-align: center;
    }
    .NAVBAR-logo {
        max-height: 82px;
        opacity: 0;
        transform: translateY(-10px);
        transition: opacity 0.6s ease, transform 0.6s ease;
        filter: drop-shadow(0 3px 5px rgba(0, 0, 0, 0.1));
        width: auto;
        max-width: 100%;
        object-fit: contain;
        padding: 0;
    }
    .NAVBAR-logo:hover {
        transform: translateY(-2px) scale(1.04);
    }
    .fade-in {
        opacity: 1 !important;
        transform: translateY(0) !important;
    }
    .NAVBAR-link {
        position: relative;
        margin: 0 0.8rem;
        font-size: 0.98rem;
        text-transform: uppercase;
        color: var(--text-color);
        font-weight: 500;
        transition: var(--transition);
        letter-spacing: 0.04rem;
        border-radius: 12px;
        z-index: 1101;
        pointer-events: auto;
    }
    .NAVBAR-link::after {
        content: "";
        position: absolute;
        width: 0;
        height: 2.5px;
        bottom: 3px;
        left: 50%;
        background-color: var(--primary-color);
        transition: width 0.3s ease, left 0.3s ease;
        transform: translateX(-50%);
        border-radius: 2px;
    }
    .NAVBAR-link:hover::after,
    .NAVBAR-link.active::after {
        width: 80%;
    }
    .NAVBAR-link.active,
    .NAVBAR-link:hover {
        color: var(--primary-color);
        font-weight: 600;
        background: linear-gradient(90deg, rgba(161, 58, 40, 0.1), rgba(161, 58, 40, 0.05));
        transform: scale(1.03);
    }
    .NAVBAR-link:focus {
        outline: 2px solid var(--primary-color);
        outline-offset: 3px;
        border-radius: 6px;
    }
    [dir="rtl"] .NAVBAR-link {
        margin: 0 0.8rem 0 0;
    }

    /* Left Section */
    .d-flex.order-1.order-lg-1 {
        flex: 1;
        padding-right: 1rem;
    }

    /* Right Section */
    .d-none.d-lg-flex.order-3 {
        flex: 1;
        justify-content: flex-end;
        padding-left: 1rem;
    }

    /* Social Icons */
    .NAVBAR-social {
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .NAVBAR-social a {
        font-size: 1.25rem;
        color: var(--primary-color);
        transition: var(--transition);
        padding: 0.65rem;
        border-radius: 50%;
        background-color: rgba(161, 58, 40, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2.4rem;
        height: 2.4rem;
        z-index: 1101;
    }
    .NAVBAR-social a:hover {
        color: #FFFFFF;
        background-color: var(--primary-color);
        transform: translateY(-3px) scale(1.1);
        box-shadow: var(--shadow-sm);
    }
    .NAVBAR-social a:focus {
        outline: 2px solid var(--primary-color);
        outline-offset: 4px;
    }

    /* Locale Switcher (Language + Currency) */
    .navbar-locale {
        margin-left: 1rem;
        position: relative;
        z-index: 1101;
    }
    .navbar-locale .nav-link {
        font-size: 0.92rem;
        color: var(--text-color);
        font-weight: 500;
        padding: 0.65rem 1.1rem;
        border-radius: 14px;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background-color: rgba(161, 58, 40, 0.1);
    }
    .navbar-locale .nav-link:hover,
    .navbar-locale .nav-link:focus {
        color: var(--primary-color);
        background-color: rgba(161, 58, 40, 0.15);
        transform: scale(1.04);
        box-shadow: var(--shadow-sm);
    }
    .navbar-locale .nav-link:focus {
        outline: 2px solid var(--primary-color);
        outline-offset: 3px;
    }
    .navbar-locale .bi-globe {
        font-size: 1.15rem;
        transition: transform 0.5s ease;
    }
    .navbar-locale .nav-link:hover .bi-globe,
    .navbar-locale .nav-link:focus .bi-globe {
        transform: rotate(180deg);
    }
    .navbar-locale .selected-locale {
        font-weight: 600;
        letter-spacing: 0.03rem;
    }
    .navbar-locale .dropdown-menu {
        border-radius: 16px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-md);
        padding: 0.7rem 0;
        min-width: 12.5rem;
        margin-top: 0.6rem;
        background: var(--light-bg);
        animation: dropdownFade 0.3s ease-out;
        z-index: 1102;
    }
    .navbar-locale .dropdown-header {
        font-size: 0.85rem;
        color: #666;
        font-weight: 600;
        padding: 0.5rem 1.3rem;
        text-transform: uppercase;
        letter-spacing: 0.05rem;
    }
    .navbar-locale .dropdown-item {
        font-size: 0.92rem;
        padding: 0.65rem 1.3rem;
        color: var(--text-color);
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.7rem;
        transition: var(--transition);
        border-radius: 8px;
        margin: 0 0.6rem;
    }
    .navbar-locale .dropdown-item:hover,
    .navbar-locale .dropdown-item:focus {
        background: linear-gradient(90deg, rgba(161, 58, 40, 0.1), rgba(161, 58, 40, 0.05));
        color: var(--primary-color);
        transform: translateX(3px);
    }
    .navbar-locale .dropdown-item.active {
        background: linear-gradient(90deg, rgba(161, 58, 40, 0.15), rgba(161, 58, 40, 0.1));
        color: var(--primary-color);
        font-weight: 600;
        border-left: 3px solid var(--primary-color);
    }
    .navbar-locale .dropdown-item:focus {
        outline: none;
        background: linear-gradient(90deg, rgba(161, 58, 40, 0.15), rgba(161, 58, 40, 0.1));
    }
    @keyframes dropdownFade {
        from {
            opacity: 0;
            transform: translateY(-10px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    [dir="rtl"] .navbar-locale {
        margin-left: 0;
        margin-right: 1rem;
    }
    [dir="rtl"] .navbar-locale .dropdown-item {
        flex-direction: row-reverse;
        border-left: none;
        border-right: 3px solid var(--primary-color);
        transform: translateX(0);
    }
    [dir="rtl"] .navbar-locale .dropdown-item:hover,
    [dir="rtl"] .navbar-locale .dropdown-item:focus {
        transform: translateX(-3px);
    }

    /* Avatar Icon */
    .navbar-avatar {
        margin-left: 1rem;
        position: relative;
        z-index: 1101;
    }
    .navbar-avatar .nav-link {
        font-size: 0.92rem;
        color: var(--text-color);
        font-weight: 500;
        padding: 0.65rem;
        border-radius: 50%;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(161, 58, 40, 0.1);
        width: 2.4rem;
        height: 2.4rem;
    }
    .navbar-avatar .nav-link:hover,
    .navbar-avatar .nav-link:focus {
        color: var(--primary-color);
        background-color: rgba(161, 58, 40, 0.15);
        transform: scale(1.1);
        box-shadow: var(--shadow-sm);
    }
    .navbar-avatar .nav-link:focus {
        outline: 2px solid var(--primary-color);
        outline-offset: 3px;
    }
    .navbar-avatar .bi-person-circle {
        font-size: 1.25rem;
    }
    .navbar-avatar .dropdown-menu {
        border-radius: 16px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-md);
        padding: 0.7rem 0;
        min-width: 12.5rem;
        margin-top: 0.6rem;
        background: var(--light-bg);
        animation: dropdownFade 0.3s ease-out;
    }
    .navbar-avatar .dropdown-item {
        font-size: 0.92rem;
        padding: 0.65rem 1.3rem;
        color: var(--text-color);
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.7rem;
        transition: var(--transition);
        border-radius: 8px;
        margin: 0 0.6rem;
    }
    .navbar-avatar .dropdown-item:hover,
    .navbar-avatar .dropdown-item:focus {
        background: linear-gradient(90deg, rgba(161, 58, 40, 0.1), rgba(161, 58, 40, 0.05));
        color: var(--primary-color);
        transform: translateX(3px);
    }
    .navbar-avatar .dropdown-item.active {
        background: linear-gradient(90deg, rgba(161, 58, 40, 0.15), rgba(161, 58, 40, 0.1));
        color: var(--primary-color);
        font-weight: 600;
        border-left: 3px solid var(--primary-color);
    }
    .navbar-avatar .dropdown-item:focus {
        outline: none;
        background: linear-gradient(90deg, rgba(161, 58, 40, 0.15), rgba(161, 58, 40, 0.1));
    }
    [dir="rtl"] .navbar-avatar {
        margin-left: 0;
        margin-right: 1rem;
    }
    [dir="rtl"] .navbar-avatar .dropdown-item {
        flex-direction: row-reverse;
        border-left: none;
        border-right: 3px solid var(--primary-color);
        transform: translateX(0);
    }
    [dir="rtl"] .navbar-avatar .dropdown-item:hover,
    [dir="rtl"] .navbar-avatar .dropdown-item:focus {
        transform: translateX(-3px);
    }

    /* Burger Icon */
    .custom-toggler {
        border: none;
        background: transparent;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 24px;
        width: 30px;
        padding: 0;
        z-index: 1200;
        transition: var(--transition);
    }
    .custom-toggler:hover {
        transform: scale(1.1);
    }
    .custom-toggler:hover .toggler-icon {
        background-color: var(--secondary-color);
    }
    .custom-toggler:focus {
        outline: 2px solid var(--primary-color);
        outline-offset: 3px;
    }
    .toggler-icon {
        height: 3px;
        width: 100%;
        background-color: var(--primary-color);
        border-radius: 3px;
        transition: transform 0.4s ease, opacity 0.4s ease, background-color 0.3s ease;
    }
    .custom-toggler.open .top-bar {
        transform: rotate(45deg) translate(7px, 7px);
    }
    .custom-toggler.open .middle-bar {
        opacity: 0;
    }
    .custom-toggler.open .bottom-bar {
        transform: rotate(-45deg) translate(7px, -7px);
    }

    /* Collapse Panel (Mobile) */
    .custom-collapse {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        background: var(--light-bg);
        z-index: 1100;
        padding: 1.6rem 0;
        box-shadow: var(--shadow-md);
        transition: transform 0.4s ease, opacity 0.4s ease;
        transform: translateY(-12px);
        opacity: 0;
        pointer-events: none;
    }
    .custom-collapse.show {
        display: block;
        transform: translateY(0);
        opacity: 1;
        pointer-events: auto;
    }
    body.menu-open {
        overflow: hidden;
    }

    /* Responsive: Large Screens */
    @media (min-width: 992px) {
        .custom-toggler {
            display: none !important;
        }
        .custom-collapse {
            display: flex !important;
            position: static !important;
            flex-direction: row;
            align-items: center;
            background: transparent;
            box-shadow: none;
            transform: none !important;
            opacity: 1 !important;
            padding: 0;
            z-index: auto;
        }
        .navbar-nav {
            flex-direction: row !important;
            gap: 0.5rem;
        }
        .NAVBAR-social.d-lg-none {
            display: none !important;
        }
        .NAVBAR-social {
            gap: 0.8rem;
        }
        .nav-cart:hover .mini-cart-dropdown,
        .navbar-avatar:hover .dropdown-menu,
        .navbar-locale:hover .dropdown-menu {
            display: block;
            animation: dropdownFade 0.3s ease-out;
        }
    }

    /* Responsive: Small Screens */
    @media (max-width: 991.98px) {
        .container-fluid {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        .navbar-brand {
            margin: 0 0.5rem;
            max-width: 150px;
        }
        .NAVBAR-link {
            font-size: 1.05rem;
            padding: 0.9rem 1.3rem;
            margin: 0;
            border-bottom: 1px solid var(--border-color);
        }
        .NAVBAR-link:hover {
            background-color: rgba(161, 58, 40, 0.08);
            padding-left: 1.6rem;
        }
        .NAVBAR-logo {
            max-height: 52px;
        }
        .NAVBAR-social {
            justify-content: center;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
            gap: 0.9rem;
        }
        .NAVBAR-social a {
            font-size: 1.5rem;
            width: 2.6rem;
            height: 2.6rem;
        }
        .navbar-locale,
        .navbar-avatar {
            margin-top: 1.2rem;
            margin-left: 0;
            width: 100%;
            text-align: center;
        }
        .navbar-locale .nav-link,
        .navbar-avatar .nav-link {
            justify-content: center;
            font-size: 1.05rem;
            padding: 0.9rem 1.4rem;
            border-radius: 10px;
        }
        .navbar-locale .dropdown-menu,
        .navbar-avatar .dropdown-menu {
            width: 90%;
            margin: 0.6rem auto;
            border-radius: 12px;
        }
        .navbar-locale .dropdown-item,
        .navbar-avatar .dropdown-item {
            padding: 0.8rem 1.2rem;
        }
        .custom-collapse {
            display: none;
        }
        .custom-collapse.show {
            display: block;
        }
        .d-flex.order-1.order-lg-1 {
            padding-right: 0.5rem;
        }
    }

    /* Cart Icon */
    .NAVBAR .bi-cart {
        font-size: 1.45rem;
        color: var(--primary-color);
        transition: var(--transition);
    }
    .NAVBAR .bi-cart:hover {
        transform: rotate(10deg) scale(1.2);
        color: var(--secondary-color);
    }
    .nav-cart:focus .bi-cart {
        outline: 2px solid var(--primary-color);
        outline-offset: 3px;
    }

    /* Cart Badge */
    .cart-badge {
        font-size: 0.7rem;
        padding: 0.25rem 0.45rem;
        min-width: 18px;
        height: 18px;
        line-height: 1.1rem;
        text-align: center;
        border-radius: 50%;
        position: absolute;
        top: -9px;
        right: -9px;
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: #FFFFFF;
        font-weight: 600;
        animation: bounceIn 0.4s ease;
        box-shadow: 0 2px 5px rgba(220, 53, 69, 0.25);
        border: 1.5px solid #FFFFFF;
    }
    @keyframes bounceIn {
        0% { transform: scale(0); opacity: 0; }
        50% { transform: scale(1.3); }
        100% { transform: scale(1); opacity: 1; }
    }
    .nav-cart {
        padding: 0.6rem;
        border-radius: 50%;
        transition: var(--transition);
        z-index: 1101;
    }
    .nav-cart:hover {
        background-color: rgba(161, 58, 40, 0.1);
    }

    /* Mini Cart Dropdown */
    .mini-cart-dropdown {
        position: absolute;
        top: 100%;
        right: 0;
        width: 380px;
        max-height: 85vh;
        background-color: var(--light-bg);
        border: 1px solid var(--border-color);
        border-radius: 14px;
        box-shadow: var(--shadow-md);
        display: none;
        z-index: 1200;
        overflow: hidden;
        animation: dropdownFade 0.3s ease-out;
    }
    .mini-cart-dropdown::before {
        content: '';
        position: absolute;
        top: -10px;
        right: 22px;
        border-left: 10px solid transparent;
        border-right: 10px solid transparent;
        border-bottom: 10px solid var(--light-bg);
        z-index: 1201;
    }
    .mini-cart-header {
        background: linear-gradient(135deg, var(--primary-color) 20%, var(--secondary-color));
        color: #FFFFFF;
        padding: 1.1rem 1.4rem;
        font-weight: 600;
        font-size: 1.1rem;
        border-top-left-radius: 14px;
        border-top-right-radius: 14px;
        text-align: center;
        letter-spacing: 0.03rem;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    }
    .mini-cart-content {
        padding: 1.2rem;
        max-height: 320px;
        overflow-y: auto;
    }
    .mini-cart-item {
        display: flex;
        align-items: flex-start;
        gap: 0.9rem;
        padding: 0.9rem 0;
        border-bottom: 1px dashed var(--border-color);
        transition: var(--transition);
        border-radius: 8px;
        margin: 0 -0.6rem;
        padding: 0.9rem 0.6rem;
    }
    .mini-cart-item:hover {
        background-color: rgba(161, 58, 40, 0.08);
        transform: translateY(-2px);
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.06);
    }
    .mini-cart-item:last-child {
        border-bottom: none;
    }
    .mini-cart-item img {
        width: 64px;
        height: 64px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid var(--border-color);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: transform var(--transition);
    }
    .mini-cart-item img:hover {
        transform: scale(1.08);
    }
    .mini-cart-item-info {
        flex: 1;
    }
    .mini-cart-item-info h6 {
        font-size: 0.95rem;
        margin: 0 0 0.4rem 0;
        font-weight: 600;
        color: var(--text-color);
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color var(--transition);
    }
    .mini-cart-item:hover .mini-cart-item-info h6 {
        color: var(--primary-color);
    }
    .mini-cart-item-info .quantity {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 0.3rem;
    }
    .mini-cart-item-info .price {
        font-size: 0.95rem;
        color: var(--primary-color);
        font-weight: 600;
    }
    .mini-cart-item .btn-close {
        opacity: 0.6;
        transition: var(--transition);
        margin-top: 0.4rem;
        filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.15));
    }
    .mini-cart-item .btn-close:hover {
        opacity: 1;
        transform: scale(1.2) rotate(90deg);
        color: #dc3545;
    }
    .mini-cart-subtotal {
        padding: 1rem 1.3rem;
        background-color: rgba(161, 58, 40, 0.05);
        font-weight: 600;
        font-size: 1rem;
        color: var(--text-color);
        border-top: 1px solid var(--border-color);
        text-align: right;
    }
    .mini-cart-footer {
        padding: 1rem 1.3rem;
        background-color: rgba(161, 58, 40, 0.03);
        border-bottom-left-radius: 14px;
        border-bottom-right-radius: 14px;
        display: flex;
        gap: 0.7rem;
        border-top: 1px dashed var(--border-color);
    }
    .mini-cart-footer .btn {
        flex: 1;
        font-size: 0.9rem;
        padding: 0.7rem 0.9rem;
        border-radius: 10px;
        font-weight: 600;
        transition: var(--transition);
        text-transform: uppercase;
        letter-spacing: 0.03rem;
    }
    .mini-cart-footer .btn-outline-primary {
        border-color: var(--primary-color);
        color: var(--primary-color);
        background: transparent;
    }
    .mini-cart-footer .btn-outline-primary:hover {
        background-color: var(--primary-color);
        color: #FFFFFF;
        transform: translateY(-3px);
        box-shadow: var(--shadow-sm);
    }
    .mini-cart-footer .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: #FFFFFF;
    }
    .mini-cart-footer .btn-primary:hover {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
        transform: translateY(-3px);
        box-shadow: var(--shadow-sm);
    }
    .mini-cart-empty {
        text-align: center;
        color: #888;
        font-size: 0.95rem;
        padding: 2.5rem 0;
        font-style: italic;
    }

    /* Custom Scrollbar */
    .mini-cart-content::-webkit-scrollbar {
        width: 8px;
    }
    .mini-cart-content::-webkit-scrollbar-track {
        background: #F8F8F8;
        border-radius: 10px;
    }
    .mini-cart-content::-webkit-scrollbar-thumb {
        background: linear-gradient(var(--primary-color), var(--secondary-color));
        border-radius: 10px;
    }
    .mini-cart-content::-webkit-scrollbar-thumb:hover {
        background: var(--secondary-color);
    }

    /* RTL Support */
    [dir="rtl"] .mini-cart-dropdown {
        right: auto;
        left: 0;
    }
    [dir="rtl"] .mini-cart-dropdown::before {
        right: auto;
        left: 22px;
    }
    [dir="rtl"] .mini-cart-item {
        flex-direction: row-reverse;
    }
    [dir="rtl"] .mini-cart-subtotal {
        text-align: left;
    }
    [dir="rtl"] .navbar-locale .dropdown-menu,
    [dir="rtl"] .navbar-avatar .dropdown-menu {
        right: auto;
        left: 0;
    }

    /* Accessibility */
    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        border: 0;
    }
</style>

<!-- Top Strip -->
<div class="top-strip py-2 px-3" role="complementary" aria-label="{{ __('navbar.top_strip') }}">
    <div class="container-fluid d-flex align-items-center justify-content-center justify-content-md-start">
        <span class="me-3 text-uppercase font-weight-bold">{{ __('navbar.authorized_distributor') }}</span>
        <img src="{{ asset('Logo_2.svg') }}" alt="{{ __('navbar.authorized_distributor_logo_alt') }}" height="32" loading="lazy" class="img-fluid" />
    </div>
</div>

<!-- Navbar -->
<nav class="NAVBAR navbar py-2 sticky-top" role="navigation" aria-label="{{ __('navbar.main_navigation') }}">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- Left: Toggler + Nav -->
        <div class="d-flex align-items-center order-1 order-lg-1">
            <!-- Mobile Toggler -->
            <button class="navbar-toggler custom-toggler me-2" type="button" aria-controls="navbarCollapse" aria-expanded="false" aria-label="{{ __('navbar.toggle_navigation') }}">
                <span class="toggler-icon top-bar"></span>
                <span class="toggler-icon middle-bar"></span>
                <span class="toggler-icon bottom-bar"></span>
            </button>

            <!-- Nav Links -->
            <div class="navbar-collapse custom-collapse" id="navbarCollapse">
                <ul class="navbar-nav d-flex flex-column flex-lg-row align-items-lg-center">
                    @foreach ([
                        ['route' => 'front.homepage', 'label' => __('navbar.home')],
                        ['route' => 'front.about', 'label' => __('navbar.about_us')],
                        ['route' => 'front.product', 'label' => __('navbar.products')],
                        ['route' => 'front.gallery', 'label' => __('navbar.gallery')],
                        ['route' => 'front.contact', 'label' => __('navbar.contact')]
                    ] as $navItem)
                        <li class="nav-item">
                            <a href="{{ route($navItem['route']) }}"
                               class="nav-link NAVBAR-link {{ Route::is($navItem['route']) ? 'active' : '' }}"
                               aria-current="{{ Route::is($navItem['route']) ? 'page' : 'false' }}">
                                {{ $navItem['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <!-- Mobile Socials, Locale, Avatar, Cart -->
                <div class="d-lg-none mt-3 px-3 w-100">
                    <!-- Social Icons -->
                    <div class="NAVBAR-social d-flex justify-content-center gap-3">
                        @foreach ([
                            ['href' => $globalsettings->facebook ?? '#', 'icon' => 'facebook', 'label' => __('navbar.social_facebook')],
                            ['href' => $globalsettings->instagram ?? '#', 'icon' => 'instagram', 'label' => __('navbar.social_instagram')],
                            ['href' => $globalsettings->youtube ?? '#', 'icon' => 'youtube', 'label' => __('navbar.social_youtube')]
                        ] as $social)
                            <a href="{{ $social['href'] }}"
                               aria-label="{{ $social['label'] }}"
                               class="social-link"
                               target="_blank"
                               rel="noopener noreferrer">
                                <i class="bi bi-{{ $social['icon'] }}"></i>
                                <span class="sr-only">{{ $social['label'] }}</span>
                            </a>
                        @endforeach
                    </div>

                    <!-- Locale Switcher (Mobile) -->
                    <div class="navbar-locale dropdown mt-3 w-100">
                        <a class="nav-link dropdown-toggle"
                           href="#"
                           id="navbarLocaleDropdownMobile"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false"
                           aria-label="{{ __('navbar.locale_switcher') }}"
                           onclick="toggleLocaleDropdown(event)">
                            <i class="bi bi-globe me-1"></i>
                            <span class="selected-locale">
                                {{ session('locale', 'en') === 'en' ? 'EN' : 'AR' }} | {{ session('currency', 'NIS') }}
                            </span>
                        </a>
                        <ul class="dropdown-menu w-100" aria-labelledby="navbarLocaleDropdownMobile">
                            <li class="dropdown-header">{{ __('navbar.language') }}</li>
                            @foreach (['en' => __('navbar.english'), 'ar' => __('navbar.arabic')] as $locale => $label)
                                <li>
                                    <a class="dropdown-item {{ session('locale') === $locale ? 'active' : '' }}"
                                       href="{{ route('change.language', $locale) }}">
                                        <span class="flag-icon"></span> {{ $label }}
                                    </a>
                                </li>
                            @endforeach
                            <li class="dropdown-header mt-2">{{ __('navbar.currency') }}</li>
                            @foreach (['NIS', 'JOD', 'USD', 'EUR', 'EGP'] as $currency)
                                <li>
                                    <a class="dropdown-item {{ session('currency') === $currency ? 'active' : '' }}"
                                       href="{{ route('change.currency', $currency) }}">
                                        <span class="flag-icon"></span> {{ $currency }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Avatar (Mobile) -->
                    <div class="navbar-avatar dropdown mt-3 w-100">
                        <a class="nav-link dropdown-toggle d-flex align-items-center justify-content-center"
                           href="#"
                           id="navbarAvatarDropdownMobile"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false"
                           aria-label="{{ __('navbar.account') }}"
                           onclick="toggleAvatarDropdown(event)">
                            @if (auth('client')->check() && auth('client')->user()->avatar)
                                <img src="{{ asset(auth('client')->user()->avatar) }}"
                                     alt="{{ auth('client')->user()->name }}"
                                     class="rounded-circle me-1"
                                     width="24"
                                     height="24"
                                     style="object-fit: cover;"
                                     loading="lazy">
                            @else
                                <i class="bi bi-person-circle me-1"></i>
                            @endif
                            <span class="selected-account">
                                {{-- {{ auth('client')->check() ? auth('client')->user()->name : __('navbar.account') }} --}}
                            </span>
                        </a>
                        <ul class="dropdown-menu w-100" aria-labelledby="navbarAvatarDropdownMobile">
                            @auth('client')
                                @foreach ([
                                    ['route' => 'client.dashboard', 'label' => __('navbar.dashboard'), 'icon' => 'speedometer2'],
                                    ['route' => 'client.profile.edit', 'label' => __('navbar.profile'), 'icon' => 'person']
                                ] as $item)
                                    <li>
                                        <a class="dropdown-item {{ Route::is($item['route']) ? 'active' : '' }}"
                                           href="{{ route($item['route']) }}">
                                            <i class="bi bi-{{ $item['icon'] }} me-2"></i> {{ $item['label'] }}
                                        </a>
                                    </li>
                                @endforeach
                                <li>
                                    <form action="{{ route('client.logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item w-100 text-start">
                                            <i class="bi bi-box-arrow-right me-2"></i> {{ __('navbar.logout') }}
                                        </button>
                                    </form>
                                </li>
                            @else
                                @foreach ([
                                    ['route' => 'client.login', 'label' => __('navbar.login'), 'icon' => 'box-arrow-in-right'],
                                    ['route' => 'client.register', 'label' => __('navbar.register'), 'icon' => 'person-plus']
                                ] as $item)
                                    <li>
                                        <a class="dropdown-item {{ Route::is($item['route']) ? 'active' : '' }}"
                                           href="{{ route($item['route']) }}">
                                            <i class="bi bi-{{ $item['icon'] }} me-2"></i> {{ $item['label'] }}
                                        </a>
                                    </li>
                                @endforeach
                            @endauth
                        </ul>
                    </div>

                    <!-- Cart Icon (Mobile) -->
                    <div class="nav-cart position-relative mt-3">
                        <a href="javascript:void(0);"
                           onclick="toggleMiniCart(event)"
                           aria-label="{{ __('navbar.open_cart') }}"
                           data-bs-toggle="tooltip"
                           data-bs-placement="{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}"
                           title="{{ __('navbar.cart') }}">
                            <i class="bi bi-cart"></i>
                            @if (isset($cartItemCount) && $cartItemCount > 0)
                                <span class="cart-badge">{{ $cartItemCount }}</span>
                            @endif
                        </a>
                        <div class="mini-cart-dropdown" id="miniCartDropdown">
                            <div class="mini-cart-header">{{ __('navbar.your_cart') }}</div>
                            <div class="mini-cart-content">
                                <p class="text-muted small mb-0">{{ __('navbar.loading_cart') }}</p>
                            </div>
                            <div class="mini-cart-subtotal text-end d-none"></div>
                            <div class="mini-cart-footer">
                                <a href="{{ route('cart.index') }}" class="btn btn-sm btn-outline-primary">{{ __('navbar.view_cart') }}</a>
                                <a href="{{ route('checkout.index') }}"  class="btn btn-sm btn-primary">{{ __('navbar.checkout') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Center: Logo -->
        <a class="navbar-brand mx-auto order-2 position-relative"
           href="{{ route('front.homepage') }}"
           aria-label="{{ __('navbar.homepage') }}">
            <img src="{{ asset('Logo.svg') }}"
                 alt="{{ __('navbar.brand_logo') }}"
                 class="img-fluid NAVBAR-logo fade-in"
                 loading="lazy" />
        </a>

        <!-- Right: Desktop Socials, Locale, Avatar, Cart -->
        <div class="d-none d-lg-flex align-items-center order-3">
            <!-- Social Icons -->
            <div class="NAVBAR-social">
                @foreach ([
                    ['href' => $settings->facebook ?? '#', 'icon' => 'facebook', 'label' => __('navbar.social_facebook')],
                    ['href' => $settings->instagram ?? '#', 'icon' => 'instagram', 'label' => __('navbar.social_instagram')],
                    ['href' => $settings->youtube ?? '#', 'icon' => 'youtube', 'label' => __('navbar.social_youtube')]
                ] as $social)
                    <a href="{{ $social['href'] }}"
                       aria-label="{{ $social['label'] }}"
                       class="social-link"
                       target="_blank"
                       rel="noopener noreferrer"
                       data-bs-toggle="tooltip"
                       data-bs-placement="{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}"
                       title="{{ $social['label'] }}">
                        <i class="bi bi-{{ $social['icon'] }}"></i>
                        <span class="sr-only">{{ $social['label'] }}</span>
                    </a>
                @endforeach
            </div>

            <!-- Locale Switcher (Desktop) -->
            <div class="navbar-locale dropdown ms-2">
                <a class="nav-link dropdown-toggle"
                   href="#"
                   id="navbarLocaleDropdown"
                   role="button"
                   data-bs-toggle="dropdown"
                   aria-expanded="false"
                   aria-label="{{ __('navbar.locale_switcher') }}">
                    <i class="bi bi-globe me-1"></i>
                    <span class="selected-locale">
                        {{ session('locale', 'en') === 'en' ? 'EN' : 'AR' }} | {{ session('currency', 'NIS') }}
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarLocaleDropdown">
                    <li class="dropdown-header">{{ __('navbar.language') }}</li>
                    @foreach (['en' => __('navbar.english'), 'ar' => __('navbar.arabic')] as $locale => $label)
                        <li>
                            <a class="dropdown-item {{ session('locale') === $locale ? 'active' : '' }}"
                               href="{{ route('change.language', $locale) }}">
                                <span class="flag-icon"></span> {{ $label }}
                            </a>
                        </li>
                    @endforeach
                    <li class="dropdown-header mt-2">{{ __('navbar.currency') }}</li>
                    @foreach (['NIS', 'JOD', 'USD', 'EUR', 'EGP'] as $currency)
                        <li>
                            <a class="dropdown-item {{ session('currency') === $currency ? 'active' : '' }}"
                               href="{{ route('change.currency', $currency) }}">
                                <span class="flag-icon"></span> {{ $currency }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Avatar (Desktop) -->
            <div class="navbar-avatar dropdown ms-2">
                <a class="nav-link dropdown-toggle d-flex align-items-center"
                   href="#"
                   id="navbarAvatarDropdown"
                   role="button"
                   data-bs-toggle="dropdown"
                   aria-expanded="false"
                   aria-label="{{ __('navbar.account') }}"
                   data-bs-toggle="tooltip"
                   data-bs-placement="{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}"
                   title="{{ auth('client')->check() ? auth('client')->user()->name : __('navbar.account') }}">
                    @if (auth('client')->check() && auth('client')->user()->avatar)
                       @if (auth('client')->check() && auth('client')->user()->avatar)
                        <img src="{{ asset('storage/' . auth('client')->user()->avatar) }}"
                            alt="{{ auth('client')->user()->name }}"
                            class="rounded-circle"
                            width="32"
                            height="32"
                            style="object-fit: cover;"
                            loading="lazy">
                    @else
                        <i class="bi bi-person-circle fs-4"></i>
                    @endif

                    @else
                        <i class="bi bi-person-circle fs-4"></i>
                    @endif
                    <span class="selected-account ms-2 d-none d-xl-inline">
                        {{-- {{ auth('client')->check() ? auth('client')->user()->name : __('navbar.account') }} --}}
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarAvatarDropdown">
                    @auth('client')
                        @foreach ([
                            ['route' => 'client.dashboard', 'label' => __('navbar.dashboard'), 'icon' => 'speedometer2'],
                            ['route' => 'client.profile.edit', 'label' => __('navbar.profile'), 'icon' => 'person']
                        ] as $item)
                            <li>
                                <a class="dropdown-item {{ Route::is($item['route']) ? 'active' : '' }}"
                                   href="{{ route($item['route']) }}">
                                    <i class="bi bi-{{ $item['icon'] }} me-2"></i> {{ $item['label'] }}
                                </a>
                            </li>
                        @endforeach
                        <li>
                            <form action="{{ route('client.logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item w-100 text-start">
                                    <i class="bi bi-box-arrow-right me-2"></i> {{ __('navbar.logout') }}
                                </button>
                            </form>
                        </li>
                    @else
                        @foreach ([
                            ['route' => 'client.login', 'label' => __('navbar.login'), 'icon' => 'box-arrow-in-right'],
                            ['route' => 'client.register', 'label' => __('navbar.register'), 'icon' => 'person-plus']
                        ] as $item)
                            <li>
                                <a class="dropdown-item {{ Route::is($item['route']) ? 'active' : '' }}"
                                   href="{{ route($item['route']) }}">
                                    <i class="bi bi-{{ $item['icon'] }} me-2"></i> {{ $item['label'] }}
                                </a>
                            </li>
                        @endforeach
                    @endauth
                </ul>
            </div>

            <!-- Cart (Desktop) -->
            <div class="nav-cart position-relative ms-3">
                <a href="javascript:void(0);"
                   aria-label="{{ __('navbar.open_cart') }}"
                   data-bs-toggle="tooltip"
                   data-bs-placement="{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}"
                   title="{{ __('navbar.cart') }}">
                    <i class="bi bi-cart"></i>
                    @if (isset($cartItemCount) && $cartItemCount > 0)
                        <span class="cart-badge">{{ $cartItemCount }}</span>
                    @endif
                </a>
                <div class="mini-cart-dropdown" id="miniCartDropdownDesktop">
                    <div class="mini-cart-header">{{ __('navbar.your_cart') }}</div>
                    <div class="mini-cart-content">
                        <p class="text-muted small mb-0">{{ __('navbar.loading_cart') }}</p>
                    </div>
                    <div class="mini-cart-subtotal text-end d-none"></div>
                    <div class="mini-cart-footer">
                        <a href="{{ route('cart.index') }}" class="btn btn-sm btn-outline-primary">{{ __('navbar.view_cart') }}</a>
                        <a href="{{ route('checkout.index') }}" class="btn btn-sm btn-primary">{{ __('navbar.checkout') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Custom JS -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Cached DOM selectors
    const selectors = {
        toggler: document.querySelector('.custom-toggler'),
        collapse: document.querySelector('.custom-collapse'),
        body: document.body,
        navbar: document.querySelector('.NAVBAR'),
        desktopCartWrapper: document.querySelector('.d-none.d-lg-flex .nav-cart'),
        mobileCartWrapper: document.querySelector('.d-lg-none .nav-cart'),
        miniCart: document.getElementById('miniCartDropdown'),
        miniCartDesktop: document.getElementById('miniCartDropdownDesktop'),
        desktopAvatarWrapper: document.querySelector('.d-none.d-lg-flex .navbar-avatar'),
        mobileAvatarWrapper: document.querySelector('.d-lg-none .navbar-avatar'),
        desktopLocaleWrapper: document.querySelector('.d-none.d-lg-flex .navbar-locale'),
        mobileLocaleWrapper: document.querySelector('.d-lg-none .navbar-locale'),
        tooltipElements: document.querySelectorAll('[data-bs-toggle="tooltip"]'),
        navLinks: document.querySelector('.navbar-nav'),
    };

    // State flags
    let state = {
        isToggling: false,
        isCartToggling: false,
        isAvatarToggling: false,
        isLocaleToggling: false,
    };

    // Debounce utility
    const debounce = (func, wait) => {
        let timeout;
        return (...args) => {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    };

    // Toggle mobile menu
    const toggleMobileMenu = (event) => {
        event.stopPropagation();
        if (state.isToggling) return;
        state.isToggling = true;
        selectors.toggler.classList.toggle('open');
        selectors.collapse.classList.toggle('show');
        selectors.body.classList.toggle('menu-open');
        closeAllDropdowns();
        setTimeout(() => { state.isToggling = false; }, 400);
    };

    // Close all dropdowns (mini-cart, avatar, locale)
    const closeAllDropdowns = () => {
        selectors.miniCart?.classList.remove('show');
        selectors.miniCartDesktop?.classList.remove('show');
        document.querySelectorAll('.navbar-avatar .dropdown-menu').forEach(menu => menu.classList.remove('show'));
        document.querySelectorAll('.navbar-locale .dropdown-menu').forEach(menu => menu.classList.remove('show'));
    };

    // Handle outside clicks with debouncing
    const handleOutsideClick = debounce((event) => {
        if (!selectors.toggler.contains(event.target) &&
            !selectors.collapse.contains(event.target) &&
            !event.target.closest('.NAVBAR-link') &&
            !event.target.closest('.navbar-locale') &&
            !event.target.closest('.navbar-avatar') &&
            !event.target.closest('.nav-cart')) {
            selectors.toggler.classList.remove('open');
            selectors.collapse.classList.remove('show');
            selectors.body.classList.remove('menu-open');
            closeAllDropdowns();
        }
    }, 100);

    // Prevent nav link clicks from closing the menu
    const handleNavLinkClick = (event) => {
        if (event.target.closest('.NAVBAR-link')) {
            event.stopPropagation();
        }
    };

    // Sticky shadow on scroll (debounced)
    const handleScroll = debounce(() => {
        if (window.scrollY > 10) {
            selectors.navbar?.classList.add('sticky-shadow');
        } else {
            selectors.navbar?.classList.remove('sticky-shadow');
        }
    }, 50);

    // Logo fade-in
    const initLogoFadeIn = () => {
        document.querySelectorAll('.NAVBAR-logo').forEach(logo => logo.classList.add('fade-in'));
    };

    // Initialize tooltips
    const initTooltips = () => {
        selectors.tooltipElements.forEach(el => new bootstrap.Tooltip(el, {
            trigger: 'hover focus',
            placement: document.documentElement.dir === 'rtl' ? 'left' : 'right',
        }));
    };

    // Animate cart badge
    const animateCartBadge = () => {
        document.querySelectorAll('.cart-badge').forEach(badge => {
            badge.classList.remove('bounceIn');
            void badge.offsetWidth; // Force reflow
            badge.classList.add('bounceIn');
        });
    };

    // Update cart badges
    const updateCartBadges = (count) => {
        const badges = document.querySelectorAll('.cart-badge');
        const prevCount = parseInt(badges[0]?.textContent || '0');
        badges.forEach(badge => {
            if (count > 0) {
                badge.textContent = count;
                badge.style.display = 'block';
                if (count !== prevCount) animateCartBadge();
            } else {
                badge.style.display = 'none';
            }
        });
    };

    // Load mini cart content with retry logic
    const loadMiniCartContent = async (miniCartEl, retries = 2) => {
        if (!miniCartEl || miniCartEl.dataset.loaded === 'true') return;

        const container = miniCartEl.querySelector('.mini-cart-content');
        const subtotalEl = miniCartEl.querySelector('.mini-cart-subtotal');
        container.innerHTML = '<p class="text-muted small mb-0 loading-spinner">Loading...</p>';
        subtotalEl?.classList.add('d-none');

        try {
            const response = await fetch('{{ route('cart.mini') }}', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            });

            if (!response.ok && retries > 0) {
                setTimeout(() => loadMiniCartContent(miniCartEl, retries - 1), 1000);
                return;
            }

            const data = await response.json();
            container.innerHTML = '';

            if (!data.items?.length) {
                container.innerHTML = '<p class="mini-cart-empty">{{ __('navbar.cart_empty') }}</p>';
            } else {
                data.items.forEach(item => {
                    const itemEl = document.createElement('div');
                    itemEl.className = 'mini-cart-item';
                    itemEl.innerHTML = `
                        <img src="${item.image}" alt="${item.name}" loading="lazy">
                        <div class="mini-cart-item-info">
                            <h6>${item.name}</h6>
                            <div class="quantity">Qty: ${item.qty}</div>
                            <div class="price">${item.line_total_formatted}</div>
                        </div>
                        <button type="button" class="btn-close btn-close-sm" aria-label="{{ __('navbar.remove_item') }}" data-item-id="${item.id}" data-mini-cart-id="${miniCartEl.id}"></button>
                    `;
                    container.appendChild(itemEl);
                });

                subtotalEl.textContent = `{{ __('navbar.subtotal') }}: ${data.subtotal}`;
                subtotalEl.classList.remove('d-none');
            }

            updateCartBadges(data.item_count);
            miniCartEl.dataset.loaded = 'true';
        } catch (err) {
            console.error('Mini cart fetch error:', err);
            container.innerHTML = '<p class="text-danger">{{ __('navbar.error_loading_cart') }}</p>';
        }
    };

    // Remove from cart with retry logic
    const removeFromCart = async (itemId, buttonEl, miniCartId, retries = 2) => {
        const csrfToken = '{{ csrf_token() }}';
        try {
            const response = await fetch(`{{ url('/cart/remove') }}/${itemId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ _method: 'DELETE' }),
            });

            if (!response.ok && retries > 0) {
                setTimeout(() => removeFromCart(itemId, buttonEl, miniCartId, retries - 1), 1000);
                return;
            }

            const data = await response.json();
            alert(data.message);
            buttonEl.closest('.mini-cart-item')?.remove();
            const miniCartEl = document.getElementById(miniCartId);
            if (miniCartEl) {
                miniCartEl.dataset.loaded = false;
                loadMiniCartContent(miniCartEl);
            }
            updateCartBadges(data.cart_count);
        } catch (err) {
            console.error('Remove cart item error:', err);
            alert('{{ __('navbar.error_removing_item') }}');
        }
    };

    // Handle desktop hover for mini cart
    const initDesktopCartHover = () => {
        if (!selectors.desktopCartWrapper) return;
        let hoverTimeout;
        selectors.desktopCartWrapper.addEventListener('mouseenter', () => {
            hoverTimeout = setTimeout(() => {
                selectors.miniCartDesktop.classList.add('show');
                loadMiniCartContent(selectors.miniCartDesktop);
            }, 200);
        });
        selectors.desktopCartWrapper.addEventListener('mouseleave', () => {
            clearTimeout(hoverTimeout);
            selectors.miniCartDesktop.classList.remove('show');
        });
    };

    // Handle desktop hover for avatar dropdown
    const initDesktopAvatarHover = () => {
        if (!selectors.desktopAvatarWrapper) return;
        let hoverTimeout;
        selectors.desktopAvatarWrapper.addEventListener('mouseenter', () => {
            hoverTimeout = setTimeout(() => {
                selectors.desktopAvatarWrapper.querySelector('.dropdown-menu').classList.add('show');
            }, 200);
        });
        selectors.desktopAvatarWrapper.addEventListener('mouseleave', () => {
            clearTimeout(hoverTimeout);
            selectors.desktopAvatarWrapper.querySelector('.dropdown-menu').classList.remove('show');
        });
    };

    // Handle desktop hover for locale dropdown
    const initDesktopLocaleHover = () => {
        if (!selectors.desktopLocaleWrapper) return;
        let hoverTimeout;
        selectors.desktopLocaleWrapper.addEventListener('mouseenter', () => {
            hoverTimeout = setTimeout(() => {
                selectors.desktopLocaleWrapper.querySelector('.dropdown-menu').classList.add('show');
            }, 200);
        });
        selectors.desktopLocaleWrapper.addEventListener('mouseleave', () => {
            clearTimeout(hoverTimeout);
            selectors.desktopLocaleWrapper.querySelector('.dropdown-menu').classList.remove('show');
        });
    };

    // Toggle mobile mini cart
    window.toggleMiniCart = (event) => {
        event.preventDefault();
        event.stopPropagation();
        if (state.isCartToggling) return;
        state.isCartToggling = true;
        selectors.miniCart?.classList.toggle('show');
        if (selectors.miniCart?.classList.contains('show')) {
            loadMiniCartContent(selectors.miniCart);
        }
        closeAllDropdowns();
        setTimeout(() => { state.isCartToggling = false; }, 400);
    };

    // Toggle mobile avatar dropdown
    window.toggleAvatarDropdown = (event) => {
        event.preventDefault();
        event.stopPropagation();
        if (state.isAvatarToggling) return;
        state.isAvatarToggling = true;
        const mobileAvatarDropdown = selectors.mobileAvatarWrapper?.querySelector('.dropdown-menu');
        mobileAvatarDropdown?.classList.toggle('show');
        closeAllDropdowns();
        setTimeout(() => { state.isAvatarToggling = false; }, 400);
    };

    // Toggle mobile locale dropdown
    window.toggleLocaleDropdown = (event) => {
        event.preventDefault();
        event.stopPropagation();
        if (state.isLocaleToggling) return;
        state.isLocaleToggling = true;
        const mobileLocaleDropdown = selectors.mobileLocaleWrapper?.querySelector('.dropdown-menu');
        mobileLocaleDropdown?.classList.toggle('show');
        closeAllDropdowns();
        setTimeout(() => { state.isLocaleToggling = false; }, 400);
    };

    // Keyboard navigation for accessibility
    const handleKeyboardNavigation = (event) => {
        if (event.key === 'Escape') {
            selectors.toggler.classList.remove('open');
            selectors.collapse.classList.remove('show');
            selectors.body.classList.remove('menu-open');
            closeAllDropdowns();
        }
        if (event.key === 'Enter' && event.target.closest('.nav-cart')) {
            window.toggleMiniCart(event);
        }
        if (event.key === 'Enter' && event.target.closest('.navbar-avatar .nav-link')) {
            window.toggleAvatarDropdown(event);
        }
        if (event.key === 'Enter' && event.target.closest('.navbar-locale .nav-link')) {
            window.toggleLocaleDropdown(event);
        }
    };

    // Touch support for mobile
    const handleTouchStart = (event) => {
        if (event.target.closest('.nav-cart')) {
            window.toggleMiniCart(event);
        } else if (event.target.closest('.navbar-avatar .nav-link')) {
            window.toggleAvatarDropdown(event);
        } else if (event.target.closest('.navbar-locale .nav-link')) {
            window.toggleLocaleDropdown(event);
        }
    };

    // Event delegation for remove buttons
    const handleRemoveButtonClick = (event) => {
        const button = event.target.closest('.btn-close');
        if (button) {
            const itemId = button.dataset.itemId;
            const miniCartId = button.dataset.miniCartId;
            if (itemId && miniCartId) {
                removeFromCart(itemId, button, miniCartId);
            }
        }
    };

    // Initialize event listeners
    const initEventListeners = () => {
        selectors.toggler?.addEventListener('click', toggleMobileMenu);
        document.addEventListener('click', handleOutsideClick);
        selectors.navLinks?.addEventListener('click', handleNavLinkClick);
        window.addEventListener('scroll', handleScroll);
        document.addEventListener('keydown', handleKeyboardNavigation);
        document.addEventListener('touchstart', handleTouchStart);
        selectors.miniCart?.addEventListener('click', handleRemoveButtonClick);
        selectors.miniCartDesktop?.addEventListener('click', handleRemoveButtonClick);
        initDesktopCartHover();
        initDesktopAvatarHover();
        initDesktopLocaleHover();
    };

    // Initialize
    const init = () => {
        initLogoFadeIn();
        initTooltips();
        initEventListeners();
        @if (isset($cartItemCount))
            updateCartBadges({{ $cartItemCount }});
        @endif
    };

    init();
});
</script>
