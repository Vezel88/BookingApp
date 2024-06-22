<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
<body class="bg-gray-100 flex">
    <!-- Sidebar -->
    <nav class="w-64 bg-black text-white min-h-screen flex flex-col">
        <div class="p-4">
            <h1 class="text-3xl font-bold">Dashboard</h1>
        </div>
        <div class="mt-6 flex-1 ">
            <a href="{{ route('admin.dashboard') }}" class="block mb-3 py-2.5 px-4 rounded transition duration-200 hover:bg-yellow-500 {{ request()->routeIs('admin.dashboard') ? 'bg-yellow-500' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('studios.afterinput') }}" class="block mb-3 py-2.5 px-4 rounded transition duration-200 hover:bg-yellow-500 {{ request()->routeIs('studios.afterinput') ? 'bg-yellow-500' : '' }}">
                Studio
            </a>
            <a href="" class="block py-2.5 px-4 rounded transition  duration-200 hover:bg-yellow-500 {{ request()->routeIs('admin.user') ? 'bg-yellow-500' : '' }}">
                User
            </a>
        </div>
        <div class="p-4">
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-800">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </nav>

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>
</body>
</html>
