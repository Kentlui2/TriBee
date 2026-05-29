{{-- resources/views/orders/admin/show.blade.php --}}
@extends('layouts.app')
@section('title', 'Order #{{ $order->id }}')

@section('content')
<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <a href="{{ route('admin.orders.index') }}"
               class="text-sm text-neutral-500 hover:underline">
                ← Back to Orders
            </a>
            <h1 class="text-2xl font-bold mt-1">Order #{{ $order->id }}</h1>
        </div>
        <span class="text-sm text-neutral-400">{{ $order->created_at->format('M d, Y h:i A') }}</span>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-3 gap-4 mb-4">

        {{-- Customer Info --}}
        <div class="bg-white p-6 rounded-lg shadow-sm border border-neutral-200">
            <h2 class="font-semibold mb-3">Customer</h2>
            <p class="font-medium">{{ $order->user->name }}</p>
            <p class="text-sm text-neutral-500">{{ $order->user->email }}</p>
        </div>

        {{-- Shipping Info --}}
        <div class="bg-white p-6 rounded-lg shadow-sm border border-neutral-200">
            <h2 class="font-semibold mb-3">Shipping</h2>
            <p class="text-sm text-neutral-600">{{ $order->shipping_address }}</p>
            <p class="text-sm text-neutral-600">{{ $order->contact_number }}</p>
            @if($order->notes)
                <p class="text-sm text-neutral-400 mt-1">Note: {{ $order->notes }}</p>
            @endif
        </div>

        {{-- Status Update --}}
        <div class="bg-white p-6 rounded-lg shadow-sm border border-neutral-200">
            <h2 class="font-semibold mb-3">Update Status</h2>
            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <select name="status" class="w-full border border-neutral-300 rounded-md px-3 py-2 text-sm mb-3 focus:outline-none focus:ring-2 focus:ring-neutral-400">
                    @foreach(['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                        <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
                <button type="submit"
                        class="w-full bg-neutral-800 text-white px-4 py-2 rounded-md hover:bg-black transition text-sm">
                    Update Status
                </button>
            </form>
        </div>

    </div>

    {{-- Order Items --}}
    <div class="bg-white p-6 rounded-lg shadow-sm border border-neutral-200 mb-4">
        <h2 class="font-semibold text-lg mb-4">Items Ordered</h2>
        <table class="w-full text-sm">
            <thead class="border-b">
                <tr>
                    <th class="text-left py-2 font-semibold text-neutral-600">Product</th>
                    <th class="text-center py-2 font-semibold text-neutral-600">Qty</th>
                    <th class="text-right py-2 font-semibold text-neutral-600">Unit Price</th>
                    <th class="text-right py-2 font-semibold text-neutral-600">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-100">
                @foreach($order->items as $item)
                    <tr>
                        <td class="py-3">{{ $item->product_name }}</td>
                        <td class="py-3 text-center text-neutral-500">{{ $item->quantity }}</td>
                        <td class="py-3 text-right">₱{{ number_format($item->price, 2) }}</td>
                        <td class="py-3 text-right font-medium">₱{{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Payment Summary --}}
    <div class="bg-white p-6 rounded-lg shadow-sm border border-neutral-200">
        <h2 class="font-semibold text-lg mb-4">Payment Summary</h2>
        <div class="space-y-2 text-sm max-w-xs ml-auto">
            <div class="flex justify-between">
                <span class="text-neutral-500">Subtotal</span>
                <span>₱{{ number_format($order->subtotal, 2) }}</span>
            </div>
            @if($order->discount > 0)
                <div class="flex justify-between text-green-600">
                    <span>Discount</span>
                    <span>- ₱{{ number_format($order->discount, 2) }}</span>
                </div>
            @endif
            <div class="flex justify-between">
                <span class="text-neutral-500">Tax (12% VAT)</span>
                <span>₱{{ number_format($order->tax, 2) }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-neutral-500">Shipping Fee</span>
                <span>₱{{ number_format($order->shipping_fee, 2) }}</span>
            </div>
            <div class="flex justify-between font-bold text-base pt-2 border-t">
                <span>Total</span>
                <span>₱{{ number_format($order->total, 2) }}</span>
            </div>
        </div>
    </div>

</div>
@endsection