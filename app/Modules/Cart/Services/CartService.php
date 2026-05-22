<?php

declare(strict_types=1);

namespace App\Modules\Cart\Services;

use App\Modules\Cart\Models\Cart;
use App\Modules\Cart\Models\CartItem;
use App\Modules\Products\Services\InventoryService;
use Illuminate\Support\Collection;

class CartService
{
    public function __construct(
        private readonly InventoryService $inventoryService,
        private readonly PricingEngine $pricingEngine
    ) {}

    public function getOrCreateCart(int $userId): Cart
    {
        return Cart::firstOrCreate(['user_id' => $userId]);
    }

   public function addItem(int $userId, $productId, $quantity): CartItem
{
    $productId = (int) $productId;
    $quantity = (int) $quantity;
        if (!$this->inventoryService->checkStock($productId, $quantity)) {
            throw new \Exception('Insufficient stock');
        }

        $cart = $this->getOrCreateCart($userId);
        $existingItem = $cart->items()->where('product_id', $productId)->first();

        if ($existingItem) {
            $newQty = $existingItem->quantity + $quantity;
            if (!$this->inventoryService->checkStock($productId, $newQty)) {
                throw new \Exception('Insufficient stock');
            }
            $existingItem->update(['quantity' => $newQty]);
            return $existingItem->fresh();
        }

        return $cart->items()->create([
            'product_id' => $productId,
            'quantity' => $quantity,
        ]);
    }

    public function updateItemQuantity(int $userId, int $cartItemId, $quantity): CartItem
{
    $quantity = (int) $quantity;
    $cart = $this->getOrCreateCart($userId);
    $cartItem = $cart->items()->findOrFail($cartItemId);

    if ($quantity <= 0) {
        $this->removeItem($userId, $cartItemId);
        return $cartItem;
    }

    // Check stock - don't allow exceeding available stock
    if (!$this->inventoryService->checkStock($cartItem->product_id, $quantity)) {
        throw new \Exception('Cannot exceed available stock');
    }

    $cartItem->update(['quantity' => $quantity]);
    return $cartItem->fresh();
}

    public function removeItem(int $userId, int $cartItemId): void
    {
        $cart = $this->getOrCreateCart($userId);
        $cart->items()->where('id', $cartItemId)->delete();
    }

    public function getCartItems(int $userId): Collection
    {
        $cart = $this->getOrCreateCart($userId);

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
        $subtotal = $this->getCartItems($userId)->sum('subtotal');
        return $this->pricingEngine->calculateTotal($subtotal);
    }

    public function getCartItemCount(int $userId): int
{
    $cart = $this->getOrCreateCart($userId);
    return (int) $cart->items()->sum('quantity');
}

    public function clearCart(int $userId): void
    {
        $cart = $this->getOrCreateCart($userId);
        $cart->items()->delete();
    }
}