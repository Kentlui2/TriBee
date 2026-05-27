<?php

declare(strict_types=1);

namespace App\Modules\Orders\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Orders\Services\OrderService;
use App\Modules\Cart\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function __construct(
        private OrderService $orderService,
        private CartService $cartService
    ) {
        $this->middleware('auth');
    }

    /**
     * STEP 1: Shipping form
     */
    public function shipping()
    {
        $cartItems = $this->cartService->getCartItems(Auth::id());
        $cartTotal = $this->cartService->getCartTotal(Auth::id());
        
        return view('orders.checkout.shipping', compact('cartItems', 'cartTotal'));
    }

    /**
     * STEP 2: Review order before confirming
     */
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

        // Store checkout data in session for the final step
        session(['checkout_data' => $request->only(['shipping_address', 'contact_number', 'notes'])]);

        return view('orders.checkout.review', compact(
            'cartItems', 'cartTotal', 'tax', 'shippingFee', 'grandTotal'
        ));
    }

    /**
     * STEP 3: Place the order (final confirmation)
     */
    public function confirm()
    {
        $checkoutData = session('checkout_data');
        
        if (!$checkoutData) {
            return redirect()->route('checkout.shipping')
                           ->with('error', 'Please complete the shipping details first.');
        }

        try {
            $order = $this->orderService->placeOrder(Auth::id(), $checkoutData);
            
            // Clear checkout session
            session()->forget('checkout_data');
            
            // Redirect to order receipt
            return redirect()->route('orders.receipt', $order->id)
                           ->with('success', 'Order placed successfully!');
                           
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}