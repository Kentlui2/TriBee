<?php

declare(strict_types=1);

namespace App\Modules\Cart\Services;

use App\Modules\Products\Services\InventoryService;
use Illuminate\Support\Facades\Log;

class CartInventorySyncService
{
    public function __construct(
        private readonly InventoryService $inventoryService,
        private readonly CartService $cartService
    ) {}

    public function validateCartStock(int $userId): array
    {
        $cartItems = $this->cartService->getCartItems($userId);
        $issues = [];

        foreach ($cartItems as $item) {
            $hasStock = $this->inventoryService->checkStock($item['product_id'], $item['quantity']);

            if (!$hasStock) {
                $this->cartService->removeItem($userId, $item['cart_item_id']);
                $issues[] = "{$item['product_name']} is out of stock and removed from cart.";
            }
        }

        return ['valid' => empty($issues), 'issues' => $issues];
    }

    public function decrementStock(int $userId): void
    {
        $cartItems = $this->cartService->getCartItems($userId);

        foreach ($cartItems as $item) {
            $this->inventoryService->decrementStock($item['product_id'], $item['quantity']);
        }

        Log::info('Stock decremented for order', ['user_id' => $userId]);
    }
}