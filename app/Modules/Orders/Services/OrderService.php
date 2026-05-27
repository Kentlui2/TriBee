<?php

declare(strict_types=1);

namespace App\Modules\Orders\Services;

use App\Modules\Orders\Models\Order;
use App\Modules\Orders\Models\OrderItem;
use App\Modules\Cart\Services\CartService;
use App\Modules\Products\Services\InventoryService;
use App\Modules\Products\Services\ProductService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class OrderService
{
    public function __construct(
        private CartService $cartService,
        private InventoryService $inventoryService,
        private ProductService $productService
    ) {}

    /**
     * Convert cart to a permanent order.
     * This is the single most important method in G4.
     */
    public function placeOrder(int $userId, array $checkoutData): Order
    {
        return DB::transaction(function () use ($userId, $checkoutData) {
            
            // 1. Get cart items from G3
            $cartItems = $this->cartService->getCartItems($userId);
            
            if ($cartItems->isEmpty()) {
                throw new \Exception('Cart is empty');
            }

            // 2. Validate stock for every item BEFORE creating order
            foreach ($cartItems as $item) {
                $hasStock = $this->inventoryService->checkStock(
                    $item['product_id'], 
                    $item['quantity']
                );
                
                if (!$hasStock) {
                    throw new \Exception("Insufficient stock for product ID: {$item['product_id']}");
                }
            }

            // 3. Calculate totals
            $cartTotal = $this->cartService->getCartTotal($userId);
            $tax = $cartTotal * 0.12;         // 12% VAT
            $shippingFee = 150.00;            // flat rate — G5 will improve this
            
            // 4. Create the order
            $order = Order::create([
                'user_id'          => $userId,
                'subtotal'         => $cartTotal,
                'tax'              => $tax,
                'shipping_fee'     => $shippingFee,
                'total'            => $cartTotal + $tax + $shippingFee,
                'status'           => 'pending',
                'shipping_address' => $checkoutData['shipping_address'] ?? null,
                'contact_number'   => $checkoutData['contact_number'] ?? null,
                'notes'            => $checkoutData['notes'] ?? null,
            ]);

            // 5. Create order items WITH SNAPSHOTS
            foreach ($cartItems as $item) {
                $product = $this->productService->getProduct($item['product_id']);
                
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item['product_id'],
                    'product_name' => $product->name,    // SNAPSHOT
                    'price'        => $product->price,    // SNAPSHOT
                    'quantity'     => $item['quantity'],
                    'subtotal'     => $product->price * $item['quantity'],
                ]);

                // 6. Deduct stock via G2's service
                $this->inventoryService->decrementStock(
                    $item['product_id'], 
                    $item['quantity']
                );
            }

            // 7. Clear the cart via G3's service
            $this->cartService->clearCart($userId);

            // 8. Return the order (G5 needs this)
            return $order;
        });
    }

    /**
     * G5 will call this to get the order total for payment.
     */
    public function getOrderTotal(int $orderId): float
    {
        $order = Order::findOrFail($orderId);
        return $order->total;
    }

    /**
     * Get full order with items for display.
     */
    public function getOrder(int $orderId): Order
    {
        return Order::with('items')->findOrFail($orderId);
    }

    /**
     * Get all orders for a specific user.
     */
    public function getUserOrders(int $userId): Collection
    {
        return Order::where('user_id', $userId)
                    ->orderBy('created_at', 'desc')
                    ->get();
    }

    /**
     * G5 will call this after payment is confirmed.
     */
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