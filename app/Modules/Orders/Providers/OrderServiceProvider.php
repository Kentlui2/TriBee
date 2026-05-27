<?php

declare(strict_types=1);

namespace App\Modules\Orders\Providers;

use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // This tells Laravel to load your routes file
        $this->loadRoutesFrom(__DIR__ . '/../routes.php');
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        // This is where you register your Services so they can be 
        // used via Dependency Injection in your Controllers.
        $this->app->singleton(\App\Modules\Orders\Services\OrderService::class, function ($app) {
            return new \App\Modules\Orders\Services\OrderService();
        });

        $this->app->singleton(\App\Modules\Orders\Services\CheckoutService::class, function ($app) {
            return new \App\Modules\Orders\Services\CheckoutService();
        });
    }
}