<x-guest-layout>
    <div class="w-full max-w-5xl mx-auto">
        <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 overflow-hidden border border-gray-100 grid grid-cols-1 lg:grid-cols-12">
            
            <!-- Left Panel -->
            <div class="lg:col-span-5 bg-gradient-to-br from-orange-500 to-amber-600 p-10 flex flex-col justify-center relative overflow-hidden rounded-[1.5rem] m-3">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_right,rgba(255,255,255,0.2),transparent_60%)] pointer-events-none"></div>
                
                <div class="relative z-10">
                    <h2 class="text-3xl font-extrabold text-white tracking-tight leading-tight mb-3">Forgot your<br>password?</h2>
                    <p class="text-orange-100/80 text-sm leading-relaxed max-w-xs">No worries. Enter your email and we'll send you a reset link.</p>
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

                    <h1 class="text-2xl font-bold text-gray-900 mb-1">Reset Password</h1>
                    <p class="text-gray-500 text-sm mb-8">Enter your email and we'll send you a reset link</p>

                    @if(session('status'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-100 rounded-xl text-sm text-green-700">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form id="forgotForm" action="{{ route('password.email') }}" method="POST" novalidate class="space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email address</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="you@example.com" class="w-full rounded-xl bg-gray-50 border-0 px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-orange-500/20 focus:bg-white focus:border-orange-500 transition {{ $errors->has('email') ? 'ring-2 ring-red-500/20 border-red-500' : '' }}">
                            <p id="email-error" class="mt-1.5 text-xs text-red-500 hidden"></p>
                            @error('email') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" class="btn-primary w-full py-3 rounded-xl text-sm font-medium tracking-wide">Send Reset Link</button>
                    </form>

                    <p class="mt-8 text-center text-sm text-gray-500">
                        <a href="{{ route('login') }}" class="font-semibold text-orange-500 hover:underline">Back to sign in</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
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
        const emailError = document.getElementById('email-error');
        emailInput.addEventListener('blur', () => {
            if (!emailInput.value.trim()) showError(emailInput, emailError, 'Email is required.');
            else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value.trim())) showError(emailInput, emailError, 'Enter a valid email address.');
            else clearError(emailInput, emailError);
        });
        emailInput.addEventListener('input', () => clearError(emailInput, emailError));
        document.getElementById('forgotForm').addEventListener('submit', (e) => {
            if (!emailInput.value.trim()) {
                showError(emailInput, emailError, 'Email is required.');
                e.preventDefault();
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value.trim())) {
                showError(emailInput, emailError, 'Enter a valid email address.');
                e.preventDefault();
            }
        });
    </script>
    @endpush
</x-guest-layout>