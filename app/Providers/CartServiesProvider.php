<?php

namespace App\Providers;

use App\Repositores\CartRepository\CartRepositories;
use App\Repositores\CartRepository\CartModelRepository;

use Illuminate\Support\ServiceProvider;

class CartServiesProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CartRepositories::class, function () {
            return new CartModelRepository();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
