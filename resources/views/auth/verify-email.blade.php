<x-guest-layout>
    <div class="text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-orange-50 rounded-full mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>

        <h1 class="text-2xl font-bold text-gray-900 mb-1">Check your inbox</h1>
        <p class="text-gray-500 text-sm mb-7">We sent a verification link to your email. Click the link to verify your account.</p>

        @if(session('status') == 'verification-link-sent')
            <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700 error-msg">
                A new verification link has been sent!
            </div>
        @endif

        <form action="{{ route('verification.send') }}" method="POST">
            @csrf
            <button type="submit" id="resendBtn" class="btn-primary">Resend Email</button>
        </form>

        <form action="{{ route('logout') }}" method="POST" class="mt-4">
            @csrf
            <button type="submit" class="text-sm text-gray-500 hover:text-orange-500 underline">Log out</button>
        </form>
    </div>

    @push('scripts')
    <script>
        const btn = document.getElementById('resendBtn');
        let cooldown = 60;
        let timer;

        btn.addEventListener('click', () => {
            btn.disabled = true;
            btn.textContent = `Resend in ${cooldown}s`;
            btn.style.opacity = '0.6';
            btn.style.cursor = 'not-allowed';
            timer = setInterval(() => {
                cooldown--;
                btn.textContent = `Resend in ${cooldown}s`;
                if (cooldown <= 0) {
                    clearInterval(timer);
                    btn.disabled = false;
                    btn.textContent = 'Resend Email';
                    btn.style.opacity = '1';
                    btn.style.cursor = 'pointer';
                    cooldown = 60;
                }
            }, 1000);
        }, { once: true });
    </script>
    @endpush
</x-guest-layout>