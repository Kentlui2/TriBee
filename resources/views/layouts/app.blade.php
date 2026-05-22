<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Shopping Cart') - {{ config('app.name', 'TriBee') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-gray-50 text-neutral-800">
        @include('layouts.navigation')

        <main class="max-w-7xl mx-auto py-10 px-4 sm:px-6">
            @yield('content')
        </main>

        @stack('scripts')
    </body>
</html>