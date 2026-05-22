<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Profile
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Account Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <p class="text-sm text-gray-500">Name</p>
                        <p class="text-gray-900 font-medium">{{ auth()->user()->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="text-gray-900 font-medium">{{ auth()->user()->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Member since</p>
                        <p class="text-gray-900 font-medium">{{ auth()->user()->created_at->format('M d, Y') }}</p>
                    </div>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('profile.edit') }}" class="btn-primary inline-block text-center px-6 py-2 rounded-xl text-sm w-auto">
                        Edit Profile
                    </a>
                    <a href="{{ route('profile.addresses') }}" class="inline-block text-center px-6 py-2 rounded-xl text-sm border border-gray-300 text-gray-700 hover:bg-gray-50 transition">
                        Manage Addresses
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>