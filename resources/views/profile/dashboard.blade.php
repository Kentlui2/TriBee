<x-app-layout>
    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900">My Profile</h2>
                <p class="text-gray-500 text-sm mt-1">Manage your account information and preferences</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Account Card -->
                <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 p-6 sm:p-8 shadow-sm">
                    <h3 class="text-base font-semibold text-gray-900 mb-6">Account Information</h3>
                    
                    <div class="flex items-center gap-4 mb-8 pb-8 border-b border-gray-100">
                        <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center text-2xl font-bold text-orange-600 shrink-0">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-lg font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Full Name</p>
                            <p class="text-base font-medium text-gray-900">{{ auth()->user()->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Email Address</p>
                            <p class="text-base font-medium text-gray-900">{{ auth()->user()->email }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Member Since</p>
                            <p class="text-base font-medium text-gray-900">{{ auth()->user()->created_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Password</p>
                            <p class="text-base font-medium text-gray-900">••••••••</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3 mt-8 pt-6 border-t border-gray-100">
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center bg-orange-500 hover:bg-orange-600 text-white font-medium px-5 py-2.5 rounded-xl text-sm transition">
                            Edit Profile
                        </a>
                        <a href="{{ route('profile.addresses') }}" class="inline-flex items-center border border-gray-200 hover:border-gray-300 text-gray-600 hover:bg-gray-50 font-medium px-5 py-2.5 rounded-xl text-sm transition">
                            Manage Addresses
                        </a>
                    </div>
                </div>

                <!-- Sidebar Stats -->
                <div class="space-y-4">
                    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                        <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        </div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Orders</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">0</p>
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Saved Addresses</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">0</p>
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                        <div class="w-10 h-10 bg-pink-100 rounded-xl flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Wishlist</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">0</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>