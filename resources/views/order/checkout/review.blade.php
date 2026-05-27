{{-- resources/views/orders/checkout/review.blade.php --}}
@extends('layouts.app')
@section('title', 'Review Order')

@section('content')
<div class="max-w-3xl mx-auto">

    {{-- Step indicator --}}
    <div class="flex items-center gap-2 mb-8 text-sm text-neutral-500">
        <span>1. Shipping</span>
        <span>→</span>
        <span class="font-semibold text-neutral-800">2. Review</span>
        <span>→</span>
        <span>3. Confirm</span>
    </div>

    <h1 class="text-2xl font-bold mb-6">Review Your Order</h1>

    {{-- Order Items --}}
    <div class="bg-white p-6 rounded-lg shadow-sm mb-4">
        <h2 class="font-semibold text-lg mb-4">Items</h2>

        @foreach($cartItems as $item)
            <div class="flex justify-between py-2 border-b last:border-0">
                <span>
                    {{ $item['product_name'] }}
                    <span class="text-neutral-400 text-sm">× {{ $item['quantity'] }}</span>
                </span>
                <span class="font-medium">₱{{ number_format($item['subtotal'], 2) }}</span>
            </div>
        @endforeach
    </div>

    {{-- Pricing Summary --}}
    <div class="bg-white p-6 rounded-lg shadow-sm mb-4">
        <h2 class="font-semibold text-lg mb-4">Order Summary</h2>

        <div class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-neutral-500">Subtotal</span>
                <span>₱{{ number_format($cartTotal, 2) }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-neutral-500">Tax (12% VAT)</span>
                <span>₱{{ number_format($tax, 2) }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-neutral-500">Shipping Fee</span>
                <span>₱{{ number_format($shippingFee, 2) }}</span>
            </div>
            <div class="flex justify-between font-bold text-base pt-2 border-t">
                <span>Total</span>
                <span>₱{{ number_format($grandTotal, 2) }}</span>
            </div>
        </div>
    </div>

    {{-- Shipping Info --}}
    <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
        <h2 class="font-semibold text-lg mb-2">Shipping Details</h2>
        <p class="text-sm text-neutral-600">{{ session('checkout_data.shipping_address') }}</p>
        <p class="text-sm text-neutral-600">{{ session('checkout_data.contact_number') }}</p>
        @if(session('checkout_data.notes'))
            <p class="text-sm text-neutral-400 mt-1">Note: {{ session('checkout_data.notes') }}</p>
        @endif
    </div>

    {{-- Actions --}}
    <div class="flex justify-between items-center">
        <a href="{{ route('checkout.shipping') }}" class="text-sm text-neutral-500 hover:underline">
            ← Edit Shipping
        </a>

        <form action="{{ route('checkout.confirm') }}" method="POST" x-data="{ loading: false }">
            @csrf
            <button
                type="submit"
                @click="loading = true"
                :disabled="loading"
                class="bg-neutral-800 text-white px-6 py-2 rounded-md hover:bg-black transition disabled:opacity-50 disabled:cursor-not-allowed"
            >
                <span x-show="!loading">Confirm & Place Order</span>
                <span x-show="loading">Placing Order...</span>
            </button>
        </form>
    </div>

</div>
@endsection