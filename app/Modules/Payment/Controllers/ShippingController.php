<?php

namespace App\Modules\Payment\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Payment\Models\Shipment;
use App\Modules\Payment\Services\ShippingService;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    protected ShippingService $shippingService;

    public function __construct(ShippingService $shippingService)
    {
        $this->shippingService = $shippingService;
    }

    // G4 calls this to calculate shipping fee
    public function calculateShipping(Request $request)
    {
        $request->validate([
            'zip_code' => 'required|string',
        ]);

        $fee = $this->shippingService->calculateShippingFee(
            $request->zip_code
        );

        return response()->json([
            'shipping_cost'  => $fee,
            'estimated_days' => 3,
        ]);
    }

    // Called after payment is confirmed
    public function processShipping(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer',
            'address'  => 'required|string',
            'zip_code' => 'required|string',
        ]);

        // Create shipment record
        $shipment = $this->shippingService->createShipment(
            $request->order_id,
            $request->address,
            $request->zip_code
        );

        // Trigger 5-second delay then update to shipped
        $this->shippingService->simulateShippingDelay(
            $request->order_id
        );

        return response()->json([
            'message'  => 'Order is now in transit!',
            'shipment' => $shipment,
        ]);
    }

    // G4 calls this to check payment/shipping status
    public function getPaymentStatus(int $orderId)
    {
        $shipment = Shipment::where('order_id', $orderId)->first();

        return response()->json([
            'order_id' => $orderId,
            'status'   => $shipment ? $shipment->status : 'not_found',
            'message'  => $shipment
                ? 'Shipment found'
                : 'No shipment found for this order',
        ]);
    }

    // Update shipping status manually
    public function updateStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer',
            'status'   => 'required|in:pending,shipped,delivered',
        ]);

        $this->shippingService->updateShippingStatus(
            $request->order_id,
            $request->status
        );

        return response()->json([
            'message' => 'Shipping status updated to ' . $request->status,
        ]);
    }

    // Show tracking info for an order
    public function tracking(int $orderId)
    {
        $shipment = Shipment::where('order_id', $orderId)->first();

        if (!$shipment) {
            return response()->json([
                'message' => 'No shipment found for this order'
            ], 404);
        }

        return response()->json([
            'order_id'    => $orderId,
            'courier'     => $shipment->courier,
            'tracking_no' => $shipment->tracking_no,
            'status'      => $shipment->status,
            'address'     => $shipment->address,
        ]);
    }
}