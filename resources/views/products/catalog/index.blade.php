@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="flex flex-col lg:flex-row gap-8 items-start">

    <aside class="w-full lg:w-56 shrink-0">
        <div class="mb-6">
    <form action="{{ route('products.index') }}" method="GET" class="relative max-w-md">
        @if(request('category_id'))
            <input type="hidden" name="category_id" value="{{ request('category_id') }}">
        @endif
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." 
               class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:border-orange-500 focus:ring-orange-500/20 transition">
    </form>
</div>
        <h2 class="text-base font-black text-gray-900 tracking-tight mb-4">Categories</h2>
        <ul class="space-y-1.5">
            <li>
                <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition {{ !request('category_id') ? 'bg-white text-gray-900 shadow-xs border border-gray-100' : 'text-gray-500 hover:text-gray-900 hover:bg-white/50' }}">
                    <div class="w-7 h-7 rounded-lg bg-orange-500 text-white flex items-center justify-center font-bold text-[11px] shrink-0">All</div>
                    <span>All Products</span>
                </a>
            </li>
            @foreach($categories as $cat)
                <li>
                    <a href="{{ route('products.index', ['category_id' => $cat->id]) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition {{ request('category_id') == $cat->id ? 'bg-white text-gray-900 shadow-xs' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                        <div class="w-7 h-7 rounded-lg bg-gray-100 overflow-hidden shrink-0 flex items-center justify-center border border-gray-100">
                            @if(isset($cat->image_url) && $cat->image_url)
                                <img src="{{ $cat->image_url }}" alt="{{ $cat->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-[10px] text-gray-400">📦</span>
                            @endif
                        </div>
                        <span>{{ $cat->name }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </aside>

    <section class="flex-1 w-full">
        @if(!request('search') && !request('category_id'))
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
                <div class="md:col-span-2 bg-gradient-to-r from-purple-50 to-blue-50 border border-white rounded-2xl p-6 relative flex items-center justify-between min-h-[200px] shadow-xs">
                    <div class="max-w-[50%] z-10">
                        <span class="text-xs font-black text-orange-500 uppercase tracking-widest">Limited Deal</span>
                        <h2 class="text-3xl font-extrabold text-gray-900 mt-2 leading-tight">BIG SALE!</h2>
                        <p class="text-[11px] text-gray-500 mt-1 leading-relaxed">Wireless headphones with noise canceling technology.</p>
                        <button class="mt-4 px-5 py-2 text-xs font-bold text-white bg-orange-500 rounded-full hover:bg-orange-600 transition shadow-xs cursor-pointer">Shop Now</button>
                    </div>
                    <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=300&q=80" alt="Headphones" class="w-40 h-40 object-contain drop-shadow-xl absolute right-4 mix-blend-multiply">
                </div>
                <div class="bg-gradient-to-br from-orange-50 to-pink-50 border border-white rounded-2xl p-6 flex flex-col justify-between min-h-[200px] shadow-xs relative overflow-hidden">
                    <h3 class="text-base font-black text-gray-900 leading-snug">Get up to <span class="text-orange-500">20% OFF</span> Tech Accessories</h3>
                    <div class="bg-white/80 backdrop-blur-xs border border-gray-100 p-3 rounded-xl flex items-center justify-between mt-4">
                        <div>
                            <h4 class="text-xs font-bold text-gray-800">Instax Cam</h4>
                            <button class="text-[9px] px-2.5 py-1 bg-gray-900 text-white rounded-full font-bold mt-1 hover:bg-gray-800 transition cursor-pointer">Shop</button>
                        </div>
                        <img src="https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?auto=format&fit=crop&w=100&q=80" alt="Camera" class="w-12 h-12 object-contain mix-blend-multiply">
                    </div>
                </div>
            </div>
        @endif

        <div class="mb-6">
            <h3 class="text-lg font-black text-gray-900 tracking-tight">
                @if(request('search'))
                    Search results for "{{ request('search') }}"
                @elseif(request('category_id'))
                    Filtered Department Inventory
                @else
                    Explore popular products
                @endif
            </h3>
        </div>

        @if($products->isEmpty())
            <div class="bg-white rounded-2xl border border-dashed border-gray-200 py-16 text-center shadow-xs">
                <p class="text-sm text-gray-400 font-medium">No items found matching the selected filters.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                @foreach($products as $product)
                    <div class="bg-white border border-gray-100 rounded-2xl p-4 flex flex-col justify-between hover:shadow-md hover:border-gray-200 transition duration-300 relative group shadow-xs">
                        @if($product->inventory && $product->inventory->stock <= 5 && $product->inventory->stock > 0)
                            <span class="absolute top-3 left-3 z-10 bg-red-50 border border-red-100 text-red-600 font-black text-[9px] px-2 py-0.5 rounded-md uppercase tracking-wider">Low Stock</span>
                        @endif
                        <div class="bg-[#F8F9FA] rounded-xl aspect-square flex items-center justify-center p-4 relative overflow-hidden mb-4">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="max-h-32 object-contain group-hover:scale-105 transition duration-300 drop-shadow-xs">
                        </div>
                        <div class="flex-1 flex flex-col justify-between">
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 line-clamp-1 group-hover:text-orange-500 transition">{{ $product->name }}</h4>
                                <p class="text-[10px] text-gray-400 font-bold mt-0.5 uppercase tracking-wider">{{ $product->brand ?? 'TRIBEE' }}</p>
                            </div>
                            <div class="mt-4 pt-3 border-t border-gray-50 flex flex-col gap-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-base font-black text-gray-900">₱{{ number_format($product->price, 2) }}</span>
                                    <span class="text-[11px] text-gray-400 font-medium">{{ $product->inventory ? $product->inventory->stock . ' left' : 'Out of Stock' }}</span>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="w-full">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="w-full py-2.5 bg-orange-500 hover:bg-orange-600 active:scale-[0.98] text-white text-xs font-bold rounded-xl shadow-xs transition duration-200 cursor-pointer flex items-center justify-center gap-1 {{ $product->inventory && $product->inventory->stock > 0 ? '' : 'opacity-40 cursor-not-allowed' }}" {{ $product->inventory && $product->inventory->stock > 0 ? '' : 'disabled' }}>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                                        </svg>
                                        {{ $product->inventory && $product->inventory->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
</div>
@endsection
