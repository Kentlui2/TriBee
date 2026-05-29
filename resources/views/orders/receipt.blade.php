{{-- resources/views/orders/receipt.blade.php --}}
@extends('layouts.app')
@section('title', 'Order Confirmed')

@section('content')
<div class="space-y-8">

    {{-- Success Header --}}
    <div class="bg-white rounded-3xl p-8 border border-gray-200 shadow-sm text-center">
        <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="h-10 w-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-neutral-800 mb-2">Order Placed Successfully!</h1>
        <p class="text-gray-500 mb-4">Thank you for your purchase. Your order is now being processed.</p>
        <div class="inline-block bg-orange-50 px-6 py-3 rounded-2xl">
            <p class="text-sm text-orange-400">Order Number</p>
            <p class="text-xl font-bold text-orange-500">#{{ $order->id }}</p>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">

        {{-- Left: Items + Shipping --}}
        <div class="lg:w-2/3 space-y-4">

            {{-- Items --}}
            <div class="bg-white rounded-3xl p-6 border border-gray-200 shadow-sm">
                <h2 class="font-bold text-neutral-800 mb-4">Items Ordered</h2>
                @foreach($order->items as $item)
                    <div class="flex items-center gap-4 py-3 border-b border-gray-100 last:border-0">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                            <svg class="h-5 w-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-neutral-800 text-sm">{{ $item->product_name }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">₱{{ number_format($item->price, 2) }} × {{ $item->quantity }}</p>
                        </div>
                        <span class="font-bold text-neutral-800">₱{{ number_format($item->subtotal, 2) }}</span>
                    </div>
                @endforeach
            </div>

            {{-- Shipping Info --}}
            <div class="bg-white rounded-3xl p-6 border border-gray-200 shadow-sm">
                <h2 class="font-bold text-neutral-800 mb-3">Shipping Details</h2>
                <p class="text-sm text-gray-600">{{ $order->shipping_address }}</p>
                <p class="text-sm text-gray-600 mt-1">{{ $order->contact_number }}</p>
                @if($order->notes)
                    <p class="text-sm text-gray-400 mt-1">Note: {{ $order->notes }}</p>
                @endif
            </div>

        </div>

        {{-- Right: Payment Summary + Actions --}}
        <div class="lg:w-1/3">
            <div class="sticky top-8 space-y-4">

                {{-- Payment Summary --}}
                <div class="bg-white rounded-3xl p-6 border border-gray-200 shadow-sm">
                    <h2 class="font-bold text-neutral-800 mb-4">Payment Summary</h2>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Subtotal</span>
                            <span>₱{{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        @if($order->discount > 0)
                            <div class="flex justify-between text-green-600">
                                <span>Discount</span>
                                <span>- ₱{{ number_format($order->discount, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-500">Tax (12% VAT)</span>
                            <span>₱{{ number_format($order->tax, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Shipping Fee</span>
                            <span>₱{{ number_format($order->shipping_fee, 2) }}</span>
                        </div>
                        <div class="flex justify-between font-bold text-base pt-3 border-t border-gray-100">
                            <span>Total</span>
                            <span class="text-orange-500">₱{{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Status --}}
                <div class="bg-white rounded-3xl p-4 border border-gray-200 shadow-sm flex justify-between items-center">
                    <span class="text-sm text-gray-500">Order Status</span>
                    <span class="px-3 py-1 text-xs rounded-full font-semibold
                        {{ $order->status === 'pending'    ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-700'    : '' }}
                        {{ $order->status === 'shipped'    ? 'bg-purple-100 text-purple-700': '' }}
                        {{ $order->status === 'delivered'  ? 'bg-green-100 text-green-700'  : '' }}
                        {{ $order->status === 'cancelled'  ? 'bg-red-100 text-red-700'      : '' }}
                    ">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                {{-- Actions --}}
                <a href="{{ route('orders.index') }}"
                   class="block w-full py-4 bg-white border border-gray-200 text-neutral-800 font-bold rounded-2xl text-center hover:bg-gray-50 transition shadow-sm">
                    View Order History
                </a>
                <a href="{{ route('dashboard') }}"
                   class="block w-full py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold rounded-2xl text-center hover:opacity-90 transition shadow-lg shadow-orange-500/20">
                    Continue Shopping
                </a>

            </div>
        </div>

    </div>
</div>
@endsection