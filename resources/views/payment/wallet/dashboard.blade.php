@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-5xl">
    <h1 class="text-3xl font-bold mb-8">My Wallet</h1>
    
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-2xl shadow-lg p-6 mb-8">
        <p class="text-sm opacity-80 mb-2">Available Balance</p>
        <p class="text-5xl font-bold">₱{{ number_format($wallet->balance, 2) }}</p>
        
        @if($wallet->card_last_four)
            <div class="mt-4 pt-4 border-t border-blue-400 border-opacity-30">
                <p class="text-sm opacity-80">Linked Card</p>
                <p class="font-mono">•••• •••• •••• {{ $wallet->card_last_four }}</p>
                <p class="text-sm">{{ $wallet->cardholder_name }}</p>
            </div>
        @endif
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
        <a href="{{ route('wallet.link-card') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white text-center py-3 rounded-xl transition duration-200 font-medium">
            🔗 Link Card
        </a>
        <a href="{{ route('wallet.topup.form') }}" 
           class="bg-green-600 hover:bg-green-700 text-white text-center py-3 rounded-xl transition duration-200 font-medium">
            💰 Top Up
        </a>
        <a href="{{ route('wallet.transactions') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white text-center py-3 rounded-xl transition duration-200 font-medium">
            📜 Transaction History
        </a>
    </div>
    
    <h2 class="text-xl font-bold mb-4">Recent Transactions</h2>
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Date</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Type</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Description</th>
                        <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600">Amount</th>
                        <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600">Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm">{{ $transaction->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-medium 
                                @if($transaction->type == 'deposit') bg-green-100 text-green-700
                                @elseif($transaction->type == 'purchase') bg-red-100 text-red-700
                                @else bg-gray-100 text-gray-700 @endif">
                                {{ ucfirst($transaction->type) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">{{ $transaction->description }}</td>
                        <td class="px-4 py-3 text-right text-sm">
                            @if($transaction->type == 'deposit')
                                <span class="text-green-600">+₱{{ number_format($transaction->amount, 2) }}</span>
                            @else
                                <span class="text-red-600">-₱{{ number_format($transaction->amount, 2) }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right text-sm">₱{{ number_format($transaction->balance_after, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-400">
                            No transactions yet. Top up your wallet to get started!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection