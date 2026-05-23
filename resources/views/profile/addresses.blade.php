@extends('layouts.app')

@section('title', 'My Addresses')

@section('content')
<div class="bg-white rounded-2xl border border-gray-100 p-6 sm:p-8 shadow-sm">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-bold text-neutral-900">My Addresses</h2>
        <a href="#" class="inline-flex items-center bg-neutral-900 hover:bg-neutral-800 text-white font-medium px-5 py-2.5 rounded-xl text-sm transition">
            Add New Address
        </a>
    </div>
    <div class="text-center py-16">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-orange-50 mb-4">
            <svg class="w-8 h-8 text-orange-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>
        <h3 class="text-base font-semibold text-neutral-700 mb-1">No addresses yet</h3>
        <p class="text-sm text-gray-400 max-w-sm mx-auto">Add your first address to make checkout faster and easier.</p>
    </div>
</div>
@endsection