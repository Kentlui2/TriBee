@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">

    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Edit Profile</h1>

    <!-- Update name and email -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
        <h2 class="font-medium text-gray-700 mb-4">Account Information</h2>
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Name</label>
                <input type="text" name="name"
                       value="{{ old('name', $user->name) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Email</label>
                <input type="email" name="email"
                       value="{{ old('email', $user->email) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit"
                    class="bg-gray-800 text-white px-5 py-2 rounded-lg text-sm hover:bg-gray-700">
                Save Changes
            </button>
        </form>
    </div>

    <!-- Change password -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h2 class="font-medium text-gray-700 mb-4">Change Password</h2>
        <form action="{{ route('profile.password') }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Current Password</label>
                <input type="password" name="current_password"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                @error('current_password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">New Password</label>
                <input type="password" name="password"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
            </div>
            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Confirm New Password</label>
                <input type="password" name="password_confirmation"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit"
                    class="bg-gray-800 text-white px-5 py-2 rounded-lg text-sm hover:bg-gray-700">
                Update Password
            </button>
        </form>
    </div>

    <a href="{{ route('profile.dashboard') }}" class="inline-block mt-4 text-sm text-gray-500 hover:underline">
        ← Back to profile
    </a>

</div>
@endsection