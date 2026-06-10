<?php

namespace App\Modules\Payment\Services;

use App\Modules\Payment\Models\Shipment;

class ShippingService
{
    // Calculate shipping fee based on zip code
    public function calculateShippingFee(string $zipCode): float
    {
        $rates = [
            '8000' => 100.00,  // Davao
            '1000' => 80.00,   // NCR
            '6000' => 120.00,  // Cebu
            '5000' => 150.00,  // Iloilo
            '9000' => 130.00,  // Cagayan de Oro
        ];

        return $rates[$zipCode] ?? 150.00; // default ₱150
    }

    // Create a shipment record after payment
    public function createShipment(int $orderId, string $address, string $zipCode): Shipment
    {
        return Shipment::create([
            'order_id' => $orderId,
            'address'  => $address,
            'courier'  => 'J&T Express',
            'status'   => 'pending',
        ]);
    }

    // Update shipping status
    public function updateShippingStatus(int $orderId, string $status): void
    {
        Shipment::where('order_id', $orderId)->update(['status' => $status]);
    }

    // Simulate 5-second delay then update to shipped
    public function simulateShippingDelay(int $orderId): void
    {
        // Call G4 to mark as processing
        $orderService = app(\App\Modules\Orders\Services\OrderService::class);
        $orderService->updateOrderStatus($orderId, 'processing');

        // Simulate 5 second shipping delay
        sleep(5);

        // Update shipment status
        $this->updateShippingStatus($orderId, 'shipped');

        // Call G4 to mark as shipped
        $orderService->updateOrderStatus($orderId, 'shipped');
    }
}