{{-- resources/views/orders/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Order History')

@section('content')
<div class="max-w-4xl mx-auto">

    <h1 class="text-2xl font-bold mb-6">Order History</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($orders->isEmpty())
        {{-- Empty State --}}
        <div class="bg-white p-12 rounded-lg shadow-sm border border-neutral-200 text-center">
            <div class="text-5xl mb-4">📦</div>
            <h2 class="text-lg font-semibold mb-2">No orders yet</h2>
            <p class="text-neutral-500 mb-6">Looks like you haven't placed any orders yet.</p>
            <a href="{{ url('/') }}"
               class="bg-neutral-800 text-white px-6 py-2 rounded-md hover:bg-black transition">
                Start Shopping
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white p-6 rounded-lg shadow-sm border border-neutral-200">
                    
                    {{-- Order Header --}}
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-sm text-neutral-400">Order Number</p>
                            <p class="font-bold text-lg">#{{ $order->id }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-neutral-400">Date</p>
                            <p class="text-sm font-medium">{{ $order->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-neutral-400">Status</p>
                            <span class="inline-block px-3 py-1 text-xs rounded-full font-medium
                                {{ $order->status === 'pending'    ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-700'    : '' }}
                                {{ $order->status === 'shipped'    ? 'bg-purple-100 text-purple-700': '' }}
                                {{ $order->status === 'delivered'  ? 'bg-green-100 text-green-700'  : '' }}
                                {{ $order->status === 'cancelled'  ? 'bg-red-100 text-red-700'      : '' }}
                            ">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-neutral-400">Total</p>
                            <p class="font-bold">₱{{ number_format($order->total, 2) }}</p>
                        </div>
                    </div>

                    {{-- Item Previews --}}
                    <div class="border-t pt-4">
                        @foreach($order->items->take(3) as $item)
                            <div class="flex justify-between text-sm py-1">
                                <span class="text-neutral-600">
                                    {{ $item->product_name }}
                                    <span class="text-neutral-400">× {{ $item->quantity }}</span>
                                </span>
                                <span>₱{{ number_format($item->subtotal, 2) }}</span>
                            </div>
                        @endforeach

                        @if($order->items->count() > 3)
                            <p class="text-xs text-neutral-400 mt-1">
                                + {{ $order->items->count() - 3 }} more item(s)
                            </p>
                        @endif
                    </div>

                    {{-- View Receipt Link --}}
                    <div class="mt-4 text-right">
                        <a href="{{ route('orders.receipt', $order->id) }}"
                           class="text-sm text-neutral-800 font-medium hover:underline">
                            View Receipt →
                        </a>
                    </div>

                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection