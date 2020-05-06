<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class StripeProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Acme\Billing\BillingInterface','App\Acme\Billing\StripeBilling');
    }
}
