<?php

declare(strict_types=1);

namespace App\Modules\Orders\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Orders\Models\Order;
use App\Modules\Orders\Services\OrderService;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function __construct(private OrderService $orderService) {}

    public function index()
    {
        $orders = Order::with('items')->latest()->paginate(15);
        return view('orders.admin.index', compact('orders'));
    }

    public function show(int $id)
    {
        $order = $this->orderService->getOrder($id);
        return view('orders.admin.show', compact('order'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $this->orderService->updateOrderStatus($id, $request->status);
        return back()->with('success', 'Order status updated!');
    }
}
