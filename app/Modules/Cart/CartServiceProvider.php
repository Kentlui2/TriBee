<?php

declare(strict_types=1);

namespace App\Modules\Cart;

use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/Views', 'cart');
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
    }
}