<?php

declare(strict_types=1);

namespace App\Modules\Orders\Services;

use App\Modules\Orders\Models\Order;
use App\Modules\Orders\Models\OrderItem;
use App\Modules\Cart\Services\CartService;
use App\Modules\Cart\Services\PricingEngine;
use App\Modules\Products\Services\InventoryService;
use App\Modules\Products\Services\ProductService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class OrderService
{
    public function __construct(
        private CartService $cartService,
        private InventoryService $inventoryService,
        private ProductService $productService,
        private PricingEngine $pricingEngine,
    ) {}

    public function placeOrder(int $userId, array $checkoutData): Order
    {
        return DB::transaction(function () use ($userId, $checkoutData) {

            // 1. Get cart items
            $cartItems = $this->cartService->getCartItems($userId);

            if ($cartItems->isEmpty()) {
                throw new \Exception('Cart is empty');
            }

            // 2. Validate stock for every item before touching anything
            foreach ($cartItems as $item) {
                if (!$this->inventoryService->checkStock($item['product_id'], $item['quantity'])) {
                    throw new \Exception("Insufficient stock for: {$item['product_name']}");
                }
            }

            // 3. Get the full pricing breakdown (tax already computed inside PricingEngine)
            //    This gives us real snapshots instead of recomputing manually
            $rawSubtotal = $cartItems->sum('subtotal');
            $isLoyal     = $this->pricingEngine->isLoyalCustomer($userId);
            $breakdown   = $this->pricingEngine->getBreakdown($rawSubtotal, null, $isLoyal);

            $shippingFee = 150.00; // flat rate — G5 will replace this

            // 4. Create the order with accurate, non-doubled figures
            $order = Order::create([
                'user_id'          => $userId,
                'subtotal'         => $breakdown['subtotal'],
                'discount'         => $breakdown['discounts']['total'],
                'tax'              => $breakdown['tax']['amount'],
                'shipping_fee'     => $shippingFee,
                'total'            => $breakdown['total'] + $shippingFee,
                'status'           => 'pending',
                'shipping_address' => $checkoutData['shipping_address'] ?? null,
                'contact_number'   => $checkoutData['contact_number']   ?? null,
                'notes'            => $checkoutData['notes']             ?? null,
            ]);

            // 5. Snapshot each item at time-of-purchase price
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item['product_id'],
                    'product_name' => $item['product_name'], // snapshot from cart
                    'price'        => $item['unit_price'],   // snapshot from cart
                    'quantity'     => $item['quantity'],
                    'subtotal'     => $item['subtotal'],
                ]);

                // 6. Deduct stock
                $this->inventoryService->decrementStock($item['product_id'], $item['quantity']);
            }

            // 7. Clear cart
            $this->cartService->clearCart($userId);

            return $order;
        });
    }

    public function getOrderTotal(int $orderId): float
    {
        return Order::findOrFail($orderId)->total;
    }

    public function getOrder(int $orderId): Order
    {
        return Order::with('items')->findOrFail($orderId);
    }

    public function getUserOrders(int $userId): Collection
    {
        return Order::where('user_id', $userId)
                    ->orderBy('created_at', 'desc')
                    ->get();
    }

    public function updateOrderStatus(int $orderId, string $status): void
    {
        $order = Order::findOrFail($orderId);

        $allowedStatuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];

        if (!in_array($status, $allowedStatuses)) {
            throw new \Exception("Invalid status: {$status}");
        }

        $order->update(['status' => $status]);
    }
}