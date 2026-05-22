<form method="post" action="{{ route('profile.update') }}" class="space-y-5">
    @csrf
    @method('patch')

    <div>
        <x-input-label for="name" :value="__('Name')" class="text-sm font-medium text-neutral-700" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full rounded-xl border-gray-200 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500/20 transition" :value="old('name', $user->name)" required autofocus autocomplete="name" />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    <div>
        <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-neutral-700" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full rounded-xl border-gray-200 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500/20 transition" :value="old('email', $user->email)" required autocomplete="username" />
        <x-input-error class="mt-2" :messages="$errors->get('email')" />
    </div>

    <button type="submit" class="bg-neutral-900 hover:bg-neutral-800 text-white font-medium px-6 py-2.5 rounded-xl text-sm transition">
        Save
    </button>
</form>