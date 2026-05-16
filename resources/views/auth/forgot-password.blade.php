<x-guest-layout>
    <h1 class="text-2xl font-bold text-gray-900 mb-1">Forgot password?</h1>
    <p class="text-gray-500 text-sm mb-7">Enter your email and we'll send you a reset link.</p>

    @if(session('status'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700 error-msg">
            {{ session('status') }}
        </div>
    @endif

    <form id="forgotForm" action="{{ route('password.email') }}" method="POST" novalidate>
        @csrf

        <div class="mb-6">
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

        <button type="submit" class="btn-primary">Send Reset Link</button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-500">
        <a href="{{ route('login') }}" class="text-orange-500 font-semibold hover:underline">Back to sign in</a>
    </p>

    @push('scripts')
    <script>
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