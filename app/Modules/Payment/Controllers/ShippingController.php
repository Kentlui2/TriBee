<?php

namespace App\Modules\Payment\Controllers;

use App\Http\Controllers\Controller;
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
            'shipping_cost'   => $fee,
            'estimated_days'  => 3,
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
}