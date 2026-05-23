<?php

declare(strict_types=1);

use App\Modules\Cart\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::put('/cart/items/{cartItemId}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/items/{cartItemId}', [CartController::class, 'removeItem'])->name('cart.remove');
    Route::post('/cart/promo/apply', [CartController::class, 'applyPromo'])->name('cart.promo.apply');
});