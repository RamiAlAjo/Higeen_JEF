<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\ViewComposers\CartComposer;
use Illuminate\Support\Facades\View;
use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\Schema;
use App\Services\CurrencyService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(CurrencyService::class, function ($app) {
            return new CurrencyService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        App::setLocale(Session::get('locale', config('app.locale')));

        View::composer('*', CartComposer::class);

        if (Schema::hasTable('website_settings')) {
            $globalsettings = WebsiteSetting::first();
            View::share('globalsettings', $globalsettings);
        }

        View::composer(['front.layouts.navbar', 'front.layouts.footer'], function ($view) {
            $data = WebsiteSetting::first();
            $view->with('settings', $data);
        });

        Paginator::useBootstrapFive();
    }
}
