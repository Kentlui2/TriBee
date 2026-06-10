@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center">
            <a href="{{ route('wallet.dashboard') }}" class="text-blue-600 hover:text-blue-800 mr-4">← Back</a>
            <h1 class="text-2xl font-bold">Transaction History</h1>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-green-50 border border-green-200 rounded-xl p-5">
            <p class="text-sm text-green-600 mb-1">Total Deposits</p>
            <p class="text-3xl font-bold text-green-700">₱{{ number_format($totalDeposits, 2) }}</p>
        </div>
        <div class="bg-red-50 border border-red-200 rounded-xl p-5">
            <p class="text-sm text-red-600 mb-1">Total Purchases</p>
            <p class="text-3xl font-bold text-red-700">₱{{ number_format($totalPurchases, 2) }}</p>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Date & Time</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Type</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Reference</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Description</th>
                        <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600">Amount</th>
                        <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600">Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                    <tr class="border-t hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-sm">{{ $transaction->created_at->format('M d, Y h:i A') }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-medium 
                                @if($transaction->type == 'deposit') bg-green-100 text-green-700
                                @elseif($transaction->type == 'purchase') bg-red-100 text-red-700
                                @else bg-gray-100 text-gray-700 @endif">
                                {{ ucfirst($transaction->type) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-xs font-mono">{{ $transaction->reference_no }}</td>
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
                        <td colspan="6" class="px-4 py-12 text-center text-gray-400">
                            <p class="text-lg mb-2">📭 No transactions yet</p>
                            <p class="text-sm">Top up your wallet to see your first transaction!</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection