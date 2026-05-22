<?php

declare(strict_types=1);

namespace App\Modules\Cart\Services;

use App\Modules\Cart\Models\Cart;
use App\Modules\Cart\Models\CartItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartPersistenceService
{
    private string $sessionKey = 'guest_cart';

    // ─────────────────────────────────────────
    // GUEST CART — stored in session
    // ─────────────────────────────────────────

    public function getGuestCart(): array
    {
        return session()->get($this->sessionKey, []);
    }

    public function saveGuestCart(int $productId, int $quantity): void
    {
        $cart = $this->getGuestCart();

        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }

        session()->put($this->sessionKey, $cart);
    }

    public function removeGuestCartItem(int $productId): void
    {
        $cart = $this->getGuestCart();
        unset($cart[$productId]);
        session()->put($this->sessionKey, $cart);
    }

    public function clearGuestCart(): void
    {
        session()->forget($this->sessionKey);
    }

    // ─────────────────────────────────────────
    // USER CART — stored in database
    // ─────────────────────────────────────────

    public function getOrCreateUserCart(int $userId): Cart
    {
        return Cart::firstOrCreate(['user_id' => $userId]);
    }

    public function saveUserCartItem(int $userId, int $productId, int $quantity): CartItem
    {
        $cart = $this->getOrCreateUserCart($userId);
        $item = $cart->items()->where('product_id', $productId)->first();

        if ($item) {
            $item->quantity += $quantity;
            $item->update(['quantity' => $item->quantity]);
            return $item;
        }

        return $cart->items()->create([
            'product_id' => $productId,
            'quantity'   => $quantity,
        ]);
    }

    public function removeUserCartItem(int $userId, int $productId): void
    {
        $cart = $this->getOrCreateUserCart($userId);
        $cart->items()->where('product_id', $productId)->delete();
    }

    // ─────────────────────────────────────────
    // CART MIGRATION — session → database on login
    // ─────────────────────────────────────────

    public function migrateGuestCartToUser(int $userId): void
    {
        $guestCart = $this->getGuestCart();

        if (empty($guestCart)) {
            return;
        }

        foreach ($guestCart as $productId => $quantity) {
            $this->saveUserCartItem($userId, (int) $productId, (int) $quantity);
        }

        $this->clearGuestCart();

        Log::info('Guest cart migrated to user', ['user_id' => $userId]);
    }

    // ─────────────────────────────────────────
    // CART MERGING — combine guest + existing user cart
    // ─────────────────────────────────────────

    public function mergeGuestWithUserCart(int $userId): void
    {
        $guestCart = $this->getGuestCart();

        if (empty($guestCart)) {
            return;
        }

        $cart = $this->getOrCreateUserCart($userId);

        foreach ($guestCart as $productId => $quantity) {
            $existing = $cart->items()->where('product_id', $productId)->first();

            if ($existing) {
                $existing->quantity += (int) $quantity;
                $existing->update(['quantity' => $existing->quantity]);
            } else {
                $cart->items()->create([
                    'product_id' => (int) $productId,
                    'quantity'   => (int) $quantity,
                ]);
            }
        }

        $this->clearGuestCart();
    }

    // ─────────────────────────────────────────
    // ABANDONED CART CLEANUP
    // ─────────────────────────────────────────

    public function cleanAbandonedCarts(): void
    {
        $cutoff = now()->subHours(24);

        $abandonedCarts = Cart::where('updated_at', '<', $cutoff)->get();

        foreach ($abandonedCarts as $cart) {
            $cart->items()->delete();
            $cart->delete();
        }
    }

    // ─────────────────────────────────────────
    // REQUIRED BY G4 — API Contracts
    // ─────────────────────────────────────────

    public function getCartItems(int $userId): Collection
    {
        $cart = $this->getOrCreateUserCart($userId);
        
        return $cart->items()->with('product')->get()->map(function ($item) {
            return [
                'cart_item_id' => $item->id,
                'product_id'   => $item->product_id,
                'product_name' => $item->product->name ?? 'Product',
                'quantity'     => $item->quantity,
                'unit_price'   => $item->product->price ?? 0,
                'subtotal'     => ($item->product->price ?? 0) * $item->quantity,
            ];
        });
    }

    public function getCartTotal(int $userId): float
    {
        return $this->getCartItems($userId)->sum('subtotal');
    }

    public function clearCart(int $userId): void
    {
        $cart = $this->getOrCreateUserCart($userId);
        $cart->items()->delete();
    }
}