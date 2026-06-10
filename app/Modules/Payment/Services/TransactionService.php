<?php

declare(strict_types=1);

namespace App\Modules\Payment\Services;

use App\Modules\Payment\Models\Transaction;
use Illuminate\Support\Str;

class TransactionService
{
    /**
     * Record a transaction (IMMUTABLE - never delete or update)
     */
  public function record(
    int $userId,
    string $type,
    float $amount,
    float $balanceBefore,
    float $balanceAfter,
    ?string $description = null,
    ?int $orderId = null
): Transaction {
        return Transaction::create([
            'user_id' => $userId,
            'order_id' => $orderId,
            'type' => $type,
            'amount' => $amount,
            'balance_before' => $balanceBefore,
            'balance_after' => $balanceAfter,
            'reference_no' => $this->generateReferenceNo(),
            'description' => $description,
        ]);
    }

    private function generateReferenceNo(): string
    {
        return 'TXN-' . date('Ymd') . '-' . Str::upper(Str::random(8));
    }

    public function getUserTransactions(int $userId, int $limit = 50)
    {
        return Transaction::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getTotalDeposits(int $userId): float
    {
        return (float) Transaction::where('user_id', $userId)
            ->where('type', 'deposit')
            ->sum('amount');
    }

    public function getTotalPurchases(int $userId): float
    {
        return (float) Transaction::where('user_id', $userId)
            ->where('type', 'purchase')
            ->sum('amount');
    }

    public function validateBalanceNeverNegative(int $userId): bool
    {
        $transactions = Transaction::where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get();
        
        foreach ($transactions as $transaction) {
            if ($transaction->balance_after < 0) {
                return false;
            }
        }
        return true;
    }
}