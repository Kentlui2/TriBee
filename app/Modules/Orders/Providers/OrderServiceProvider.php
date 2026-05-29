<?php

declare(strict_types=1);

namespace App\Modules\Orders\Providers;

use App\Modules\Cart\Services\CartService;
use App\Modules\Cart\Services\PricingEngine;
use App\Modules\Orders\Services\OrderService;
use App\Modules\Products\Services\InventoryService;
use App\Modules\Products\Services\ProductService;
use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    public function boot(): void
    {

    }

    public function register(): void
    {
        $this->app->singleton(OrderService::class, function ($app) {
            return new OrderService(
                $app->make(CartService::class),
                $app->make(InventoryService::class),
                $app->make(ProductService::class),
                $app->make(PricingEngine::class),
            );
        });
    }
}