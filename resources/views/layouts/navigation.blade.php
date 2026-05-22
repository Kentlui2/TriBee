<nav x-data="{ open: false, profileOpen: false }" class="bg-white border-b border-gray-100 sticky top-0 z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-14">
            
            <!-- Left: Logo + Nav -->
            <div class="flex items-center gap-6">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 shrink-0 group">
                    <div class="w-8 h-8 bg-[#F97316] rounded-lg flex items-center justify-center group-hover:scale-105 transition-transform">
                        <svg width="15" height="15" viewBox="0 0 36 36" fill="none">
                            <rect width="15" height="15" rx="3" fill="#fff"/>
                            <rect x="18" width="15" height="15" rx="3" fill="#fff" opacity="0.7"/>
                            <rect y="18" width="15" height="15" rx="3" fill="#fff" opacity="0.5"/>
                            <rect x="18" y="18" width="15" height="15" rx="3" fill="#111" opacity="0.2"/>
                        </svg>
                    </div>
                    <span class="text-lg font-extrabold tracking-tight text-[#1a1a1a]">Tri<span class="text-[#F97316]">Bee</span></span>
                </a>

                <div class="hidden sm:flex items-center gap-0.5">
                    <a href="{{ route('products.index') }}" 
                       class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors flex items-center gap-1.5
                              {{ request()->routeIs('products.*') ? 'text-[#F97316]' : 'text-gray-500 hover:text-gray-900' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                        </svg>
                        Products
                    </a>
                    <a href="{{ route('cart.index') }}" 
                       class="relative px-3 py-1.5 text-sm font-medium rounded-lg transition-colors flex items-center gap-1.5
                              {{ request()->routeIs('cart.*') ? 'text-[#F97316]' : 'text-gray-500 hover:text-gray-900' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                        </svg>
                        Cart
                        @if(isset($cartItemCount) && $cartItemCount > 0)
                            <span class="absolute -top-0.5 -right-1 inline-flex items-center justify-center min-w-[15px] h-[15px] px-[3px] text-[9px] font-bold text-white bg-[#F97316] rounded-full leading-none">
                                {{ $cartItemCount }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>

            <!-- Right: Profile Dropdown -->
            <div class="hidden sm:flex items-center">
                <div class="relative" x-data="{ profileOpen: false }">
                    <button @click="profileOpen = !profileOpen" class="flex items-center gap-2 p-1 rounded-lg hover:bg-gray-50 transition">
                        <div class="w-7 h-7 rounded-full bg-gradient-to-br from-[#F97316] to-orange-400 flex items-center justify-center text-white text-[11px] font-bold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                        </svg>
                    </button>

                    <!-- Dropdown -->
                    <div x-show="profileOpen" 
                         @click.away="profileOpen = false"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50"
                         style="display: none;">
                        
                        <div class="px-4 py-3 border-b border-gray-50">
                            <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ Auth::user()->email }}</p>
                        </div>
                        
                        <a href="{{ route('profile.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 transition">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                            </svg>
                            Profile Settings
                        </a>
                        
                        <hr class="my-1 border-gray-50">
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-500 hover:bg-red-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                                </svg>
                                Log out
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Mobile -->
            <div class="sm:hidden">
                <button @click="open = !open" class="p-2 -mr-2 rounded-lg text-gray-400 hover:text-gray-600 transition">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path :class="{'hidden': open, 'block': !open}" stroke-linecap="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'block': open}" stroke-linecap="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" x-transition class="sm:hidden border-t border-gray-100 bg-white">
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('products.index') }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('products.*') ? 'text-[#F97316]' : 'text-gray-600' }}">🔍 Products</a>
            <a href="{{ route('cart.index') }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('cart.*') ? 'text-[#F97316]' : 'text-gray-600' }}">🛒 Cart</a>
            <div class="pt-2 mt-2 border-t border-gray-100">
                <p class="px-3 text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                <a href="{{ route('profile.dashboard') }}" class="block px-3 py-2 text-sm text-gray-500">Profile Settings</a>
                <form method="POST" action="{{ route('logout') }}" class="mt-1">
                    @csrf
                    <button class="w-full text-left px-3 py-2 text-sm text-red-500 font-medium">Log out</button>
                </form>
            </div>
        </div>
    </div>
</nav>