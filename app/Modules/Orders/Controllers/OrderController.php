<?php

declare(strict_types=1);

namespace App\Modules\Orders\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Orders\Services\OrderService;
use App\Modules\Orders\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        private OrderService $orderService
    ) {}

    /**
     * Customer: View their own order history.
     */
    public function index()
    {
        $orders = Order::with('items', 'user')->latest()->paginate(15);
        return view('orders.admin.index', compact('orders'));
    }

    /**
     * Customer/Admin: View a single order receipt.
     */
    public function show(int $orderId)
    {
        $order = $this->orderService->getOrder($orderId);

        $isAdmin = auth()->user()->is_admin;

        if (!$isAdmin && $order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('orders.receipt', compact('order'));
    }
}
