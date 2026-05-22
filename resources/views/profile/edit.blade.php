<x-app-layout>
    <div class="space-y-6">
        
        <!-- Profile Information -->
        <div class="bg-white rounded-2xl border border-gray-100 p-6 sm:p-8 shadow-sm">
            <h2 class="text-lg font-bold text-neutral-900 mb-1">Profile Information</h2>
            <p class="text-sm text-gray-500 mb-6">Update your account's profile information and email address.</p>
            @include('profile.partials.update-profile-information-form', ['user' => auth()->user()])
        </div>

        <!-- Update Password -->
        <div class="bg-white rounded-2xl border border-gray-100 p-6 sm:p-8 shadow-sm">
            <h2 class="text-lg font-bold text-neutral-900 mb-1">Update Password</h2>
            <p class="text-sm text-gray-500 mb-6">Ensure your account is using a long, random password to stay secure.</p>
            @include('profile.partials.update-password-form')
        </div>

        <!-- Delete Account -->
        <div class="bg-white rounded-2xl border border-red-100 p-6 sm:p-8 shadow-sm">
            <h2 class="text-lg font-bold text-red-600 mb-1">Delete Account</h2>
            <p class="text-sm text-gray-500 mb-6">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
            @include('profile.partials.delete-user-form')
        </div>

    </div>
</x-app-layout>