<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Front\FrontAboutController;
use App\Http\Controllers\Front\FrontContactController;
use App\Http\Controllers\Front\FrontHomepageController;
use App\Http\Controllers\Front\FrontProductController;
use App\Http\Controllers\Front\FrontGalleryController;
use App\Http\Controllers\Front\FrontCartController;
use App\Http\Controllers\Front\FrontCheckoutController;
use App\Http\Controllers\Front\FrontClientsLoginRegisterController;
use App\Http\Controllers\Front\FrontClientDashboardController;
use App\Http\Controllers\Front\CurrencyController;

use App\Http\Controllers\Admin\AdminHomepageController;
use App\Http\Controllers\Admin\AdminAboutController;
use App\Http\Controllers\Admin\AdminWhyUsSectionController;
use App\Http\Controllers\Admin\AdminProductCategoriesController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminProductSubcategoriesController;
use App\Http\Controllers\Admin\AdminHeroSectionsController;
use App\Http\Controllers\Admin\AdminWebsiteSettingController;
use App\Http\Controllers\Admin\AdminAboutSectionController;
use App\Http\Controllers\Admin\AdminGalleryController;
use App\Http\Controllers\Admin\AdminImagesController;
use App\Http\Controllers\Admin\AdminReportsController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminClientController;
use App\Http\Controllers\Admin\AdminShippingAreaController;


use App\Http\Middleware\SetLocale;

use Illuminate\Support\Facades\Route;

