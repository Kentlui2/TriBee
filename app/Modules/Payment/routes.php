Route::middleware(['auth'])->prefix('checkout')->group(function () {
    Route::get('/payment/{orderId}', [CheckoutController::class, 'showPayment'])->name('checkout.payment');
    Route::post('/process-wallet', [CheckoutController::class, 'processWalletPayment'])->name('checkout.process-wallet');
});