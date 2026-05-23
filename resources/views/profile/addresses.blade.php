<x-app-layout>
    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">My Addresses</h2>
                    <p class="text-gray-500 text-sm mt-1">Manage your saved addresses for faster checkout</p>
                </div>
                <a href="#" class="inline-flex items-center bg-neutral-900 hover:bg-neutral-800 text-white font-medium px-5 py-2.5 rounded-xl text-sm transition gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add New Address
                </a>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
                <div class="text-center py-20 px-6">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-orange-50 mb-5">
                        <svg class="w-10 h-10 text-orange-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">No addresses saved yet</h3>
                    <p class="text-sm text-gray-400 max-w-sm mx-auto mb-6">Add your first address to make checkout faster and easier. Your addresses will appear here.</p>
                    <a href="#" class="inline-flex items-center bg-orange-500 hover:bg-orange-600 text-white font-medium px-6 py-2.5 rounded-xl text-sm transition gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Add Your First Address
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>