Route::middleware(['web', SetLocale::class])->group(function () {
    // Front Routes
    Route::get('/', [FrontHomepageController::class, 'index'])->name('front.homepage');
    Route::get('/about', [FrontAboutController::class, 'index'])->name('front.about');

    Route::get('why-us/{id}', [FrontAboutController::class, 'show'])
     ->name('whyus.show');

    Route::get('/product', [FrontProductController::class, 'index'])->name('front.product');
    Route::get('/gallery', [FrontGalleryController::class, 'index'])->name('front.gallery');
    Route::get('/contact', [FrontContactController::class, 'index'])->name('front.contact');
    Route::post('/cart/add', [FrontCartController::class, 'add'])->name('cart.add');
    Route::get('/cart/mini', [FrontCartController::class, 'mini'])->name('cart.mini');
    Route::patch('/cart/update/{cartItem}', [FrontCartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cartItem}', [FrontCartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart/view', [FrontCartController::class, 'index'])->name('cart.index');
    Route::get('/product/{id}', [FrontProductController::class, 'show'])->name('front.product-details');

    Route::resource('/checkout', FrontCheckoutController::class);
    Route::get('/confirmation', [FrontCheckoutController::class, 'confirmation'])->name('confirmation.index');

    Route::get('change-currency/{currency}', [App\Http\Controllers\Front\CurrencyController::class, 'change'])->name('change.currency');

    // Client Authentication Routes
    Route::prefix('client')->name('client.')->group(function () {
        // Guest-only routes (login and registration)
        Route::middleware('guest:client')->group(function () {
            Route::get('register', [FrontClientsLoginRegisterController::class, 'create'])->name('register');
            Route::post('register', [FrontClientsLoginRegisterController::class, 'store'])->name('register.store')->middleware('throttle:5,1');
            Route::get('login', [FrontClientsLoginRegisterController::class, 'showLoginForm'])->name('login');
            Route::post('login', [FrontClientsLoginRegisterController::class, 'login'])->name('login.store')->middleware('throttle:5,1');
        });

        // Authenticated client routes
        Route::middleware('auth:client')->group(function () {
            Route::post('logout', [FrontClientsLoginRegisterController::class, 'logout'])->name('logout');
            Route::get('dashboard', [FrontClientDashboardController::class, 'index'])->name('dashboard');
            Route::get('profile/edit', [FrontClientsLoginRegisterController::class, 'edit'])->name('profile.edit');
            Route::put('profile', [FrontClientsLoginRegisterController::class, 'update'])->name('profile.update');
        });
    });

    // Language Switching Route
    Route::get('lang/{locale}', function ($locale) {
        if (in_array($locale, ['en', 'ar'])) {
            session(['locale' => $locale]);
            app()->setLocale($locale);
        }
        return redirect()->back();
    })->name('change.language');

   // Dashboard Routes (for authenticated users, possibly clients)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'verified', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/home', [AdminHomepageController::class, 'index'])->name('admin_home');
        Route::resource('/about', AdminAboutController::class);
        Route::resource('/whyus', AdminWhyUsSectionController::class);
        Route::resource('/product_categories', AdminProductCategoriesController::class);
        Route::resource('/product_subcategories', AdminProductSubcategoriesController::class);
        Route::resource('/products', AdminProductController::class);
        Route::resource('/hero_section', AdminHeroSectionsController::class);
        Route::resource('setting', AdminWebsiteSettingController::class);
        Route::resource('about-sections', AdminAboutSectionController::class);
        Route::resource('gallery', AdminGalleryController::class);
        Route::resource('images', AdminImagesController::class);
        Route::resource('reports', AdminReportsController::class);
        Route::resource('orders', AdminOrderController::class);
        Route::resource('clients', AdminClientController::class);
        Route::resource('shipping-areas', controller: AdminShippingAreaController::class);
      Route::post('orders/hesabate-sent', [AdminOrderController::class, 'markHesabateSent'])
            ->name('orders.hesabate.sent');

        // ✅ Pending count route
Route::get('/admin/orders/pending-count', [AdminOrderController::class, 'pendingCount'])->name('admin.orders.pending-count');
    Route::get('/admin/orders/pending', [AdminOrderController::class, 'pendingOrders'])->name('admin.orders.pending');
        // ✅ Reports export routes
        Route::get('/reports/sales-by-area/pdf/{limit?}', [AdminReportsController::class, 'exportSalesByAreaPdf'])
            ->name('reports.sales_by_area.pdf');
        Route::get('/reports/sales-by-product/pdf/{limit?}', [AdminReportsController::class, 'exportSalesByProductPdf'])
            ->name('reports.sales_by_product.pdf');
        Route::get('/reports/payers-by-client/pdf/{limit?}', [AdminReportsController::class, 'exportPayersByClientPdf'])
            ->name('reports.payers_by_client.pdf');
        Route::get('/reports/payers-by-gender/pdf', [AdminReportsController::class, 'exportPayersByGenderPdf'])
            ->name('reports.payers_by_gender.pdf');
        Route::get('/reports/sales-by-category/pdf/{limit?}', [AdminReportsController::class, 'exportSalesByCategoryPdf'])
            ->name('reports.sales_by_category.pdf');

        Route::get('/reports/sales-by-area/excel/{limit?}', [AdminReportsController::class, 'exportSalesByAreaExcel'])
            ->name('reports.sales_by_area.excel');
        Route::get('/reports/sales-by-product/excel/{limit?}', [AdminReportsController::class, 'exportSalesByProductExcel'])
            ->name('reports.sales_by_product.excel');
        Route::get('/reports/payers-by-client/excel/{limit?}', [AdminReportsController::class, 'exportPayersByClientExcel'])
            ->name('reports.payers_by_client.excel');
        Route::get('/reports/payers-by-gender/excel', [AdminReportsController::class, 'exportPayersByGenderExcel'])
            ->name('reports.payers_by_gender.excel');
        Route::get('/reports/sales-by-category/excel/{limit?}', [AdminReportsController::class, 'exportSalesByCategoryExcel'])
            ->name('reports.sales_by_category.excel');


    // Route::resource('products', AdminProductController::class);

        // This must be INSIDE the group!
        Route::post('/products/import', [AdminProductController::class, 'import'])
            ->name('products.import');
    });

// ✅ Include default auth routes
require __DIR__ . '/auth.php';
});