<x-app-layout>
    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-orange-500 to-amber-500 rounded-2xl p-8 mb-6 shadow-lg shadow-orange-500/10">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-white">Welcome back, {{ auth()->user()->name }}!</h2>
                        <p class="text-orange-100 text-sm mt-1">Here's what's happening with your account today.</p>
                    </div>
                    <div class="hidden sm:block w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <a href="{{ route('profile.dashboard') }}" class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md hover:border-orange-200 transition group">
                    <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center mb-3 group-hover:bg-orange-200 transition">
                        <svg class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <h3 class="font-semibold text-gray-900">My Profile</h3>
                    <p class="text-gray-500 text-xs mt-1">View and manage your account</p>
                </a>

                <a href="{{ route('profile.addresses') }}" class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md hover:border-orange-200 transition group">
                    <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center mb-3 group-hover:bg-orange-200 transition">
                        <svg class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="font-semibold text-gray-900">Addresses</h3>
                    <p class="text-gray-500 text-xs mt-1">Manage your saved addresses</p>
                </a>

                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md hover:border-orange-200 transition group cursor-pointer">
                    <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center mb-3 group-hover:bg-orange-200 transition">
                        <svg class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                    <h3 class="font-semibold text-gray-900">My Orders</h3>
                    <p class="text-gray-500 text-xs mt-1">Track your recent purchases</p>
                </div>
            </div>

            <!-- Activity / Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <h3 class="font-semibold text-gray-900 mb-4">Recent Activity</h3>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Account created</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Profile setup complete</p>
                                <p class="text-xs text-gray-500">Ready to start shopping</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <h3 class="font-semibold text-gray-900 mb-4">Account Overview</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Orders</span>
                            <span class="text-sm font-semibold text-gray-900">0</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Saved Addresses</span>
                            <span class="text-sm font-semibold text-gray-900">0</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Wishlist Items</span>
                            <span class="text-sm font-semibold text-gray-900">0</span>
                        </div>
                        <div class="flex justify-between items-center pt-3 border-t border-gray-100">
                            <span class="text-sm text-gray-500">Member Since</span>
                            <span class="text-sm font-semibold text-gray-900">{{ auth()->user()->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>