<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TriBee') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-mesh">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 pb-10 px-4">
            <div class="flex justify-center mb-8">
                <a href="/" class="flex items-center gap-2">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="16" height="16" rx="5" fill="#1C1C1C"/>
                        <rect x="20" width="16" height="16" rx="5" fill="#F97316"/>
                        <rect y="20" width="16" height="16" rx="5" fill="#F97316"/>
                        <rect x="20" y="20" width="16" height="16" rx="5" fill="#1C1C1C" opacity="0.2"/>
                    </svg>
                    <span class="text-2xl font-bold text-gray-900 tracking-tight">Tri<span class="text-orange-500">Bee</span></span>
                </a>
            </div>

            <div class="w-full sm:max-w-md card bg-white rounded-3xl shadow-xl shadow-black/5 p-8 border border-gray-200">
                {{ $slot }}
            </div>

            <p class="text-center text-xs text-gray-400 mt-6">&copy; {{ date('Y') }} TriBee. All rights reserved.</p>
        </div>

        @stack('scripts')
    </body>
</html>