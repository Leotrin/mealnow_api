<?php

namespace App\Providers;

use App\Models\Shop;
use Illuminate\Support\ServiceProvider;
use  Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('frontend.home.search', function ($view){
            $cities  = Shop::distinct()->get(['search_city']);
            $view->with('cities', $cities);

        });
        view()->composer('frontend.form.search', function ($view){
            $cities  = Shop::distinct()->get(['search_city']);
            $view->with('cities', $cities);

        });
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
