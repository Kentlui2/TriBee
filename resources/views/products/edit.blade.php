{{-- 
    View: Product Detail Page 
    Managed by: Member 1 (Frontend/Catalog UI) 
--}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - TriBee Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-[#F8F9FA] text-gray-800 antialiased min-h-screen">

    <div class="max-w-[800px] mx-auto p-4 sm:p-6 lg:p-8">
        <header class="flex justify-between items-center mb-8 pb-5 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="grid grid-cols-2 gap-0.5 w-6 h-6">
                    <span class="bg-[#212529] rounded-[4px]"></span>
                    <span class="bg-[#E65F2B] rounded-[4px]"></span>
                    <span class="bg-[#E65F2B] rounded-[4px]"></span>
                    <span class="bg-[#A3AED0] rounded-[4px]"></span>
                </div>
                <h1 class="text-xl font-black text-gray-950">TriBee <span class="text-orange-500">Edit Product</span></h1>
            </div>
            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-gray-900 text-white text-xs font-bold rounded-xl hover:bg-gray-800 transition no-underline inline-block">
                ← Back to Matrix
            </a>
        </header>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-6 sm:p-8">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" class="space-y-6 m-0">
                @csrf 
                @method('PUT') <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-wider mb-2">Product Name</label>
                        <input type="text" name="name" value="{{ $product->name }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-orange-500 text-sm font-semibold transition">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-wider mb-2">Brand</label>
                        <input type="text" name="brand" value="{{ $product->brand }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-orange-500 text-sm font-semibold transition">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-wider mb-2">Category</label>
                        <select name="category_id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-orange-500 text-sm font-semibold text-gray-600 transition">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-wider mb-2">Price (₱)</label>
                        <input type="number" step="0.01" name="price" value="{{ $product->price }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-orange-500 text-sm font-black transition">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-wider mb-2">Current Stock Level</label>
                        <input type="number" name="stock" value="{{ $product->inventory ? $product->inventory->stock : 0 }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-orange-500 text-sm font-bold transition" min="0">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-wider mb-2">Product Image Path / URL</label>
                        <input type="text" name="image" value="{{ $product->image }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-orange-500 text-sm font-semibold transition">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-wider mb-2">Product Description</label>
                        <textarea name="description" rows="4" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:outline-none focus:border-orange-500 text-sm font-semibold transition resize-none">{{ $product->description }}</textarea>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                    <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs rounded-xl transition no-underline inline-block">
                        Cancel
                    </a>
                    <button type="submit" class="px-5 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-bold text-xs rounded-xl transition shadow-xs cursor-pointer">
                        Update Product Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>