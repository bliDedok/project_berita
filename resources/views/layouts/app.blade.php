<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom mb-3">
    <div class="container">
        {{-- Arahkan ke halaman berita --}}
        <a class="navbar-brand" href="{{ url('/home') }}">
            {{ config('app.name', 'Laravel') }}
        </a>

        <div class="d-flex align-items-center gap-2">
            {{-- Admin menu: hanya admin --}}
            @can('access-admin')
                <a class="btn btn-outline-primary btn-sm" href="{{ route('admin.posts.index') }}">
                    Admin Posts
                </a>
            @endcan

            {{-- Auth buttons --}}
            @auth
                <span class="small text-muted d-none d-sm-inline">
                    {{ auth()->user()->name }}
                </span>

                {{-- Link logout tapi tetap POST --}}
                <a href="#" class="btn btn-outline-secondary btn-sm"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>

                <form id="logout-form" method="POST" action="{{ url('/logout') }}" class="d-none">
                    @csrf
                </form>
            @else
                <a class="btn btn-outline-secondary btn-sm" href="{{ url('/login') }}">Login</a>
                <a class="btn btn-primary btn-sm" href="{{ url('/register') }}">Register</a>
            @endauth
        </div>
    </div>
</nav>

<main>
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXx5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
