<form method="post" action="{{ route('profile.update') }}" class="space-y-5">
    @csrf
    @method('patch')

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-sm font-medium text-gray-700 mb-1.5" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500/20 focus:bg-white transition" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-1.5" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-gray-700 mb-1.5" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500/20 focus:bg-white transition" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-1.5" :messages="$errors->get('email')" />
        </div>
    </div>

    <div class="flex items-center gap-3 pt-2">
        <button type="submit" class="bg-neutral-900 hover:bg-neutral-800 text-white font-medium px-6 py-2.5 rounded-xl text-sm transition">
            Save Changes
        </button>
        <a href="{{ route('profile.dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium transition">Cancel</a>
    </div>
</form>