<x-guest-layout>
    <h1 class="text-2xl font-bold text-gray-900 mb-1">Welcome back</h1>
    <p class="text-gray-500 text-sm mb-7">Sign in to your TriBee account</p>

    @if(session('error'))
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-600 error-msg">
            {{ session('error') }}
        </div>
    @endif

    <form id="loginForm" action="{{ route('login') }}" method="POST" novalidate>
        @csrf

        {{-- Email --}} {{-- G1 - Member 1: Frontend Auth UI DENZON --}}
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-900 mb-1.5">Email address</label>
            <input
                id="email" name="email" type="email"
                value="{{ old('email') }}"
                placeholder="you@example.com"
                class="input-field {{ $errors->has('email') ? 'error' : '' }}"
            >
            <p id="email-error" class="error-msg mt-1.5 text-xs text-red-500 hidden"></p>
            @error('email') <p class="error-msg mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- Password --}}
        <div class="mb-4">
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

        {{-- Remember + Forgot --}}
        <div class="flex items-center justify-between mb-6">
            <label class="flex items-center gap-2 cursor-pointer select-none">
                <input id="remember" name="remember" type="checkbox" class="w-4 h-4 rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                <span class="text-sm text-gray-500">Remember me</span>
            </label>
            <a href="{{ route('password.request') }}" class="text-sm text-orange-500 hover:underline font-medium">Forgot password?</a>
        </div>

        <button type="submit" class="btn-primary">Sign In</button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-500">
        Don't have an account?
        <a href="{{ route('register') }}" class="text-orange-500 font-semibold hover:underline">Create one</a>
    </p>

    @push('scripts')
    <script>
        // Eye toggle
        document.getElementById('togglePwd').addEventListener('click', () => {
            const input = document.getElementById('password');
            const isHide = input.type === 'password';
            input.type = isHide ? 'text' : 'password';
            document.getElementById('eyeOpen').classList.toggle('hidden', isHide);
            document.getElementById('eyeClosed').classList.toggle('hidden', !isHide);
        });

        function showError(inputEl, msgEl, msg) {
            if (inputEl) inputEl.classList.add('error');
            msgEl.textContent = msg;
            msgEl.classList.remove('hidden');
        }
        function clearError(inputEl, msgEl) {
            if (inputEl) inputEl.classList.remove('error');
            msgEl.classList.add('hidden');
        }

        const emailInput = document.getElementById('email');
        const pwdInput = document.getElementById('password');
        const emailError = document.getElementById('email-error');
        const pwdError = document.getElementById('password-error');

        emailInput.addEventListener('blur', () => {
            if (!emailInput.value.trim()) showError(emailInput, emailError, 'Email is required.');
            else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value.trim())) showError(emailInput, emailError, 'Enter a valid email address.');
            else clearError(emailInput, emailError);
        });
        [emailInput, pwdInput].forEach((el, i) => {
            const errEl = [emailError, pwdError][i];
            el.addEventListener('input', () => clearError(el, errEl));
        });

        const form = document.getElementById('loginForm');
        form.addEventListener('submit', (e) => {
            let valid = true;
            if (!emailInput.value.trim()) { showError(emailInput, emailError, 'Email is required.'); valid = false; }
            else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value.trim())) { showError(emailInput, emailError, 'Enter a valid email address.'); valid = false; }
            if (!pwdInput.value) { showError(pwdInput, pwdError, 'Password is required.'); valid = false; }
            if (!valid) {
                e.preventDefault();
                form.classList.add('shake');
                form.addEventListener('animationend', () => form.classList.remove('shake'), { once: true });
            }
        });
    </script>
    @endpush
</x-guest-layout>