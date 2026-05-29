<?php

declare(strict_types=1);

namespace App\Modules\Orders\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Cart\Services\CartService;
use App\Modules\Orders\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function __construct(
        private OrderService $orderService,
        private CartService $cartService
    ) {
        // ✅ REMOVED $this->middleware('auth') — Laravel 11 doesn't support this
        // Auth is already handled in routes.php via Route::middleware(['auth'])
    }

    public function shipping()
    {
        $cartItems = $this->cartService->getCartItems(Auth::id());
        $cartTotal = $this->cartService->getCartTotal(Auth::id());

        return view('orders.checkout.shipping', compact('cartItems', 'cartTotal'));
    }

    public function review(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|min:10',
            'contact_number'   => 'required|string|min:7',
        ]);

        $cartItems = $this->cartService->getCartItems(Auth::id());
        $cartTotal = $this->cartService->getCartTotal(Auth::id());
        $tax = $cartTotal * 0.12;
        $shippingFee = 150.00;
        $grandTotal = $cartTotal + $tax + $shippingFee;

        session(['checkout_data' => $request->only([
            'shipping_address', 'contact_number', 'notes'
        ])]);

        return view('orders.checkout.review', compact(
            'cartItems', 'cartTotal', 'tax', 'shippingFee', 'grandTotal'
        ));
    }

    public function confirm()
    {
        $checkoutData = session('checkout_data');

        if (!$checkoutData) {
            return redirect()->route('checkout.shipping')
                ->with('error', 'Please complete the shipping details first.');
        }

        try {
            $order = $this->orderService->placeOrder(Auth::id(), $checkoutData);
            session()->forget('checkout_data');

            return redirect()->route('orders.receipt', $order->id)
                ->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}