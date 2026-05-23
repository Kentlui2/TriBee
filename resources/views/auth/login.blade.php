<x-guest-layout>
    <div class="w-full max-w-5xl mx-auto">
        <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 overflow-hidden border border-gray-100 grid grid-cols-1 lg:grid-cols-12">
            
            <!-- Left Panel -->
            <div class="lg:col-span-5 bg-gradient-to-br from-orange-500 to-amber-600 p-10 flex flex-col justify-between relative overflow-hidden rounded-[1.5rem] m-3">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_right,rgba(255,255,255,0.2),transparent_60%)] pointer-events-none"></div>
                
                <div class="relative z-10">
                    <h2 class="text-3xl font-extrabold text-white tracking-tight leading-tight mb-3">Simplify shopping<br>With TriBee.</h2>
                    <p class="text-orange-100/80 text-sm leading-relaxed max-w-xs">Simplify your e-commerce experience with our user-friendly shopping platform.</p>
                </div>

                <div class="relative z-10 flex items-end justify-center mt-6">
                    <div class="flex items-end gap-3">
                        <div class="w-16 h-24 bg-white/20 rounded-t-2xl rounded-b-lg flex items-center justify-center backdrop-blur">
                            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div class="w-16 h-28 bg-white/25 rounded-t-2xl rounded-b-lg flex items-center justify-center backdrop-blur">
                            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Panel -->
            <div class="lg:col-span-7 p-10 sm:p-14 flex flex-col justify-center">
                <div class="max-w-sm w-full mx-auto">
                    
                    <a href="/" class="inline-flex items-center gap-2.5 mb-8">
                        <div class="w-10 h-10 bg-orange-500 rounded-xl flex items-center justify-center">
                            <svg width="18" height="18" viewBox="0 0 36 36" fill="none">
                                <rect width="16" height="16" rx="4" fill="#fff"/>
                                <rect x="20" width="16" height="16" rx="4" fill="#fff" opacity="0.7"/>
                                <rect y="20" width="16" height="16" rx="4" fill="#fff" opacity="0.5"/>
                                <rect x="20" y="20" width="16" height="16" rx="4" fill="#111" opacity="0.3"/>
                            </svg>
                        </div>
                        <span class="text-xl font-extrabold text-gray-900 tracking-tight">Tri<span class="text-orange-500">Bee</span></span>
                    </a>

                    <h1 class="text-2xl font-bold text-gray-900 mb-1">Welcome Back</h1>
                    <p class="text-gray-500 text-sm mb-8">Please login to your account</p>

                    @if(session('error'))
                        <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-xl text-sm text-red-600">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form id="loginForm" action="{{ route('login') }}" method="POST" novalidate class="space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email address</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="Email address" class="w-full rounded-xl bg-gray-50 border-0 px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-orange-500/20 focus:bg-white focus:border-orange-500 transition {{ $errors->has('email') ? 'ring-2 ring-red-500/20 border-red-500' : '' }}">
                            <p id="email-error" class="mt-1.5 text-xs text-red-500 hidden"></p>
                            @error('email') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                            <div class="relative">
                                <input id="password" name="password" type="password" placeholder="Password" class="w-full rounded-xl bg-gray-50 border-0 px-4 py-3 pr-11 text-sm text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-orange-500/20 focus:bg-white focus:border-orange-500 transition {{ $errors->has('password') ? 'ring-2 ring-red-500/20 border-red-500' : '' }}">
                                <button type="button" id="togglePwd" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                    <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                </button>
                            </div>
                            <p id="password-error" class="mt-1.5 text-xs text-red-500 hidden"></p>
                            @error('password') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('password.request') }}" class="text-sm font-medium text-gray-900 hover:text-orange-500 transition">Forgot Password?</a>
                        </div>

                        <button type="submit" class="btn-primary w-full py-3 rounded-xl text-sm font-medium tracking-wide">Login</button>
                    </form>

                    <p class="mt-8 text-center text-sm text-gray-500">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="font-semibold text-orange-500 hover:underline">Signup</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('togglePwd').addEventListener('click', () => {
            const input = document.getElementById('password');
            const isHide = input.type === 'password';
            input.type = isHide ? 'text' : 'password';
            document.getElementById('eyeOpen').classList.toggle('hidden', isHide);
            document.getElementById('eyeClosed').classList.toggle('hidden', !isHide);
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
        document.getElementById('loginForm').addEventListener('submit', (e) => {
            let valid = true;
            if (!emailInput.value.trim()) { showError(emailInput, emailError, 'Email is required.'); valid = false; }
            else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value.trim())) { showError(emailInput, emailError, 'Enter a valid email address.'); valid = false; }
            if (!pwdInput.value) { showError(pwdInput, pwdError, 'Password is required.'); valid = false; }
            if (!valid) {
                e.preventDefault();
                document.getElementById('loginForm').classList.add('shake');
                document.getElementById('loginForm').addEventListener('animationend', function() { this.classList.remove('shake'); }, { once: true });
            }
        });
    </script>
    @endpush
</x-guest-layout>