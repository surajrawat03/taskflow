<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Task Manager') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @livewireStyles

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @if (auth()->check())
            @include('layouts.sidebar')
        @endif

        <div class="flex flex-col min-h-screen @if(auth()->check()) md:pl-64 @endif">
            @if (auth()->check())
                <!-- Top Navigation (mobile) -->
                <nav class="bg-white border-b border-gray-200 md:hidden">
                    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        <div class="flex justify-between h-16">
                            <div class="flex items-center">
                                <button 
                                  class="text-gray-500 hover:text-gray-600 focus:outline-none"
                                  x-data @click="$dispatch('toggle-sidebar')">
                                  <!-- hamburger icon -->
                                  <svg class="w-6 h-6" fill="none" stroke="currentColor" ...>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 6h16M4 12h16M4 18h16" />
                                  </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </nav>
            @endif

            <!-- Page Content -->
            <main class="flex-1">
                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>
