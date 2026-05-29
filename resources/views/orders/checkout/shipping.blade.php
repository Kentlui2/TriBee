{{-- resources/views/orders/checkout/shipping.blade.php --}}
@extends('layouts.app')
@section('title', 'Checkout - Shipping')

@section('content')
<div class="space-y-8">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-neutral-800">Checkout</h1>
            <p class="mt-2 text-gray-500">Enter your shipping details</p>
        </div>
        <a href="{{ route('cart.index') }}" class="text-orange-500 hover:text-orange-600 font-medium text-sm flex items-center gap-2">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Cart
        </a>
    </div>

    {{-- Step Indicator --}}
    <div class="flex items-center gap-3 text-sm">
        <span class="px-4 py-1.5 bg-orange-500 text-white rounded-full font-semibold">1. Shipping</span>
        <span class="text-gray-300">→</span>
        <span class="px-4 py-1.5 bg-gray-100 text-gray-400 rounded-full">2. Review</span>
        <span class="text-gray-300">→</span>
        <span class="px-4 py-1.5 bg-gray-100 text-gray-400 rounded-full">3. Confirm</span>
    </div>

    @if($errors->any())
        <div class="p-4 bg-red-50 border border-red-200 rounded-2xl text-red-700 text-sm font-medium">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 bg-red-50 border border-red-200 rounded-2xl text-red-700 text-sm font-medium">
            ⚠ {{ session('error') }}
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-8">

        {{-- Shipping Form --}}
        <div class="lg:w-2/3">
            <div class="bg-white rounded-3xl p-8 border border-gray-200 shadow-sm">
                <h2 class="text-lg font-bold text-neutral-800 mb-6">Shipping Information</h2>
                <form action="{{ route('checkout.review') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 mb-2">
                            Shipping Address
                        </label>
                        <textarea
                            name="shipping_address"
                            rows="3"
                            required
                            placeholder="Enter your full delivery address"
                            class="w-full border border-gray-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-300 focus:border-orange-400 transition"
                        >{{ old('shipping_address', session('checkout_data.shipping_address')) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 mb-2">
                            Contact Number
                        </label>
                        <input
                            type="text"
                            name="contact_number"
                            value="{{ old('contact_number', session('checkout_data.contact_number')) }}"
                            required
                            placeholder="e.g. 09xxxxxxxxx"
                            class="w-full border border-gray-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-300 focus:border-orange-400 transition"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 mb-2">
                            Order Notes <span class="text-gray-400 font-normal">(optional)</span>
                        </label>
                        <textarea
                            name="notes"
                            rows="2"
                            placeholder="Special instructions, landmarks, etc."
                            class="w-full border border-gray-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-300 focus:border-orange-400 transition"
                        >{{ old('notes', session('checkout_data.notes')) }}</textarea>
                    </div>

                    <button
                        type="submit"
                        class="w-full py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold rounded-2xl hover:opacity-90 transition shadow-lg shadow-orange-500/20"
                    >
                        Review Order →
                    </button>
                </form>
            </div>
        </div>

        {{-- Order Summary Sidebar --}}
        <div class="lg:w-1/3">
            <div class="sticky top-8 bg-white rounded-3xl p-6 border border-gray-200 shadow-sm">
                <h2 class="text-lg font-bold text-neutral-800 mb-4">Order Summary</h2>
                @foreach($cartItems as $item)
                    <div class="flex justify-between text-sm py-2 border-b border-gray-100 last:border-0">
                        <span class="text-gray-600">
                            {{ $item['product_name'] }}
                            <span class="text-gray-400">× {{ $item['quantity'] }}</span>
                        </span>
                        <span class="font-semibold">₱{{ number_format($item['subtotal'], 2) }}</span>
                    </div>
                @endforeach
                <div class="flex justify-between font-bold text-base pt-4 mt-2">
                    <span>Total</span>
                    <span class="text-orange-500">₱{{ number_format($cartTotal, 2) }}</span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection