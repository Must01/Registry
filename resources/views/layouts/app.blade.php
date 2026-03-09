<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans  antialiased">
    <div class="min-h-screen flex flex-col bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="p-3 flex-1 sm:px-10 md:px-15 lg:px-20">
            {{ $slot }}
        </main>

        {{-- Footer --}}
        <footer class="border-t text-sm border-gray-900 mt-8 py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <div>
                Developed with 💖 by <a href="https://mustaphabouddahr.netlify.app" target="_blank" class="hover:underline">Mustapha Bouddahr</a>
            </div>
            <div class="text-right">
                © 2026 All rights reserved
            </div>
            </div>
        </footer>
    </div>

</body>

</html>
