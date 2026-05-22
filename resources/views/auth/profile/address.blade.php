@extends('layouts.app')

@section('title', 'My Addresses')

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">

    <h1 class="text-2xl font-semibold text-gray-800 mb-6">My Addresses</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 rounded-lg px-4 py-3 mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Add New Address Form --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
        <h2 class="font-medium text-gray-700 mb-4">Add New Address</h2>
        <form method="POST" action="#">
            @csrf
            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Label</label>
                <input type="text" name="label" placeholder="e.g. Home, Office"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
            </div>
            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Full Address</label>
                <input type="text" name="address"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm text-gray-600 mb-1">City</label>
                    <input type="text" name="city"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Province</label>
                    <input type="text" name="province"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">ZIP Code</label>
                <input type="text" name="zip_code"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
            </div>
            <div class="flex items-center gap-2 mb-4">
                <input type="checkbox" name="is_default" id="is_default" class="rounded">
                <label for="is_default" class="text-sm text-gray-600">Set as default address</label>
            </div>
            <button type="submit"
                    class="bg-gray-800 text-white px-5 py-2 rounded-lg text-sm hover:bg-gray-700">
                Save Address
            </button>
        </form>
    </div>

    {{-- Saved Addresses List --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h2 class="font-medium text-gray-700 mb-4">Saved Addresses</h2>
        <p class="text-sm text-gray-400">No addresses saved yet.</p>
    </div>

    <a href="{{ route('profile.dashboard') }}"
       class="inline-block mt-4 text-sm text-gray-500 hover:underline">
        ← Back to profile
    </a>

</div>
@endsection