@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-lg">
    <div class="flex items-center mb-6">
        <a href="{{ route('wallet.dashboard') }}" class="text-blue-600 hover:text-blue-800 mr-4">← Back</a>
        <h1 class="text-2xl font-bold">Top Up Wallet</h1>
    </div>
    
    <div class="bg-white rounded-xl shadow-lg p-6">
        <form action="{{ route('wallet.topup') }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Amount to Add</label>
                <div class="relative">
                    <span class="absolute left-4 top-3 text-gray-500 text-lg">₱</span>
                    <input type="number" name="amount" 
                           class="w-full border border-gray-300 rounded-lg p-3 pl-8 text-lg focus:outline-none focus:ring-2 focus:ring-green-500" 
                           placeholder="0.00" 
                           min="100" 
                           max="10000" 
                           step="100" 
                           required>
                </div>
                <p class="text-sm text-gray-500 mt-2">Minimum: ₱100 | Maximum: ₱10,000</p>
            </div>
            
            <div class="grid grid-cols-2 gap-4 mb-6">
                <button type="button" onclick="document.querySelector('input[name=amount]').value=500" 
                        class="border border-gray-300 rounded-lg py-2 hover:bg-gray-50 transition">
                    ₱500
                </button>
                <button type="button" onclick="document.querySelector('input[name=amount]').value=1000" 
                        class="border border-gray-300 rounded-lg py-2 hover:bg-gray-50 transition">
                    ₱1,000
                </button>
                <button type="button" onclick="document.querySelector('input[name=amount]').value=2000" 
                        class="border border-gray-300 rounded-lg py-2 hover:bg-gray-50 transition">
                    ₱2,000
                </button>
                <button type="button" onclick="document.querySelector('input[name=amount]').value=5000" 
                        class="border border-gray-300 rounded-lg py-2 hover:bg-gray-50 transition">
                    ₱5,000
                </button>
            </div>
            
            <div class="bg-yellow-50 rounded-lg p-3 mb-5 text-sm text-yellow-700">
                <p>💡 Note: This is a demo top-up. No actual payment will be charged.</p>
            </div>
            
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-medium py-3 rounded-lg transition duration-200">
                    Confirm Top Up
                </button>
                <a href="{{ route('wallet.dashboard') }}" 
                   class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 text-center py-3 rounded-lg transition duration-200">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection