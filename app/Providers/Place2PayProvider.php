<?php

namespace App\Providers;

use Dnetix\Redirection\PlacetoPay;
use Illuminate\Support\ServiceProvider;

class Place2PayProvider extends ServiceProvider
{
    /**
     * Register services.
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PlacetoPay::class, function () {
            return new PlacetoPay([
                'login' => config('placetopay.login'),
                'tranKey' => config('placetopay.trankey'),
                'url' => config('placetopay.url'),
                'rest' => [
                    'timeout' => 45, // (optional) 15 by default
                    'connect_timeout' => 30, // (optional) 5 by default
                ]
            ]);
        });
    }

    /**
     * Bootstrap services.
     * @return void
     */
    public function boot()
    {
        //
    }
}
