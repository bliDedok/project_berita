<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    {{-- Premium Black-White Theme --}}
    <style>
        :root{
            --news-bg:#f5f6f7;
            --news-surface:#ffffff;
            --news-text:#0b0c0f;
            --news-muted:#6b7280;
            --news-border:#e5e7eb;
            --news-dark:#0b0c0f;
            --news-dark-2:#111217;
        }

        body{
            background: var(--news-bg);
            color: var(--news-text);
        }

        .news-navbar{
            background: var(--news-dark);
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        .news-navbar .navbar-brand,
        .news-navbar .nav-link,
        .news-navbar .btn,
        .news-navbar .text-white{
            color: #fff !important;
        }

        .news-search{
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.12);
            color:#fff;
        }
        .news-search::placeholder{ color: rgba(255,255,255,.65); }
        .news-search:focus{
            background: rgba(255,255,255,.10);
            border-color: rgba(255,255,255,.25);
            color:#fff;
            box-shadow: none;
        }

        .news-surface{
            background: var(--news-surface);
            border: 1px solid var(--news-border);
            border-radius: 16px;
        }

        .news-card{
            background: var(--news-surface);
            border: 1px solid var(--news-border);
            border-radius: 18px;
            overflow: hidden;
            transition: transform .12s ease, box-shadow .12s ease;
        }
        .news-card:hover{
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0,0,0,.08);
        }

        .news-badge{
            background: #111217 !important;
            color: #fff !important;
            border-radius: 999px;
            font-weight: 600;
            letter-spacing: .2px;
        }

        .news-pill{
            border-radius: 999px;
            border: 1px solid var(--news-border);
            background: #fff;
            color: #111217;
            font-weight: 600;
        }
        .news-pill.active{
            background: #111217;
            color: #fff;
            border-color: #111217;
        }

        .news-btn-dark{
            background: #111217;
            color:#fff;
            border: 1px solid #111217;
        }
        .news-btn-dark:hover{ background:#0b0c0f; border-color:#0b0c0f; color:#fff; }

        .news-icon-btn{
            width: 38px; height: 38px;
            display: inline-flex; align-items:center; justify-content:center;
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,.15);
            background: rgba(255,255,255,.06);
        }
        .news-icon-btn:hover{ background: rgba(255,255,255,.10); }

        /* Layout */
        .app-main{ margin-top: 64px; }
        .sidebar-desktop{
            width: 260px;
            position: fixed;
            top: 64px;
            bottom: 0;
            overflow-y: auto;
            background: #fff;
            border-right: 1px solid var(--news-border);
        }
        .content-desktop{ margin-left: 260px; }

        .sidebar-link{
            border-radius: 12px;
            padding: 10px 12px;
            color: #111217;
            font-weight: 600;
        }
        .sidebar-link:hover{ background: #f3f4f6; }
        .sidebar-link.active{ background: #111217; color:#fff; }

        @media (max-width: 767.98px){
            .content-desktop{ margin-left: 0; }
        }
    </style>
</head>

<body>

@include('partials.topbar')
@include('partials.sidebar')

<main class="app-main">
    <div class="content-desktop">
        <div class="container-fluid px-3 px-md-4 py-3">
            @yield('content')
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
