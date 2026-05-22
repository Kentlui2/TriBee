@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-neutral-800">Shopping Cart</h1>
            <p class="mt-2 text-gray-500">Review your items before checkout</p>
        </div>
        <a href="{{ route('products.index') }}" class="text-orange-500 hover:text-orange-600 font-medium text-sm flex items-center gap-2">
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
        <!-- Empty Cart -->
        <div class="text-center py-20">
            <div class="w-24 h-24 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="h-12 w-12 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-neutral-800 mb-2">Your cart is empty</h3>
            <p class="text-gray-500 mb-8">Add some products to get started!</p>
            <a href="{{ route('products.index') }}" class="inline-flex px-8 py-3 bg-orange-500 text-white font-semibold rounded-2xl hover:bg-orange-600 transition">
                Browse Products
            </a>
        </div>
    @else
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Cart Items -->
            <div class="lg:w-2/3 space-y-4">
                @foreach($cartItems as $item)
                    <div class="bg-white rounded-3xl p-6 border border-gray-200 shadow-sm">
                        <div class="flex items-center gap-6">
                            <!-- Product Icon -->
                            <div class="w-20 h-20 bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                                <svg class="h-8 w-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            
                            <!-- Product Info -->
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-neutral-800 truncate">{{ $item['product_name'] }}</h3>
                                <p class="text-sm text-gray-500 mt-1">Unit Price: ₱{{ number_format((float)$item['unit_price'], 2) }}</p>
                                
                                <!-- Quantity -->
                                <div class="flex items-center gap-3 mt-3">
                                    <span class="text-sm text-gray-600">Qty:</span>
                                 <form action="{{ route('cart.update', $item['cart_item_id']) }}" method="POST" class="flex items-center gap-0.5">
    @csrf
    @method('PUT')
    <button type="button" onclick="
        var input = this.nextElementSibling;
        var qty = Math.max(1, parseInt(input.value) - 1);
        input.value = qty;
        this.form.querySelector('[name=quantity]').value = qty;
        this.form.submit();
    " class="w-7 h-7 bg-gray-100 hover:bg-gray-200 rounded-lg text-xs font-bold">−</button>
    
    <input type="text" value="{{ $item['quantity'] }}" disabled
           class="w-10 text-center bg-transparent border-0 text-sm font-semibold text-neutral-800 cursor-default p-0">
    
    <button type="button" onclick="
        var input = this.previousElementSibling;
        var qty = parseInt(input.value) + 1;
        input.value = qty;
        this.form.querySelector('[name=quantity]').value = qty;
        this.form.submit();
    " class="w-7 h-7 bg-gray-100 hover:bg-gray-200 rounded-lg text-xs font-bold">+</button>
    
    <input type="hidden" name="quantity" value="{{ $item['quantity'] }}">
</form>
                                </div>
                            </div>
                            
                            <!-- Price & Remove -->
                            <div class="text-right flex-shrink-0">
                                <p class="text-lg font-bold text-neutral-800">₱{{ number_format((float)$item['subtotal'], 2) }}</p>
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

            <!-- Summary Sidebar -->
            <div class="lg:w-1/3">
                <div class="sticky top-8 space-y-6">
                    <!-- Price Summary -->
                    <div class="bg-white rounded-3xl p-8 border border-gray-200 shadow-sm">
                        <h2 class="text-lg font-bold text-neutral-800 mb-6">Order Summary</h2>
                        <div class="space-y-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal ({{ $cartItems->sum('quantity') }} items)</span>
                                <span class="font-semibold text-neutral-800">₱{{ number_format($subtotal, 2) }}</span>
                            </div>
                            @if($pricingBreakdown['has_discounts'] ?? false)
                                <div class="flex justify-between text-sm text-green-600">
                                    <span>Discount</span>
                                    <span class="font-semibold">-₱{{ number_format($pricingBreakdown['savings'] ?? 0, 2) }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">VAT (12%)</span>
                                <span class="font-semibold text-neutral-800">₱{{ number_format($pricingBreakdown['tax']['amount'] ?? 0, 2) }}</span>
                            </div>
                            <div class="border-t-2 border-gray-100 pt-4 flex justify-between">
                                <span class="text-base font-bold text-neutral-800">Total</span>
                                <span class="text-xl font-bold text-neutral-800">₱{{ number_format($pricingBreakdown['total'] ?? $subtotal, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Promo Code -->
                    @include('cart.partials.promo-code')

                    <!-- Checkout -->
                    <a href="#" class="block w-full py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold rounded-2xl text-center hover:opacity-90 transition shadow-lg shadow-orange-500/20">
                        Proceed to Checkout
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
