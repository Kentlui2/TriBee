@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">

    <h1 class="text-2xl font-semibold text-gray-800 mb-6">My Profile</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 rounded-lg px-4 py-3 mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-semibold text-xl">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
            </div>
        </div>
        <div class="border-t pt-4 text-sm text-gray-600 space-y-2">
            <div class="flex justify-between">
                <span class="text-gray-400">Role</span>
                <span class="capitalize">{{ $user->role ?? 'customer' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-400">Member since</span>
                <span>{{ $user->created_at->format('F j, Y') }}</span>
            </div>
        </div>
    </div>

    <div class="flex gap-3">
    <a href="{{ route('profile.edit') }}"
       class="bg-gray-800 text-white px-5 py-2 rounded-lg text-sm hover:bg-gray-700">
        Edit Profile
    </a>
    <a href="{{ route('profile.addresses') }}"
       class="bg-white border border-gray-300 text-gray-700 px-5 py-2 rounded-lg text-sm hover:bg-gray-50">
        My Addresses
    </a>
</div>

</div>
@endsection