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
        $orders = $this->orderService->getUserOrders(auth()->id());
        return view('orders.index', compact('orders'));
    }

    /**
     * Customer/Admin: View a single order receipt.
     */
    public function show(int $orderId)
    {
        $order = $this->orderService->getOrder($orderId);
        
        // Customers can only view their own orders
        if (!auth()->user()->isAdmin() && $order->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('orders.receipt', compact('order'));
    }

    /**
     * Admin: View all orders.
     */
    public function adminIndex()
    {
        $orders = Order::with('user', 'items')
                       ->orderBy('created_at', 'desc')
                       ->paginate(20);
                       
        return view('orders.admin.index', compact('orders'));
    }

    /**
     * Admin: Update order status.
     */
    public function updateStatus(Request $request, int $orderId)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $this->orderService->updateOrderStatus($orderId, $request->status);

        return back()->with('success', "Order #{$orderId} status updated to: {$request->status}");
    }
}