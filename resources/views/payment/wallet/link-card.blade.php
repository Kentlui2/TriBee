@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-lg">
    <div class="flex items-center mb-6">
        <a href="{{ route('wallet.dashboard') }}" class="text-blue-600 hover:text-blue-800 mr-4">← Back</a>
        <h1 class="text-2xl font-bold">Link Payment Card</h1>
    </div>
    
    <div class="bg-white rounded-xl shadow-lg p-6">
        <form action="{{ route('wallet.link-card') }}" method="POST">
            @csrf
            
            <div class="mb-5">
                <label class="block text-sm font-medium mb-2">Cardholder Name</label>
                <input type="text" name="cardholder_name" 
                       class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       placeholder="John M. Doe"
                       required>
            </div>
            
            <div class="mb-5">
                <label class="block text-sm font-medium mb-2">Card Number</label>
                <input type="text" name="card_number" 
                       class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       placeholder="1234 5678 9012 3456" 
                       maxlength="16" 
                       required>
            </div>
            
            <div class="grid grid-cols-3 gap-4 mb-5">
                <div>
                    <label class="block text-sm font-medium mb-2">Expiry Month</label>
                    <input type="text" name="expiry_month" 
                           class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           placeholder="MM" 
                           maxlength="2" 
                           required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Expiry Year</label>
                    <input type="text" name="expiry_year" 
                           class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           placeholder="YYYY" 
                           maxlength="4" 
                           required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">CVV</label>
                    <input type="password" name="cvv" 
                           class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           placeholder="123" 
                           maxlength="3" 
                           required>
                </div>
            </div>
            
            <div class="bg-gray-50 rounded-lg p-3 mb-5 text-sm text-gray-500">
                <p>🔒 Your card information is secure and will only be used for payments.</p>
                <p class="mt-1">💳 Only the last 4 digits will be stored for reference.</p>
            </div>
            
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 rounded-lg transition duration-200">
                Link Card
            </button>
        </form>
    </div>
</div>
@endsection