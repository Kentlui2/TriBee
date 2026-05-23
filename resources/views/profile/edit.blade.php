<x-app-layout>
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Page Header -->
            <div class="mb-2">
                <h2 class="text-2xl font-bold text-gray-900">Edit Profile</h2>
                <p class="text-gray-500 text-sm mt-1">Update your account settings and preferences</p>
            </div>
        
            <!-- Profile Information -->
            <div class="bg-white rounded-2xl border border-gray-100 p-6 sm:p-8 shadow-sm">
                <h3 class="text-base font-semibold text-gray-900 mb-1">Profile Information</h3>
                <p class="text-sm text-gray-500 mb-6">Update your account's profile information and email address.</p>
                @include('profile.partials.update-profile-information-form', ['user' => auth()->user()])
            </div>

            <!-- Update Password -->
            <div class="bg-white rounded-2xl border border-gray-100 p-6 sm:p-8 shadow-sm">
                <h3 class="text-base font-semibold text-gray-900 mb-1">Update Password</h3>
                <p class="text-sm text-gray-500 mb-6">Ensure your account is using a long, random password to stay secure.</p>
                @include('profile.partials.update-password-form')
            </div>

            <!-- Delete Account -->
            <div class="bg-white rounded-2xl border border-red-100 p-6 sm:p-8 shadow-sm">
                <h3 class="text-base font-semibold text-red-600 mb-1">Delete Account</h3>
                <p class="text-sm text-gray-500 mb-6">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
                @include('profile.partials.delete-user-form')
            </div>

        </div>
    </div>
</x-app-layout>