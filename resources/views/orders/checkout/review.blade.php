{{-- resources/views/orders/checkout/review.blade.php --}}
@extends('layouts.app')
@section('title', 'Review Order')

@section('content')
<div class="space-y-8">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-neutral-800">Review Order</h1>
            <p class="mt-2 text-gray-500">Check everything before placing your order</p>
        </div>
        <a href="{{ route('checkout.shipping') }}" class="text-orange-500 hover:text-orange-600 font-medium text-sm flex items-center gap-2">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Edit Shipping
        </a>
    </div>

    {{-- Step Indicator --}}
    <div class="flex items-center gap-3 text-sm">
        <span class="px-4 py-1.5 bg-orange-100 text-orange-500 rounded-full font-semibold">1. Shipping ✓</span>
        <span class="text-gray-300">→</span>
        <span class="px-4 py-1.5 bg-orange-500 text-white rounded-full font-semibold">2. Review</span>
        <span class="text-gray-300">→</span>
        <span class="px-4 py-1.5 bg-gray-100 text-gray-400 rounded-full">3. Confirm</span>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">

        {{-- Left: Items + Shipping --}}
        <div class="lg:w-2/3 space-y-4">

            {{-- Items --}}
            <div class="bg-white rounded-3xl p-6 border border-gray-200 shadow-sm">
                <h2 class="font-bold text-neutral-800 mb-4">Items</h2>
                @foreach($cartItems as $item)
                    <div class="flex items-center gap-4 py-3 border-b border-gray-100 last:border-0">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                            <svg class="h-5 w-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-neutral-800 text-sm">{{ $item['product_name'] }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">₱{{ number_format($item['unit_price'], 2) }} × {{ $item['quantity'] }}</p>
                        </div>
                        <span class="font-bold text-neutral-800">₱{{ number_format($item['subtotal'], 2) }}</span>
                    </div>
                @endforeach
            </div>

            {{-- Shipping Details --}}
            <div class="bg-white rounded-3xl p-6 border border-gray-200 shadow-sm">
                <h2 class="font-bold text-neutral-800 mb-3">Shipping Details</h2>
                <p class="text-sm text-gray-600">{{ session('checkout_data.shipping_address') }}</p>
                <p class="text-sm text-gray-600 mt-1">{{ session('checkout_data.contact_number') }}</p>
                @if(session('checkout_data.notes'))
                    <p class="text-sm text-gray-400 mt-1">Note: {{ session('checkout_data.notes') }}</p>
                @endif
            </div>

        </div>

        {{-- Right: Summary + Confirm --}}
        <div class="lg:w-1/3">
            <div class="sticky top-8 space-y-4">

                <div class="bg-white rounded-3xl p-6 border border-gray-200 shadow-sm">
                    <h2 class="font-bold text-neutral-800 mb-4">Payment Summary</h2>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Subtotal</span>
                            <span>₱{{ number_format($cartTotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Tax (12% VAT)</span>
                            <span>₱{{ number_format($tax, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Shipping Fee</span>
                            <span>₱{{ number_format($shippingFee, 2) }}</span>
                        </div>
                        <div class="flex justify-between font-bold text-base pt-3 border-t border-gray-100">
                            <span>Total</span>
                            <span class="text-orange-500">₱{{ number_format($grandTotal, 2) }}</span>
                        </div>
                    </div>
                </div>

                <form
                    action="{{ route('checkout.confirm') }}"
                    method="POST"
                    x-data="{ loading: false }"
                    @submit="loading = true"
                >
                    @csrf
                    <button
                        type="submit"
                        :disabled="loading"
                        class="w-full py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold rounded-2xl hover:opacity-90 transition shadow-lg shadow-orange-500/20 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span x-show="!loading">Confirm & Place Order</span>
                        <span x-show="loading">Placing Order...</span>
                    </button>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection