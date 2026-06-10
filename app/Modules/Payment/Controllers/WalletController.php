<?php

declare(strict_types=1);

namespace App\Modules\Payment\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Payment\Services\WalletService;
use App\Modules\Payment\Services\TransactionService;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    protected WalletService $walletService;
    protected TransactionService $transactionService;

    public function __construct(
        WalletService $walletService,
        TransactionService $transactionService
    ) {
        $this->walletService = $walletService;
        $this->transactionService = $transactionService;
    }

    public function dashboard()
    {
        $wallet = $this->walletService->getOrCreateWallet(auth()->id());
        $transactions = $this->transactionService->getUserTransactions(auth()->id(), 10);
        
        return view('payment.wallet.dashboard', compact('wallet', 'transactions'));
    }

    public function showLinkCard()
    {
        return view('payment.wallet.link-card');
    }

    public function linkCard(Request $request)
    {
        $validated = $request->validate([
            'cardholder_name' => 'required|string',
            'card_number' => 'required|string|size:16',
            'expiry_month' => 'required|string|size:2',
            'expiry_year' => 'required|string|size:4',
            'cvv' => 'required|string|size:3',
        ]);

        $cardLastFour = substr($validated['card_number'], -4);
        
        $this->walletService->linkCard(
            auth()->id(), 
            $cardLastFour, 
            'Card', 
            $validated['cardholder_name']
        );
        
        return redirect()->route('wallet.dashboard')->with('success', 'Card linked successfully!');
    }

    public function topUpForm()
    {
        return view('payment.wallet.topup');
    }

    public function topUp(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:100|max:10000',
        ]);

        $this->walletService->deposit(auth()->id(), $validated['amount'], 'Wallet top-up');
        
        return redirect()->route('wallet.dashboard')->with('success', 'Wallet topped up successfully!');
    }

    public function transactions()
    {
        $transactions = $this->transactionService->getUserTransactions(auth()->id(), 50);
        $totalDeposits = $this->transactionService->getTotalDeposits(auth()->id());
        $totalPurchases = $this->transactionService->getTotalPurchases(auth()->id());
        
        return view('payment.wallet.transactions', compact('transactions', 'totalDeposits', 'totalPurchases'));
    }
}