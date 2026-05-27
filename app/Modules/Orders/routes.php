<?php

use App\Modules\Orders\Controllers\CheckoutController;
use App\Modules\Orders\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// ─── Customer Routes ───────────────────────────
Route::middleware(['auth'])->group(function () {
    
    // Checkout wizard
    Route::get('/checkout/shipping', [CheckoutController::class, 'shipping'])
         ->name('checkout.shipping');
    
    Route::post('/checkout/review', [CheckoutController::class, 'review'])
         ->name('checkout.review');
    
    Route::post('/checkout/confirm', [CheckoutController::class, 'confirm'])
         ->name('checkout.confirm');
    
    // Order history
    Route::get('/orders', [OrderController::class, 'index'])
         ->name('orders.index');
    
    // Order receipt
    Route::get('/orders/{order}/receipt', [OrderController::class, 'show'])
         ->name('orders.receipt');
});

// ─── Admin Routes ──────────────────────────────
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    
    // All orders dashboard
    Route::get('/orders', [OrderController::class, 'adminIndex'])
         ->name('orders.index');
    
    // Update order status
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])
         ->name('orders.update-status');
    
    // View any order
    Route::get('/orders/{order}', [OrderController::class, 'show'])
         ->name('orders.show');
});