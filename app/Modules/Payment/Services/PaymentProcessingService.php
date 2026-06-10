<?php

declare(strict_types=1);

namespace App\Modules\Payment\Services;

use Illuminate\Support\Facades\DB;

class PaymentProcessingService
{
    protected WalletService $walletService;
    protected PaymentService $paymentService;

    public function __construct(
        WalletService $walletService,
        PaymentService $paymentService
    ) {
        $this->walletService = $walletService;
        $this->paymentService = $paymentService;
    }

    public function processWalletPayment(int $userId, int $orderId, float $amount): array
    {
        $balance = $this->walletService->getBalance($userId);
        
        if ($balance < $amount) {
            return [
                'success' => false,
                'message' => 'Insufficient funds',
                'balance' => $balance,
                'short_by' => $amount - $balance
            ];
        }
        
        return DB::transaction(function () use ($userId, $orderId, $amount) {
            $withdrawn = $this->walletService->withdraw($userId, $amount, $orderId, "Payment for Order #{$orderId}");
            
            if (!$withdrawn) {
                return [
                    'success' => false,
                    'message' => 'Payment processing failed'
                ];
            }
            
            $this->paymentService->createPayment($orderId, 'wallet', $amount);
            $this->paymentService->updatePaymentStatus($orderId, 'paid', 'WALLET-' . uniqid());
            
            return [
                'success' => true,
                'message' => 'Payment successful',
                'new_balance' => $this->walletService->getBalance($userId)
            ];
        });
    }
}