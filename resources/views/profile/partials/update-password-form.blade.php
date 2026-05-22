<form method="post" action="{{ route('password.update') }}" class="space-y-5">
    @csrf
    @method('put')

    <div>
        <x-input-label for="current_password" :value="__('Current Password')" class="text-sm font-medium text-neutral-700" />
        <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full rounded-xl border-gray-200 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500/20 transition" autocomplete="current-password" />
        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="password" :value="__('New Password')" class="text-sm font-medium text-neutral-700" />
        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full rounded-xl border-gray-200 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500/20 transition" autocomplete="new-password" />
        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-sm font-medium text-neutral-700" />
        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full rounded-xl border-gray-200 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500/20 transition" autocomplete="new-password" />
        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
    </div>

    <button type="submit" class="bg-neutral-900 hover:bg-neutral-800 text-white font-medium px-6 py-2.5 rounded-xl text-sm transition">
        Save
    </button>
</form>