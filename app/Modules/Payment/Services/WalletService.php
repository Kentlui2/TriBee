<?php

declare(strict_types=1);

namespace App\Modules\Payment\Services;

use App\Modules\Payment\Models\Wallet;
use Illuminate\Support\Facades\DB;

class WalletService
{
    protected TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function getOrCreateWallet(int $userId): Wallet
    {
        return Wallet::firstOrCreate(
            ['user_id' => $userId],
            ['balance' => 0]
        );
    }

    public function getBalance(int $userId): float
    {
        $wallet = $this->getOrCreateWallet($userId);
        return (float) $wallet->balance;
    }

    public function deposit(int $userId, float $amount, string $description = null): Wallet
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Amount must be greater than 0');
        }

        return DB::transaction(function () use ($userId, $amount, $description) {
            $wallet = $this->getOrCreateWallet($userId);
            
            $balanceBefore = (float) $wallet->balance;
            $balanceAfter = $balanceBefore + $amount;
            
            $wallet->balance = $balanceAfter;
            $wallet->save();
            
            $this->transactionService->record(
                $userId,
                'deposit',
                $amount,
                $balanceBefore,
                $balanceAfter,
                $description ?? 'Wallet top-up'
            );
            
            return $wallet;
        });
    }

    public function withdraw(int $userId, float $amount, ?int $orderId = null, string $description = null): bool
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Amount must be greater than 0');
        }

        return DB::transaction(function () use ($userId, $amount, $orderId, $description) {
            $wallet = $this->getOrCreateWallet($userId);
            
            $balanceBefore = (float) $wallet->balance;
            
            if ($balanceBefore < $amount) {
                return false;
            }
            
            $balanceAfter = $balanceBefore - $amount;
            
            $wallet->balance = $balanceAfter;
            $wallet->save();
            
            $this->transactionService->record(
                $userId,
                'purchase',
                $amount,
                $balanceBefore,
                $balanceAfter,
                $description ?? 'Purchase payment',
                $orderId
            );
            
            return true;
        });
    }

    public function linkCard(int $userId, string $cardLastFour, string $cardBrand, string $cardholderName): Wallet
    {
        $wallet = $this->getOrCreateWallet($userId);
        $wallet->card_last_four = $cardLastFour;
        $wallet->card_brand = $cardBrand;
        $wallet->cardholder_name = $cardholderName;
        $wallet->save();
        
        return $wallet;
    }
}