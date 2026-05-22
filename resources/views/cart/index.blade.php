@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-neutral-800">Shopping Cart</h1>
            <p class="mt-2 text-gray-500">Review your items before checkout</p>
        </div>
        <a href="/products" class="text-orange-500 hover:text-orange-600 font-medium text-sm flex items-center gap-2">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Continue Shopping
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 bg-green-50 border border-green-200 rounded-2xl text-green-700 text-sm font-medium">✓ {{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="p-4 bg-red-50 border border-red-200 rounded-2xl text-red-700 text-sm font-medium">⚠ {{ session('error') }}</div>
    @endif

    @if($cartItems->isEmpty())
        <div class="text-center py-20">
            <div class="w-24 h-24 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="h-12 w-12 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-neutral-800 mb-2">Your cart is empty</h3>
            <p class="text-gray-500 mb-8">Add some products to get started!</p>
            <a href="/products" class="inline-flex px-8 py-3 bg-orange-500 text-white font-semibold rounded-2xl hover:bg-orange-600 transition">Browse Products</a>
        </div>
    @else
        <div class="flex flex-col lg:flex-row gap-8">
            <div class="lg:w-2/3 space-y-4">
                @foreach($cartItems as $item)
                    <div class="bg-white rounded-3xl p-6 border border-gray-200 shadow-sm">
                        <div class="flex items-center gap-6">
                            <div class="w-20 h-20 bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                                <svg class="h-8 w-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-neutral-800 truncate">{{ $item['product_name'] }}</h3>
                                <p class="text-sm text-gray-500 mt-1">Unit Price: ₱{{ number_format($item['unit_price'], 2) }}</p>
                                <div class="flex items-center gap-3 mt-3">
                                    <span class="text-sm text-gray-600">Qty:</span>
                                    <form action="{{ route('cart.update', $item['cart_item_id']) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="99"
                                               class="w-20 text-center border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-orange-500" 
                                               onchange="this.form.submit()">
                                    </form>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="text-lg font-bold text-neutral-800">₱{{ number_format($item['subtotal'], 2) }}</p>
                                <form action="{{ route('cart.remove', $item['cart_item_id']) }}" method="POST" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600 text-sm font-medium">Remove</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="lg:w-1/3">
                <div class="sticky top-8 space-y-6">
                    @include('cart::partials.price-summary')
                    @include('cart::partials.promo-code')
                    <a href="/checkout" class="block w-full py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold rounded-2xl text-center hover:opacity-90 transition shadow-lg shadow-orange-500/20">
                        Proceed to Checkout
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection