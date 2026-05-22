<div x-data="{ open: false, itemCount: {{ $cartItemCount ?? 0 }} }" class="relative">
    <button @click="open = !open" class="relative text-gray-700 hover:text-orange-500 transition-colors p-1">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
        </svg>
        <span x-show="itemCount > 0" x-text="itemCount" 
              class="absolute -top-1 -right-1 bg-orange-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold"
              style="display: none;"></span>
    </button>
    <div x-show="open" @click.away="open = false" class="fixed inset-0 z-50" style="display: none;">
        <div @click="open = false" class="fixed inset-0 bg-black bg-opacity-25"></div>
        <div class="fixed inset-y-0 right-0 max-w-sm w-full bg-white shadow-2xl">
            <div class="h-full flex flex-col">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-neutral-800">Shopping Cart</h2>
                    <button @click="open = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="flex-1 overflow-y-auto px-6 py-4">
                    @if(isset($cartItems) && count($cartItems) > 0)
                        @foreach($cartItems->take(5) as $item)
                            <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-2xl mb-3">
                                <div class="w-12 h-12 bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl flex items-center justify-center">
                                    <svg class="h-6 w-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-neutral-800 truncate">{{ $item['product_name'] }}</p>
                                    <p class="text-xs text-gray-500">Qty: {{ $item['quantity'] }} · ₱{{ number_format($item['subtotal'], 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center text-gray-500 py-8">Cart is empty</p>
                    @endif
                </div>
                <div class="border-t border-gray-200 px-6 py-4">
                    <a href="/cart" class="block w-full py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold rounded-2xl text-center hover:opacity-90 transition">
                        View Full Cart
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>