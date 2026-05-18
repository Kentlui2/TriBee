<x-guest-layout>
    <h1 class="text-2xl font-bold text-gray-900 mb-1">Create your account</h1>
    <p class="text-gray-500 text-sm mb-7">Join TriBee and start shopping smarter</p>

    <form id="registerForm" action="{{ route('register') }}" method="POST" novalidate>
        @csrf

        {{-- Name --}} {{-- G1 - Member 1: Frontend Auth UI DENZON --}}
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-900 mb-1.5">Full name</label>
            <input
                id="name" name="name" type="text"
                value="{{ old('name') }}"
                placeholder="Juan dela Cruz"
                class="input-field {{ $errors->has('name') ? 'error' : '' }}"
            >
            <p id="name-error" class="error-msg mt-1.5 text-xs text-red-500 hidden"></p>
            @error('name') <p class="error-msg mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- Email --}}
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
                    placeholder="Min. 8 characters"
                    class="input-field pr-11"
                >
                <button type="button" id="togglePwd" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-orange-500 transition-colors">
                    <svg id="eyeOpen1" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg id="eyeClosed1" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                </button>
            </div>
            <div class="mt-2 flex gap-1">
                <div class="flex-1 bg-gray-100 rounded-full overflow-hidden h-1"><div id="bar1" class="strength-bar h-full w-0"></div></div>
                <div class="flex-1 bg-gray-100 rounded-full overflow-hidden h-1"><div id="bar2" class="strength-bar h-full w-0"></div></div>
                <div class="flex-1 bg-gray-100 rounded-full overflow-hidden h-1"><div id="bar3" class="strength-bar h-full w-0"></div></div>
                <div class="flex-1 bg-gray-100 rounded-full overflow-hidden h-1"><div id="bar4" class="strength-bar h-full w-0"></div></div>
            </div>
            <p id="strength-label" class="mt-1 text-xs text-gray-400"></p>
            <p id="password-error" class="error-msg mt-1.5 text-xs text-red-500 hidden"></p>
        </div>

        {{-- Confirm Password --}}
        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-900 mb-1.5">Confirm password</label>
            <div class="relative">
                <input
                    id="password_confirmation" name="password_confirmation" type="password"
                    placeholder="Re-enter your password"
                    class="input-field pr-11"
                >
                <button type="button" id="toggleConfirm" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-orange-500 transition-colors">
                    <svg id="eyeOpen2" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg id="eyeClosed2" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                </button>
            </div>
            <p id="confirm-error" class="error-msg mt-1.5 text-xs text-red-500 hidden"></p>
        </div>

        {{-- Terms --}}
        <div class="flex items-start gap-2 mb-6">
            <input id="terms" name="terms" type="checkbox" class="mt-0.5 w-4 h-4 rounded border-gray-300 text-orange-500 focus:ring-orange-500 cursor-pointer">
            <label for="terms" class="text-sm text-gray-500 cursor-pointer select-none leading-relaxed">
                I agree to TriBee's
                <a href="#" class="text-orange-500 hover:underline font-medium">Terms of Service</a>
                and
                <a href="#" class="text-orange-500 hover:underline font-medium">Privacy Policy</a>
            </label>
        </div>
        <p id="terms-error" class="error-msg -mt-4 mb-4 text-xs text-red-500 hidden"></p>

        <button type="submit" class="btn-primary">Create Account</button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-500">
        Already have an account?
        <a href="{{ route('login') }}" class="text-orange-500 font-semibold hover:underline">Sign in</a>
    </p>

    @push('scripts')
    <script>
        // Eye toggles
        function setupToggle(btnId, inputId, openId, closedId) {
            document.getElementById(btnId).addEventListener('click', () => {
                const input  = document.getElementById(inputId);
                const isHide = input.type === 'password';
                input.type   = isHide ? 'text' : 'password';
                document.getElementById(openId).classList.toggle('hidden', isHide);
                document.getElementById(closedId).classList.toggle('hidden', !isHide);
            });
        }
        setupToggle('togglePwd', 'password', 'eyeOpen1', 'eyeClosed1');
        setupToggle('toggleConfirm', 'password_confirmation', 'eyeOpen2', 'eyeClosed2');

        // Password strength
        const pwdInput = document.getElementById('password');
        const bars = [1,2,3,4].map(n => document.getElementById('bar' + n));
        const strengthLabel = document.getElementById('strength-label');
        const levels = [
            { color: '#EF4444', label: 'Weak' },
            { color: '#F59E0B', label: 'Fair' },
            { color: '#3B82F6', label: 'Good' },
            { color: '#22C55E', label: 'Strong' },
        ];

        function getStrength(pwd) {
            let score = 0;
            if (pwd.length >= 8) score++;
            if (/[A-Z]/.test(pwd)) score++;
            if (/[0-9]/.test(pwd)) score++;
            if (/[^A-Za-z0-9]/.test(pwd)) score++;
            return score;
        }

        pwdInput.addEventListener('input', () => {
            const score = pwdInput.value ? getStrength(pwdInput.value) : 0;
            bars.forEach((bar, i) => {
                bar.style.width = i < score ? '100%' : '0%';
                bar.style.background = i < score ? levels[score - 1].color : '';
            });
            strengthLabel.textContent = score > 0 ? levels[score - 1].label : '';
            strengthLabel.style.color = score > 0 ? levels[score - 1].color : '';
        });

        // Validation
        function showError(inputEl, msgEl, msg) {
            if (inputEl) inputEl.classList.add('error');
            msgEl.textContent = msg;
            msgEl.classList.remove('hidden');
        }
        function clearError(inputEl, msgEl) {
            if (inputEl) inputEl.classList.remove('error');
            msgEl.classList.add('hidden');
        }

        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const confirmInput = document.getElementById('password_confirmation');
        const termsInput = document.getElementById('terms');
        const nameError = document.getElementById('name-error');
        const emailError = document.getElementById('email-error');
        const pwdError = document.getElementById('password-error');
        const confirmError = document.getElementById('confirm-error');
        const termsError = document.getElementById('terms-error');

        nameInput.addEventListener('blur', () => {
            nameInput.value.trim().length < 2
                ? showError(nameInput, nameError, 'Please enter your full name.')
                : clearError(nameInput, nameError);
        });
        emailInput.addEventListener('blur', () => {
            if (!emailInput.value.trim()) showError(emailInput, emailError, 'Email is required.');
            else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value.trim())) showError(emailInput, emailError, 'Enter a valid email address.');
            else clearError(emailInput, emailError);
        });
        confirmInput.addEventListener('blur', () => {
            pwdInput.value !== confirmInput.value
                ? showError(confirmInput, confirmError, 'Passwords do not match.')
                : clearError(confirmInput, confirmError);
        });
        [nameInput, emailInput, pwdInput, confirmInput].forEach((el, i) => {
            const errEl = [nameError, emailError, pwdError, confirmError][i];
            el.addEventListener('input', () => clearError(el, errEl));
        });

        // Submit
        const form = document.getElementById('registerForm');
        form.addEventListener('submit', (e) => {
            let valid = true;
            if (nameInput.value.trim().length < 2) { showError(nameInput, nameError, 'Please enter your full name.'); valid = false; }
            if (!emailInput.value.trim()) { showError(emailInput, emailError, 'Email is required.'); valid = false; }
            else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value.trim())) { showError(emailInput, emailError, 'Enter a valid email address.'); valid = false; }
            if (!pwdInput.value) { showError(pwdInput, pwdError, 'Password is required.'); valid = false; }
            else if (pwdInput.value.length < 8) { showError(pwdInput, pwdError, 'Password must be at least 8 characters.'); valid = false; }
            if (pwdInput.value !== confirmInput.value) { showError(confirmInput, confirmError, 'Passwords do not match.'); valid = false; }
            if (!termsInput.checked) { showError(null, termsError, 'You must agree to the Terms of Service.'); valid = false; }
            if (!valid) {
                e.preventDefault();
                form.classList.add('shake');
                form.addEventListener('animationend', () => form.classList.remove('shake'), { once: true });
            }
        });
    </script>
    @endpush
</x-guest-layout>