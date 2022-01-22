<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title : 'Untitled' }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body>
        @auth
            <form method="POST" action="{{ route('logout') }}" id="nav-logout-form">
                @csrf
                <a
                    href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.querySelector('#nav-logout-form').submit();"
                >
                    Kilépés
                </a>
            </form>
        @else
            <a href="{{ route('login') }}" class="hover:underline">Bejelentkezés</a>
            <a href="{{ route('register') }}" class="hover:underline">Regisztráció</a>
        @endauth
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>
    </body>
</html>
