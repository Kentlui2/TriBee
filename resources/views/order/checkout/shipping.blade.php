{{-- resources/views/orders/checkout/shipping.blade.php --}}
@extends('layouts.app')
@section('title', 'Checkout - Shipping')

@section('content')
<div class="max-w-3xl mx-auto">

    {{-- Step indicator --}}
    <div class="flex items-center gap-2 mb-8 text-sm text-neutral-500">
        <span class="font-semibold text-neutral-800">1. Shipping</span>
        <span>→</span>
        <span>2. Review</span>
        <span>→</span>
        <span>3. Confirm</span>
    </div>

    <h1 class="text-2xl font-bold mb-6">Shipping Details</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white p-6 rounded-lg shadow-sm">
        <form action="{{ route('checkout.review') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block font-medium mb-1">Shipping Address</label>
                <textarea
                    name="shipping_address"
                    rows="3"
                    required
                    class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-neutral-400"
                >{{ old('shipping_address', session('checkout_data.shipping_address')) }}</textarea>
            </div>

            <div>
                <label class="block font-medium mb-1">Contact Number</label>
                <input
                    type="text"
                    name="contact_number"
                    value="{{ old('contact_number', session('checkout_data.contact_number')) }}"
                    required
                    class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-neutral-400"
                >
            </div>

            <div>
                <label class="block font-medium mb-1">
                    Order Notes <span class="text-neutral-400 font-normal">(optional)</span>
                </label>
                <textarea
                    name="notes"
                    rows="2"
                    placeholder="Special instructions, landmarks, etc."
                    class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-neutral-400"
                >{{ old('notes', session('checkout_data.notes')) }}</textarea>
            </div>

            <div class="flex justify-between items-center pt-2">
                <a href="{{ route('cart.index') }}" class="text-sm text-neutral-500 hover:underline">
                    ← Back to Cart
                </a>
                <button type="submit" class="bg-neutral-800 text-white px-6 py-2 rounded-md hover:bg-black transition">
                    Review Order →
                </button>
            </div>
        </form>
    </div>
</div>
@endsection