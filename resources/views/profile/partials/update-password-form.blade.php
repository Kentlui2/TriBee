<form method="post" action="{{ route('password.update') }}" class="space-y-5">
    @csrf
    @method('put')

    <div>
        <x-input-label for="current_password" :value="__('Current Password')" class="text-sm font-medium text-gray-700 mb-1.5" />
        <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500/20 focus:bg-white transition" autocomplete="current-password" />
        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1.5" />
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div>
            <x-input-label for="password" :value="__('New Password')" class="text-sm font-medium text-gray-700 mb-1.5" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500/20 focus:bg-white transition" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1.5" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-sm font-medium text-gray-700 mb-1.5" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500/20 focus:bg-white transition" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1.5" />
        </div>
    </div>

    <div class="flex items-center gap-3 pt-2">
        <button type="submit" class="bg-neutral-900 hover:bg-neutral-800 text-white font-medium px-6 py-2.5 rounded-xl text-sm transition">
            Update Password
        </button>
        <a href="{{ route('profile.dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium transition">Cancel</a>
    </div>
</form>