@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="space-y-6">
    
    <!-- Account Information Card -->
    <div class="bg-white rounded-2xl border border-gray-100 p-6 sm:p-8 shadow-sm">
        <h2 class="text-lg font-bold text-neutral-900 mb-6">Account Information</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Name</p>
                <p class="text-base font-medium text-neutral-800">{{ auth()->user()->name }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Email</p>
                <p class="text-base font-medium text-neutral-800">{{ auth()->user()->email }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Member Since</p>
                <p class="text-base font-medium text-neutral-800">{{ auth()->user()->created_at->format('M d, Y') }}</p>
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

</div>
@endsection