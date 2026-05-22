<?php

declare(strict_types=1);

namespace App\Modules\Cart;

use App\Modules\Cart\Services\CartService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        // Share cart count with all views
        View::composer('*', function ($view) {
            if (auth()->check()) {
                try {
                    $cartService = app(CartService::class);
                    $view->with('cartItemCount', $cartService->getCartItemCount(auth()->id()));
                } catch (\Exception $e) {
                    $view->with('cartItemCount', 0);
                }
            }
        });
    }
}