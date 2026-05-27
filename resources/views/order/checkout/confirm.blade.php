@extends('layouts.app')
@section('title', 'Order Confirmed')

@section('content')
<div class="max-w-3xl mx-auto py-12">

    {{-- Step indicator --}}
    <div class="flex items-center gap-2 mb-8 text-sm text-neutral-500 justify-center">
        <span>1. Shipping</span>
        <span>→</span>
        <span>2. Review</span>
        <span>→</span>
        <span class="font-semibold text-neutral-800">3. Confirm</span>
    </div>

    {{-- Success Message Card --}}
    <div class="bg-white p-8 rounded-lg shadow-sm border border-neutral-200 text-center">
        <div class="text-green-500 text-5xl mb-4">✓</div>
        
        <h1 class="text-2xl font-bold mb-2">Order Placed Successfully!</h1>
        
        <p class="text-neutral-600 mb-6">
            Thank you for your purchase. We have received your order and it is now being processed.
        </p>

        @if(isset($order))
            <div class="bg-neutral-50 p-4 rounded-md mb-6 inline-block text-left">
                <p class="text-sm text-neutral-500">Order Number</p>
                <p class="text-lg font-bold">#{{ $order->id }}</p>
            </div>
        @endif

        <div class="mt-4">
            <a href="{{ route('home') }}" class="bg-neutral-800 text-white px-8 py-2 rounded-md hover:bg-black transition">
                Return to Shop
            </a>
        </div>
    </div>
</div>
@endsection