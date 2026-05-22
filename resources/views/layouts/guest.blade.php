<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TriBee') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-slate-50 via-indigo-50/10 to-pink-50/20 min-h-screen">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 pb-10 px-4">
            <div class="flex justify-center mb-8">
                <a href="/" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-orange-600 rounded-xl flex items-center justify-center">
                        <svg width="20" height="20" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="16" height="16" rx="4" fill="#fff"/>
                            <rect x="20" width="16" height="16" rx="4" fill="#fff" opacity="0.7"/>
                            <rect y="20" width="16" height="16" rx="4" fill="#fff" opacity="0.5"/>
                            <rect x="20" y="20" width="16" height="16" rx="4" fill="#111" opacity="0.3"/>
                        </svg>
                    </div>
                    <span class="text-2xl font-extrabold tracking-tight text-neutral-900">Tri<span class="text-orange-600">Bee</span></span>
                </a>
            </div>

            <div class="w-full sm:max-w-md card bg-white rounded-3xl shadow-xl shadow-gray-200/50 p-8">
                {{ $slot }}
            </div>

            <p class="text-center text-xs text-gray-400 mt-6">&copy; {{ date('Y') }} TriBee. All rights reserved.</p>
        </div>

        @stack('scripts')
    </body>
</html>