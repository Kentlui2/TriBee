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
    
    // Point these to your new AdminOrderController
    Route::get('/orders', [\App\Modules\Orders\Controllers\AdminOrderController::class, 'index'])
         ->name('orders.index');
    
    Route::patch('/orders/{order}/status', [\App\Modules\Orders\Controllers\AdminOrderController::class, 'update'])
         ->name('orders.update-status');
    
    // Optional: Keep show if you need to view individual order details in admin
    Route::get('/orders/{order}', [\App\Modules\Orders\Controllers\AdminOrderController::class, 'show'])
         ->name('orders.show');
    
});
