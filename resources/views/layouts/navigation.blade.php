<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 sticky top-0 z-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between h-16">
            
            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 shrink-0">
                <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center">
                    <svg width="16" height="16" viewBox="0 0 36 36" fill="none">
                        <rect width="16" height="16" rx="3" fill="#fff"/>
                        <rect x="20" width="16" height="16" rx="3" fill="#fff" opacity="0.6"/>
                        <rect y="20" width="16" height="16" rx="3" fill="#fff" opacity="0.4"/>
                        <rect x="20" y="20" width="16" height="16" rx="3" fill="#111" opacity="0.25"/>
                    </svg>
                </div>
                <span class="text-lg font-extrabold tracking-tight">Tri<span class="text-orange-500">Bee</span></span>
            </a>

            <!-- Desktop Links -->
            <div class="hidden sm:flex items-center gap-1">
                <a href="{{ route('dashboard') }}" class="px-3.5 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-orange-50 text-orange-600' : 'text-gray-600 hover:text-neutral-900 hover:bg-gray-100' }}">
                    Dashboard
                </a>
                <a href="{{ route('profile.dashboard') }}" class="px-3.5 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('profile.dashboard') ? 'bg-orange-50 text-orange-600' : 'text-gray-600 hover:text-neutral-900 hover:bg-gray-100' }}">
                    Profile
                </a>
                <a href="{{ route('profile.addresses') }}" class="px-3.5 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('profile.addresses') ? 'bg-orange-50 text-orange-600' : 'text-gray-600 hover:text-neutral-900 hover:bg-gray-100' }}">
                    Addresses
                </a>
            </div>

            <!-- User Dropdown -->
            <div class="hidden sm:flex items-center shrink-0">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 px-2 py-2 rounded-lg text-sm text-gray-700 hover:bg-gray-100 transition">
                            <div class="w-7 h-7 rounded-full bg-orange-100 flex items-center justify-center text-xs font-bold text-orange-600">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="font-medium">{{ Auth::user()->name }}</span>
                            <svg class="fill-current h-3 w-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.dashboard')">My Profile</x-dropdown-link>
                        <x-dropdown-link :href="route('profile.edit')">Edit Profile</x-dropdown-link>
                        <x-dropdown-link :href="route('profile.addresses')">Addresses</x-dropdown-link>
                        <hr class="my-1 border-gray-100">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Hamburger -->
            <div class="sm:hidden">
                <button @click="open = ! open" class="p-2 rounded-md text-gray-500 hover:text-orange-600 hover:bg-orange-50">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path :class="{'hidden': open, 'block': ! open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'block': open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-200">
        <div class="px-4 pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-orange-50 text-orange-600' : 'text-gray-600' }}">Dashboard</a>
            <a href="{{ route('profile.dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('profile.dashboard') ? 'bg-orange-50 text-orange-600' : 'text-gray-600' }}">Profile</a>
            <a href="{{ route('profile.addresses') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('profile.addresses') ? 'bg-orange-50 text-orange-600' : 'text-gray-600' }}">Addresses</a>
        </div>
        <div class="px-4 py-3 border-t border-gray-200">
            <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button class="text-sm text-red-500 font-medium">Log Out</button>
            </form>
        </div>
    </div>
</nav>