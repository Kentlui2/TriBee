@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Hero Banner -->
    <div class="bg-gradient-to-r from-[#F97316] to-orange-400 rounded-2xl p-8 text-white">
        <div class="max-w-lg">
            <h1 class="text-2xl font-extrabold">Hey, {{ Auth::user()->name }}! 🎉</h1>
            <p class="mt-2 text-orange-100 text-sm">Ready to discover something new today?</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 mt-4 px-5 py-2.5 bg-white text-[#F97316] font-bold text-sm rounded-xl hover:bg-orange-50 transition">
                Shop Now
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                </svg>
            </a>
        </div>
    </div>

    <!-- Quick Action Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <a href="{{ route('products.index') }}" class="flex flex-col items-center gap-2 p-4 bg-white rounded-2xl border border-gray-100 hover:border-orange-200 hover:shadow-sm transition text-center">
            <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-[#F97316]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                </svg>
            </div>
            <span class="text-xs font-semibold text-gray-700">Browse</span>
        </a>
        <a href="{{ route('cart.index') }}" class="relative flex flex-col items-center gap-2 p-4 bg-white rounded-2xl border border-gray-100 hover:border-orange-200 hover:shadow-sm transition text-center">
            <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-[#F97316]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                </svg>
            </div>
            <span class="text-xs font-semibold text-gray-700">Cart</span>
            @if(isset($cartItemCount) && $cartItemCount > 0)
                <span class="absolute -top-1 -right-1 w-5 h-5 bg-[#F97316] text-white text-[9px] font-bold rounded-full flex items-center justify-center">{{ $cartItemCount }}</span>
            @endif
        </a>
        <a href="{{ route('profile.dashboard') }}" class="flex flex-col items-center gap-2 p-4 bg-white rounded-2xl border border-gray-100 hover:border-orange-200 hover:shadow-sm transition text-center">
            <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-[#F97316]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                </svg>
            </div>
            <span class="text-xs font-semibold text-gray-700">Profile</span>
        </a>
        <a href="{{ route('profile.addresses') }}" class="flex flex-col items-center gap-2 p-4 bg-white rounded-2xl border border-gray-100 hover:border-orange-200 hover:shadow-sm transition text-center">
            <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-[#F97316]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                </svg>
            </div>
            <span class="text-xs font-semibold text-gray-700">Addresses</span>
        </a>
    </div>

    <!-- Featured Products Placeholder -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-extrabold text-[#1a1a1a]">Trending Now</h2>
            <a href="{{ route('products.index') }}" class="text-sm font-medium text-[#F97316] hover:underline">View all →</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            @for($i = 0; $i < 4; $i++)
                <div class="bg-white rounded-2xl border border-gray-100 p-3 hover:shadow-sm transition cursor-pointer">
                    <div class="bg-gray-50 rounded-xl aspect-square flex items-center justify-center mb-3">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                        </svg>
                    </div>
                    <p class="text-xs font-semibold text-gray-700 truncate">Product Name</p>
                    <p class="text-xs text-[#F97316] font-bold mt-1">₱0.00</p>
                </div>
            @endfor
        </div>
    </div>
</div>
@endsection