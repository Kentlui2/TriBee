<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TriBee') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="font-sans antialiased min-h-screen bg-gradient-to-br from-slate-100 via-orange-50/50 to-amber-100/40 relative">
        
        <!-- Background blobs -->
        <div class="fixed inset-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-20 -left-20 w-72 h-72 bg-orange-300/30 rounded-full blur-3xl"></div>
            <div class="absolute top-1/3 -right-20 w-96 h-96 bg-amber-300/25 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-20 left-1/3 w-80 h-80 bg-orange-200/30 rounded-full blur-3xl"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10 py-10 px-4 sm:px-6 lg:px-8">
            {{ $slot }}
        </div>

        @stack('scripts')
    </body>
</html>