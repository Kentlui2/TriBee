<x-guest-layout>    //billiones part
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8 border-b border-gray-200 pb-5">
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    TriBee <span class="text-orange-500">Product Catalog</span>
                </h1>
                <p class="mt-2 text-sm text-gray-500">
                    Browse through our active customer marketplace inventory.
                </p>
            </div>

            <div class="lg:grid lg:grid-cols-4 lg:gap-x-8">
                
                <div class="hidden lg:block bg-white p-6 rounded-lg shadow-sm border border-gray-100 h-fit">
                    <h2 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">
                        Filter Departments
                    </h2>
                    <ul class="space-y-3 text-sm font-medium text-gray-600">
                        <li>
                            <a href="/catalog" class="{{ !request('category_id') ? 'text-orange-500 font-bold' : '' }} hover:underline">
                                All Products
                            </a>
                        </li>
                        @foreach($categories as $category)
                            <li>
                                <a href="/catalog?category_id={{ $category->id }}" 
                                   class="{{ request('category_id') == $category->id ? 'text-orange-500 font-bold' : '' }} hover:text-orange-500 transition-colors">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="lg:col-span-3">
                    
                    <div class="mb-6">
                        <form action="/catalog" method="GET" class="flex gap-x-3">
                            @if(request('category_id'))
                                <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                            @endif
                            <input type="text" name="search" placeholder="Search for items (e.g., Keyboard)..." 
                                   value="{{ request('search') }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm p-3 border">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-orange-500 hover:bg-orange-600">
                                Search
                            </button>
                        </form>
                    </div>

                    <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
                        @forelse($products as $product)
                            <div class="group relative bg-white border border-gray-200 rounded-lg shadow-sm flex flex-col overflow-hidden">
                                <div class="aspect-w-3 aspect-h-4 bg-gray-200 group-hover:opacity-75 sm:aspect-none sm:h-48">
                                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=500' }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-center object-cover">
                                </div>
                                <div class="flex-1 p-4 flex flex-col justify-between">
                                    <div class="flex-1">
                                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">
                                            {{ $product->category?->name ?? 'Uncategorized' }}
                                        </p>
                                        <h3 class="text-sm font-semibold text-gray-900 mt-1">
                                            <a href="/catalog/{{ $product->id }}">
                                                <span aria-hidden="true" class="absolute inset-0"></span>
                                                {{ $product->name }}
                                            </a>
                                        </h3>
                                        <p class="text-sm text-gray-500 mt-2 line-clamp-2">
                                            {{ $product->description }}
                                        </p>
                                    </div>
                                    <div class="flex items-center justify-between mt-4 pt-3 border-t border-gray-100">
                                        <p class="text-lg font-bold text-gray-900">
                                            ₱{{ number_format($product->price, 2) }}
                                        </p>
                                        @if($product->inventory && $product->inventory->stock > 0)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                In Stock ({{ $product->inventory->stock }})
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Out of Stock
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full bg-white border border-dashed border-gray-300 rounded-lg p-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No Active Products Found</h3>
                                <p class="mt-1 text-sm text-gray-500">Insert row data models inside your database to populate this catalog display grid shelf.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-8">
                        {{ $products->appends(request()->query())->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-guest-layout>