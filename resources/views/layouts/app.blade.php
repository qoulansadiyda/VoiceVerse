<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        /* Custom styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #3498db;
            color: #fff;
            padding: 1rem 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .navbar a {
            color: #fff;
            text-decoration: none;
            margin-right: 1rem;
            transition: color 0.3s ease;
        }
        .navbar a:hover {
            color: #1e90ff;
        }
        .container {
            max-width: 960px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        .content {
            padding: 2rem 0;
            text-align: center;
            color: #333;
        }
    </style>
    @vite(['resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar">
            <div class="container">
                <div class="flex justify-between items-center">
                    <a class="text-lg font-semibold" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <div>
                        @auth
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        @else
                            <a href="{{ route('login') }}">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">Register</a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
        <div class="content">
            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>
</html>
