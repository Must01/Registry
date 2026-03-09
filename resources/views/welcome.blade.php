<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Registry - Document Management</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#FDFDFC] container text-gray-900 flex flex-col min-h-screen">

    {{-- Header --}}
    <header class="w-full h-10 max-w-6xl mx-auto px-6 py-4 flex justify-between gap-4">
       <div class="flex flex-row items-center gap-1">
            <x-application-logo />
            <p class="text-gray-700">Registry</p>
       </div>
       <div>
         @auth
            <a href="{{ url('/registry') }}"
                class="px-5 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition text-sm font-medium">
                Go to Dashboard
            </a>
        @else
            <a href="{{ route('login') }}"
                class="px-5 py-2 text-gray-900 hover:text-gray: transition text-sm font-medium">
                Log in
            </a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}"
                    class="px-5 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition text-sm font-medium">
                    Get Started
                </a>
            @endif
        @endauth
       </div>
    </header>

    {{-- Hero Section --}}
    <main class="flex-grow min-h-[calc(100vh-50px)] bg-gray-50 flex items-center justify-center px-6 py-12">
        <div class="max-w-6xl w-full grid lg:grid-cols-2 gap-12 items-center">

            {{-- Left: Text & Buttons --}}
            <div class="text-center lg:text-left">
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                    Your Personal<br>
                    <span class="text-gray-600">Document Manager</span>
                </h1>
                <p class="text-lg text-gray-600 mb-8 max-w-lg mx-auto lg:mx-0">
                    Upload, search, and export your files with ease. Keep track of all your important documents in one place.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    @auth
                        <a href="{{ route('registry.index') }}"
                            class="px-8 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition font-medium">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}"
                            class="px-8 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition font-medium">
                            Get Started
                        </a>
                        <a href="{{ route('login') }}"
                            class="px-8 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg hover:border-gray-600 hover:text-gray-600 transition font-medium">
                            Log in
                        </a>
                    @endauth
                </div>
            </div>

            {{-- Right: Hero Image --}}
            <div class="flex justify-center lg:justify-end">
                <img src="{{ asset('images/icons/hero.svg') }}" alt="Document Management" class="w-full max-w-md">
            </div>
        </div>
    </main>

    {{-- Features Section --}}
    <section class="bg-gray-100 py-16 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="grid md:grid-cols-3 gap-8">

                {{-- Feature 1: Easy Uploads --}}
                <div class="text-center p-6">
                    <div class="w-16 h-16 mx-auto mb-4 bg-gray-400 rounded-xl flex items-center justify-center">
                        <x-solar-upload-square-bold class="w-8 h-8 text-gray-600" />
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Easy Uploads</h3>
                    <p class="text-gray-700">
                        Drag and drop your files. Simple and fast.
                    </p>
                </div>

                {{-- Feature 2: Quick Search --}}
                <div class="text-center p-6">
                    <div class="w-16 h-16 mx-auto mb-4 bg-purple-400  rounded-xl flex items-center justify-center">
                        <x-solar-card-search-bold class="w-8 h-8 text-purple-600 " />
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Quick Search</h3>
                    <p class="text-gray-700">
                        Find anything in seconds with powerful search.
                    </p>
                </div>

                {{-- Feature 3: Export to CSV --}}
                <div class="text-center p-6">
                    <div class="w-16 h-16 mx-auto mb-4 bg-green-100 rounded-xl flex items-center justify-center">
                        <x-solar-download-square-bold class="w-8 h-8 text-green-600 " />
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Export to CSV</h3>
                    <p class="text-gray-700">
                        Download your data anytime in CSV format.
                    </p>
                </div>

            </div>
        </div>
    </section>

    {{-- Simple Footer --}}
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

</body>

</html>
