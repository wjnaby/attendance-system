<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Attendance System')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div id="app">
        <!-- Navigation -->
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" class="text-xl font-bold text-blue-600">
                            📋 Attendance System
                        </a>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        @auth
                            <span class="text-gray-700">{{ auth()->user()->name }}</span>
                            
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-blue-600">Dashboard</a>
                                <a href="{{ route('admin.reports') }}" class="text-gray-600 hover:text-blue-600">Reports</a>
                                <a href="{{ route('admin.users') }}" class="text-gray-600 hover:text-blue-600">Users</a>
                            @else
                                <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-blue-600">Dashboard</a>
                                <a href="{{ route('qr.show') }}" class="text-gray-600 hover:text-blue-600">My QR</a>
                                <a href="{{ route('qr.scan') }}" class="text-gray-600 hover:text-blue-600">Scan</a>
                                <a href="{{ route('history') }}" class="text-gray-600 hover:text-blue-600">History</a>
                            @endif
                            
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-800">Logout</button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif
            
            @yield('content')
        </main>
    </div>
</body>
</html>