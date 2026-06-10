<?php

declare(strict_types=1);

namespace App\Modules\Payment\Services;

use App\Modules\Payment\Models\Payment;

class PaymentService
{
    public function getPaymentStatus(int $orderId): ?string
    {
        $payment = Payment::where('order_id', $orderId)->first();
        return $payment?->status;
    }

    public function getPayment(int $orderId): ?Payment
    {
        return Payment::where('order_id', $orderId)->first();
    }

    public function createPayment(int $orderId, string $method, float $amount): Payment
    {
        return Payment::create([
            'order_id' => $orderId,
            'method' => $method,
            'amount' => $amount,
            'status' => 'pending',
        ]);
    }

    public function updatePaymentStatus(int $orderId, string $status, ?string $referenceNo = null): bool
    {
        $payment = Payment::where('order_id', $orderId)->first();
        
        if (!$payment) {
            return false;
        }
        
        $payment->update([
            'status' => $status,
            'reference_no' => $referenceNo ?? $payment->reference_no,
        ]);
        
        return true;
    }

    public function isPaid(int $orderId): bool
    {
        $payment = Payment::where('order_id', $orderId)->first();
        return $payment?->status === 'paid';
    }
}