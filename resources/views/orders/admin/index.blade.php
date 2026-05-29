{{-- resources/views/orders/admin/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Admin - Order Management')

@section('content')
<div class="max-w-6xl mx-auto">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Order Management</h1>
        <span class="text-sm text-neutral-500">{{ $orders->total() }} total orders</span>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($orders->isEmpty())
        <div class="bg-white p-12 rounded-lg shadow-sm border border-neutral-200 text-center">
            <div class="text-5xl mb-4">📦</div>
            <h2 class="text-lg font-semibold mb-2">No orders yet</h2>
            <p class="text-neutral-500">Orders will appear here once customers start purchasing.</p>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-sm border border-neutral-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-neutral-50 border-b border-neutral-200">
                    <tr>
                        <th class="text-left px-6 py-3 font-semibold text-neutral-600">Order</th>
                        <th class="text-left px-6 py-3 font-semibold text-neutral-600">Customer</th>
                        <th class="text-left px-6 py-3 font-semibold text-neutral-600">Items</th>
                        <th class="text-left px-6 py-3 font-semibold text-neutral-600">Total</th>
                        <th class="text-left px-6 py-3 font-semibold text-neutral-600">Status</th>
                        <th class="text-left px-6 py-3 font-semibold text-neutral-600">Date</th>
                        <th class="text-left px-6 py-3 font-semibold text-neutral-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @foreach($orders as $order)
                        <tr class="hover:bg-neutral-50 transition">
                            <td class="px-6 py-4 font-bold">#{{ $order->id }}</td>
                            <td class="px-6 py-4">
                                <p class="font-medium">{{ $order->user->name }}</p>
                                <p class="text-neutral-400 text-xs">{{ $order->user->email }}</p>
                            </td>
                            <td class="px-6 py-4 text-neutral-500">
                                {{ $order->items->count() }} item(s)
                            </td>
                            <td class="px-6 py-4 font-semibold">
                                ₱{{ number_format($order->total, 2) }}
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select
                                        name="status"
                                        onchange="this.form.submit()"
                                        class="text-xs border border-neutral-300 rounded-md px-2 py-1 focus:outline-none focus:ring-2 focus:ring-neutral-400
                                            {{ $order->status === 'pending'    ? 'bg-yellow-50 text-yellow-700' : '' }}
                                            {{ $order->status === 'processing' ? 'bg-blue-50 text-blue-700'    : '' }}
                                            {{ $order->status === 'shipped'    ? 'bg-purple-50 text-purple-700': '' }}
                                            {{ $order->status === 'delivered'  ? 'bg-green-50 text-green-700'  : '' }}
                                            {{ $order->status === 'cancelled'  ? 'bg-red-50 text-red-700'      : '' }}
                                        "
                                    >
                                        @foreach(['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                                            <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-neutral-500">
                                {{ $order->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                   class="text-neutral-800 font-medium hover:underline text-xs">
                                    View →
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @endif

</div>
@endsection