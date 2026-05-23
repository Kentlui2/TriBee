<x-guest-layout>
    <div class="w-full max-w-5xl mx-auto">
        <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 overflow-hidden border border-gray-100 grid grid-cols-1 lg:grid-cols-12">
            
            <!-- Left Panel -->
            <div class="lg:col-span-5 bg-gradient-to-br from-orange-500 to-amber-600 p-8 flex flex-col justify-between relative overflow-hidden rounded-[1.5rem] m-3">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_right,rgba(255,255,255,0.2),transparent_60%)] pointer-events-none"></div>
                
                <div class="relative z-10">
                    <h2 class="text-2xl font-extrabold text-white tracking-tight leading-tight mb-2">Join TriBee<br>Today.</h2>
                    <p class="text-orange-100/80 text-xs leading-relaxed max-w-xs">Create an account and start shopping smarter with our platform.</p>
                </div>

                <div class="relative z-10 flex items-end justify-center mt-4">
                    <div class="flex items-end gap-2">
                        <div class="w-14 h-20 bg-white/20 rounded-t-2xl rounded-b-lg flex items-center justify-center backdrop-blur">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div class="w-14 h-24 bg-white/25 rounded-t-2xl rounded-b-lg flex items-center justify-center backdrop-blur">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Panel -->
            <div class="lg:col-span-7 p-8 sm:p-10 flex flex-col justify-center">
                <div class="max-w-sm w-full mx-auto">
                    
                    <a href="/" class="inline-flex items-center gap-2 mb-5">
                        <div class="w-9 h-9 bg-orange-500 rounded-lg flex items-center justify-center">
                            <svg width="16" height="16" viewBox="0 0 36 36" fill="none">
                                <rect width="16" height="16" rx="4" fill="#fff"/>
                                <rect x="20" width="16" height="16" rx="4" fill="#fff" opacity="0.7"/>
                                <rect y="20" width="16" height="16" rx="4" fill="#fff" opacity="0.5"/>
                                <rect x="20" y="20" width="16" height="16" rx="4" fill="#111" opacity="0.3"/>
                            </svg>
                        </div>
                        <span class="text-lg font-extrabold text-gray-900 tracking-tight">Tri<span class="text-orange-500">Bee</span></span>
                    </a>

                    <h1 class="text-xl font-bold text-gray-900 mb-0.5">Create Account</h1>
                    <p class="text-gray-500 text-xs mb-5">Fill in your details to get started</p>

                    <form id="registerForm" action="{{ route('register') }}" method="POST" novalidate class="space-y-3">
                        @csrf

                        <div>
                            <label for="name" class="block text-xs font-medium text-gray-700 mb-1">Full Name</label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Juan dela Cruz" class="w-full rounded-xl bg-gray-50 border-0 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-orange-500/20 focus:bg-white focus:border-orange-500 transition {{ $errors->has('name') ? 'ring-2 ring-red-500/20 border-red-500' : '' }}">
                            <p id="name-error" class="mt-1 text-xs text-red-500 hidden"></p>
                            @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-xs font-medium text-gray-700 mb-1">Email Address</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="you@example.com" class="w-full rounded-xl bg-gray-50 border-0 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-orange-500/20 focus:bg-white focus:border-orange-500 transition {{ $errors->has('email') ? 'ring-2 ring-red-500/20 border-red-500' : '' }}">
                            <p id="email-error" class="mt-1 text-xs text-red-500 hidden"></p>
                            @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-xs font-medium text-gray-700 mb-1">Password</label>
                            <div class="relative">
                                <input id="password" name="password" type="password" placeholder="Min. 8 characters" class="w-full rounded-xl bg-gray-50 border-0 px-4 py-2.5 pr-10 text-sm text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-orange-500/20 focus:bg-white focus:border-orange-500 transition">
                                <button type="button" id="togglePwd" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                    <svg id="eyeOpen1" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg id="eyeClosed1" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                </button>
                            </div>
                            <div class="mt-1.5 flex gap-1">
                                <div class="flex-1 bg-gray-200 rounded-full h-1 overflow-hidden"><div id="bar1" class="strength-bar h-full w-0 transition-all duration-300"></div></div>
                                <div class="flex-1 bg-gray-200 rounded-full h-1 overflow-hidden"><div id="bar2" class="strength-bar h-full w-0 transition-all duration-300"></div></div>
                                <div class="flex-1 bg-gray-200 rounded-full h-1 overflow-hidden"><div id="bar3" class="strength-bar h-full w-0 transition-all duration-300"></div></div>
                                <div class="flex-1 bg-gray-200 rounded-full h-1 overflow-hidden"><div id="bar4" class="strength-bar h-full w-0 transition-all duration-300"></div></div>
                            </div>
                            <p id="strength-label" class="mt-1 text-xs font-medium"></p>
                            <p id="password-error" class="mt-1 text-xs text-red-500 hidden"></p>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-xs font-medium text-gray-700 mb-1">Confirm Password</label>
                            <div class="relative">
                                <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Re-enter password" class="w-full rounded-xl bg-gray-50 border-0 px-4 py-2.5 pr-10 text-sm text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-orange-500/20 focus:bg-white focus:border-orange-500 transition">
                                <button type="button" id="toggleConfirm" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                    <svg id="eyeOpen2" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg id="eyeClosed2" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                </button>
                            </div>
                            <p id="confirm-error" class="mt-1 text-xs text-red-500 hidden"></p>
                        </div>

                        <div class="flex items-start">
                            <input id="terms" name="terms" type="checkbox" class="mt-0.5 w-4 h-4 rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                            <label for="terms" class="ml-2 text-xs text-gray-500 cursor-pointer leading-snug">
                                I agree to TriBee's <a href="#" class="text-orange-500 font-medium hover:underline">Terms</a> and <a href="#" class="text-orange-500 font-medium hover:underline">Privacy Policy</a>
                            </label>
                        </div>
                        <p id="terms-error" class="text-xs text-red-500 hidden"></p>

                        <button type="submit" class="btn-primary w-full py-2.5 rounded-xl text-sm font-medium tracking-wide">Create Account</button>
                    </form>

                    <p class="mt-5 text-center text-xs text-gray-500">
                        Already have an account?
                        <a href="{{ route('login') }}" class="font-semibold text-orange-500 hover:underline">Sign in</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function setupToggle(btnId, inputId, openId, closedId) {
            document.getElementById(btnId).addEventListener('click', () => {
                const input = document.getElementById(inputId);
                const isHide = input.type === 'password';
                input.type = isHide ? 'text' : 'password';
                document.getElementById(openId).classList.toggle('hidden', isHide);
                document.getElementById(closedId).classList.toggle('hidden', !isHide);
            });
        }
        setupToggle('togglePwd', 'password', 'eyeOpen1', 'eyeClosed1');
        setupToggle('toggleConfirm', 'password_confirmation', 'eyeOpen2', 'eyeClosed2');

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

        function showError(inputEl, msgEl, msg) {
            if (inputEl) { inputEl.classList.add('ring-2','ring-red-500/20','border-red-500'); }
            msgEl.textContent = msg;
            msgEl.classList.remove('hidden');
        }
        function clearError(inputEl, msgEl) {
            if (inputEl) { inputEl.classList.remove('ring-2','ring-red-500/20','border-red-500'); }
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
            nameInput.value.trim().length < 2 ? showError(nameInput, nameError, 'Please enter your full name.') : clearError(nameInput, nameError);
        });
        emailInput.addEventListener('blur', () => {
            if (!emailInput.value.trim()) showError(emailInput, emailError, 'Email is required.');
            else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value.trim())) showError(emailInput, emailError, 'Enter a valid email address.');
            else clearError(emailInput, emailError);
        });
        confirmInput.addEventListener('blur', () => {
            pwdInput.value !== confirmInput.value ? showError(confirmInput, confirmError, 'Passwords do not match.') : clearError(confirmInput, confirmError);
        });
        [nameInput, emailInput, pwdInput, confirmInput].forEach((el, i) => {
            const errEl = [nameError, emailError, pwdError, confirmError][i];
            el.addEventListener('input', () => clearError(el, errEl));
        });

        document.getElementById('registerForm').addEventListener('submit', (e) => {
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
                document.getElementById('registerForm').classList.add('shake');
                document.getElementById('registerForm').addEventListener('animationend', function() { this.classList.remove('shake'); }, { once: true });
            }
        });
    </script>
    @endpush
</x-guest-layout>