 {{-- 
    View: Product Detail Page 
    Managed by: Member 1 Billiones (Frontend/Catalog UI) 
--}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TriBee Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#F8F9FA] text-gray-800 antialiased min-h-screen">

    <div class="max-w-[1400px] mx-auto p-4 sm:p-6 lg:p-8">
        <header class="flex justify-between items-center mb-8 pb-5 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="grid grid-cols-2 gap-0.5 w-6 h-6">
                    <span class="bg-[#212529] rounded-[4px]"></span>
                    <span class="bg-[#E65F2B] rounded-[4px]"></span>
                    <span class="bg-[#E65F2B] rounded-[4px]"></span>
                    <span class="bg-[#A3AED0] rounded-[4px]"></span>
                </div>
                <h1 class="text-xl font-black text-gray-950">TriBee <span class="text-orange-500">Admin Control</span></h1>
            </div> <div class="flex items-center gap-4">                       <form action="{{ route('admin.products.index') }}" method="GET" class="relative w-full max-w-lg">
    <div class="relative">
        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </span>
       
        <input type="text" 
               name="search" nm
               value="{{ request('search') }}" 
               placeholder="Cari Barang..." 
               class="w-full pl-10 pr-4 py-3 bg-white border border-gray-200 rounded-full text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                 
            </div>
                </form>
                                
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = ! open" type="button" class="flex items-center gap-2 max-w-xs rounded-xl text-sm focus:outline-none p-1.5 bg-white border border-gray-200 shadow-sm transition hover:bg-gray-50 cursor-pointer">
                        <div class="w-7 h-7 bg-orange-500 rounded-lg flex items-center justify-center text-white font-black text-xs uppercase">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        <span class="text-xs font-bold text-gray-800 hidden sm:inline-block">
                            {{ Auth::user()->name }}
                        </span>
                        <svg class="w-3.5 h-3.5 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 origin-top-right rounded-xl bg-white py-1 shadow-xl ring-1 ring-black/5 focus:outline-none border border-gray-100 text-left z-50"
                         style="display: none;">
                         
                        <div class="px-4 py-2 border-b border-gray-100">
                           @if(Auth::user()->is_admin == 1 || (Auth::user()->role && Auth::user()->role->name === 'admin'))
                            <span class="text-xs font-semibold uppercase text-gray-400">Administrator</span>
                        @else
                            <span class="text-xs font-semibold uppercase text-red-500">Unauthorized Session</span>
                        @endif
                            <p class="text-xs font-bold text-gray-800 truncate">{{ Auth::user()->email }}</p>
                        </div>

                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 font-semibold no-underline">
                            Account Settings
                        </a>

                        <hr class="border-gray-100 my-1">

                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-red-50 font-bold cursor-pointer border-none bg-none">
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                <h2 class="text-base font-black text-gray-900">Product Inventory Matrix</h2>

                <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-orange-500 text-white text-xs font-bold rounded-xl hover:bg-orange-600 transition shadow-xs no-underline inline-block">
                    + Add New Product
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 text-xs font-black text-gray-400 uppercase bg-gray-50/30">
                            <th class="p-4 pl-6">Product Details</th>
                            <th class="p-4">Brand</th>
                            <th class="p-4">Price</th>
                            <th class="p-4">Stock Status</th>
                            <th class="p-4 text-center pr-6">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        @foreach($products as $product)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="p-4 pl-6">
                                <div class="font-bold text-gray-900">{{ $product->name }}</div>
                                <div class="text-[11px] text-gray-400 font-semibold mt-0.5">ID: #{{ $product->id }}</div>
                            </td>
                            <td class="p-4 font-semibold text-gray-600">{{ $product->brand }}</td>
                            <td class="p-4 font-black text-gray-900">₱{{ number_format($product->price, 2) }}</td>
                            <td class="p-4">
                                @if($product->inventory)
                                    @if($product->inventory->stock <= 5)
                                        <span class="px-2 py-1 bg-red-50 text-red-600 text-[10px] font-black rounded-md border border-red-100">LOW STOCK ({{ $product->inventory->stock }})</span>
                                    @else
                                        <span class="px-2 py-1 bg-green-50 text-green-600 text-[10px] font-black rounded-md border border-green-100">In Stock ({{ $product->inventory->stock }})</span>
                                    @endif
                                @else
                                    <span class="text-gray-400 text-xs">No Inventory Record</span>
                                @endif
                            </td>
                            <td class="p-4 text-center pr-6">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs rounded-lg transition no-underline inline-block">
                                        Edit
                                    </a>
                                    
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="color: red; cursor: pointer; border: none; background: none;">
                                        Delete
                                    </button>
                                </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 p-6 rounded-2xl mb-8">
        <h3 class="text-green-800 font-black mb-4">{{ session('success') }}</h3>
        
        @if($product = session('updated_product'))
            <div class="flex items-center gap-6">
                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-20 h-20 object-cover rounded-xl shadow-sm">
                
                <div>
                    <p class="font-bold text-gray-900">{{ $product->name }}</p>
                    <p class="text-xs text-gray-500 font-semibold">Brand: {{ $product->brand }}</p>
                    <p class="text-xs text-gray-500 font-semibold">Price: ₱{{ number_format($product->price, 2) }}</p>
                </div>
            </div>
        @endif
    </div>
@endif

    @push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addBtn = document.getElementById('openAddModalBtn');
        const modalContainer = document.getElementById('yourAddProductModalId'); 

        if(addBtn && modalContainer) {
            addBtn.addEventListener('click', function() {
                modalContainer.classList.remove('hidden'); 
            });
        }
    });
</script>
@endpush

</body>
</html>