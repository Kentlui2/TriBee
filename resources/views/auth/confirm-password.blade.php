<x-guest-layout>
    <h1 class="text-2xl font-bold text-gray-900 mb-1">Confirm password</h1>
    <p class="text-gray-500 text-sm mb-7">This is a secure area. Please confirm your password before continuing.</p>

    <form id="confirmForm" action="{{ route('password.confirm') }}" method="POST" novalidate>
        @csrf
{{-- G1 - Member 1: Frontend Auth UI DENZON --}}
        <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-gray-900 mb-1.5">Password</label>
            <div class="relative">
                <input
                    id="password" name="password" type="password"
                    placeholder="Enter your password"
                    class="input-field pr-11 {{ $errors->has('password') ? 'error' : '' }}"
                >
                <button type="button" id="togglePwd" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-orange-500 transition-colors">
                    <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                </button>
            </div>
            <p id="password-error" class="error-msg mt-1.5 text-xs text-red-500 hidden"></p>
            @error('password') <p class="error-msg mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="btn-primary">Confirm</button>
    </form>

    @push('scripts')
    <script>
        document.getElementById('togglePwd').addEventListener('click', () => {
            const input = document.getElementById('password');
            const isHide = input.type === 'password';
            input.type = isHide ? 'text' : 'password';
            document.getElementById('eyeOpen').classList.toggle('hidden', isHide);
            document.getElementById('eyeClosed').classList.toggle('hidden', !isHide);
        });

        const pwdInput = document.getElementById('password');
        const pwdError = document.getElementById('password-error');

        pwdInput.addEventListener('input', () => {
            pwdInput.classList.remove('error');
            pwdError.classList.add('hidden');
        });

        document.getElementById('confirmForm').addEventListener('submit', (e) => {
            if (!pwdInput.value) {
                pwdInput.classList.add('error');
                pwdError.textContent = 'Password is required.';
                pwdError.classList.remove('hidden');
                e.preventDefault();
            }
        });
    </script>
    @endpush
</x-guest-layout>