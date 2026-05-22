{{-- 
    Logic Note: Add to Cart button state managed by Member 2 LOVELY
    based on Inventory stock availability.
--}}
<x-guest-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <nav class="mb-8 text-sm font-medium text-gray-500">
                <a href="/products" class="hover:text-orange-500 transition-colors">Products</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">{{ $product->name }}</span>
            </nav>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden grid grid-cols-1 md:grid-cols-2 gap-8 p-6 md:p-8">
                
                <div class="flex flex-col space-y-4">
                    <div class="w-full h-96 bg-gray-100 rounded-xl overflow-hidden border border-gray-200 shadow-inner relative">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=500' }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover">
                    </div>
                    
                    <div class="grid grid-cols-4 gap-2">
                        <div class="h-20 bg-gray-100 rounded-lg border-2 border-orange-500 overflow-hidden cursor-pointer">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=500' }}" class="w-full h-full object-cover opacity-100">
                        </div>
                        <div class="h-20 bg-gray-50 rounded-lg border border-gray-200 overflow-hidden cursor-pointer hover:border-orange-300 transition-colors">
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center text-xs text-gray-400 font-bold">IMAGE 2</div>
                        </div>
                        <div class="h-20 bg-gray-50 rounded-lg border border-gray-200 overflow-hidden cursor-pointer hover:border-orange-300 transition-colors">
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center text-xs text-gray-400 font-bold">IMAGE 3</div>
                        </div>
                        <div class="h-20 bg-gray-50 rounded-lg border border-gray-200 overflow-hidden cursor-pointer hover:border-orange-300 transition-colors">
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center text-xs text-gray-400 font-bold">IMAGE 4</div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <span class="bg-orange-100 text-orange-600 text-xs font-extrabold uppercase px-3 py-1 rounded-full tracking-wider">
                                Category ID: #{{ $product->category_id }}
                            </span>
                            
                            @if(($product->inventory->stock ?? 0) > 0)
                                <span class="text-sm font-semibold text-green-600 flex items-center">
                                    <span class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2 animate-pulse"></span>
                                    In Stock ({{ $product->inventory->stock }})
                                </span>
                            @else
                                <span class="text-sm font-semibold text-red-600 flex items-center">
                                    <span class="h-2.5 w-2.5 rounded-full bg-red-500 mr-2"></span>
                                    Out of Stock
                                </span>
                            @endif
                        </div>

                        <h1 class="text-3xl font-black text-gray-900 tracking-tight mb-2">
                            {{ $product->name }}
                        </h1>
                        
                        <div class="text-2xl font-black text-orange-600 mb-6">
                            ₱{{ number_format((float)$product->price, 2) }}
                        </div>

                        <hr class="border-gray-200 my-4">

                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Description</h3>
                        <p class="text-gray-600 leading-relaxed text-sm mb-6">
                            {{ $product->description ?? 'No detailed description provided for this catalog item.' }}
                        </p>

                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-3">Specifications</h3>
                        <div class="border border-gray-100 rounded-xl overflow-hidden shadow-sm text-sm mb-6">
                            @if(!empty($product->specifications) && is_array($product->specifications))
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-gray-50 border-b border-gray-100">
                                            <th class="px-4 py-2 text-xs font-bold text-gray-400 uppercase">Feature</th>
                                            <th class="px-4 py-2 text-xs font-bold text-gray-400 uppercase">Detail Value</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        @foreach($product->specifications as $key => $value)
                                            <tr class="hover:bg-gray-50/50 transition-colors">
                                                <td class="px-4 py-3 font-semibold text-gray-700 capitalize">{{ str_replace('_', ' ', $key) }}</td>
                                                <td class="px-4 py-3 text-gray-600">{{ $value }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="p-4 bg-gray-50 text-gray-500 text-center italic text-xs">
                                    Standard system hardware specification configurations applied.
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-auto pt-4 border-t border-gray-100 flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
    <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="quantity" value="1">
        
        <button type="submit" 
                class="w-full py-3.5 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl shadow-sm hover:shadow transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                {{ ($product->inventory->stock ?? 0) <= 0 ? 'disabled' : '' }}>
            <span class="flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                </svg>
                Add to Cart
            </span>
        </button>
    </form>
    
    <a href="/products" 
       class="sm:w-1/3 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3.5 px-4 rounded-xl transition-colors border border-gray-200">
        Back
    </a>
</div>

                </div>
            </div>

        </div>
    </div>
</x-guest-layout>