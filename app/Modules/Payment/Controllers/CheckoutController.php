<?php

namespace App\Modules\Payment\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Payment\Models\Order; // Adjust namespace as needed
use App\Modules\Payment\Services\WalletService;
use App\Modules\Payment\Services\TransactionService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    protected $walletService;
    protected $transactionService;

    public function __construct(WalletService $walletService, TransactionService $transactionService)
    {
        $this->walletService = $walletService;
        $this->transactionService = $transactionService;
    }

    /**
     * Show payment page for checkout
     */
    public function showPayment($orderId)
    {
        // Get order details (adjust based on your Order model)
        $order = Order::findOrFail($orderId);
        
        // Get user's wallet balance
        $wallet = $this->walletService->getUserWallet(auth()->id());
        
        return view('payment.checkout.wallet-payment', compact('order', 'wallet'));
    }

    /**
     * Process wallet payment
     */
    public function processWalletPayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'pin' => 'required|string|size:6',
            'otp' => 'required|string|size:6'
        ]);

        // Verify PIN
        $pinValid = $this->walletService->verifyPin(auth()->id(), $request->pin);
        
        if (!$pinValid) {
            return response()->json(['error' => 'Invalid PIN'], 422);
        }

        // Verify OTP (implement your OTP logic)
        $otpValid = $this->verifyOtp($request->otp);
        
        if (!$otpValid) {
            return response()->json(['error' => 'Invalid OTP'], 422);
        }

        // Process payment
        $result = $this->walletService->deductBalance(
            auth()->id(),
            $request->amount,
            $request->order_id
        );

        if ($result['success']) {
            return response()->json(['success' => true, 'message' => 'Payment successful']);
        }

        return response()->json(['error' => $result['message']], 422);
    }

    private function verifyOtp($otp)
    {
        // Implement OTP verification logic
        // Could be from session, cache, or database
        return session('payment_otp') === $otp;
    }
}