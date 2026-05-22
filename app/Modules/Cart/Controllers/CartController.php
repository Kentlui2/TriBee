<?php

declare(strict_types=1);

namespace App\Modules\Cart\Controllers;

use App\Modules\Cart\Services\CartService;
use App\Modules\Cart\Services\CartInventorySyncService;
use App\Modules\Cart\Services\PricingEngine;
use App\Modules\Cart\Services\PromoCodeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        private readonly CartService $cartService,
        private readonly PricingEngine $pricingEngine,
        private readonly CartInventorySyncService $syncService,
    ) {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $userId = auth()->id();
        $this->syncService->validateCartStock($userId);

        $cartItems = $this->cartService->getCartItems($userId);
        $subtotal = $cartItems->sum('subtotal');
        $pricingBreakdown = $this->pricingEngine->getBreakdown($subtotal);

        return view('cart.index', [
            'cartItems'        => $cartItems,
            'pricingBreakdown' => $pricingBreakdown,
            'cartItemCount'    => $this->cartService->getCartItemCount($userId),
            'subtotal'         => $subtotal,
        ]);
    }

    public function addToCart(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity'   => 'required|integer|min:1|max:99',
        ]);

        try {
            $this->cartService->addItem(auth()->id(), $request->product_id, $request->quantity);
            return redirect()->back()->with('success', 'Added to cart!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateQuantity(Request $request, int $cartItemId): RedirectResponse
    {
        $request->validate(['quantity' => 'required|integer|min:1|max:99']);

        try {
            $this->cartService->updateItemQuantity(auth()->id(), $cartItemId, $request->quantity);
            return redirect()->route('cart.index')->with('success', 'Cart updated!');
        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }
    }

    public function removeItem(int $cartItemId): RedirectResponse
    {
        $this->cartService->removeItem(auth()->id(), $cartItemId);
        return redirect()->route('cart.index')->with('success', 'Item removed.');
    }

    public function applyPromo(Request $request, PromoCodeService $promoService): JsonResponse
    {
        $request->validate(['code' => 'required|string|max:50']);

        $result = $promoService->canApply(
            $request->code,
            auth()->id(),
            $this->cartService->getCartTotal(auth()->id())
        );

        return response()->json($result);
    }
}