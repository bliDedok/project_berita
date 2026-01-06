<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') - News</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root{
            --bg-dark:#0f1115;
            --panel:#141821;
            --muted:#9aa4b2;
        }
        body{ background:#f6f7fb; }
        .admin-topbar{
            background: linear-gradient(180deg, #0f1115 0%, #141821 100%);
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        .admin-topbar .form-control{
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.10);
            color:#fff;
        }
        .admin-topbar .form-control::placeholder{ color: rgba(255,255,255,.55); }
        .admin-sidebar{
            width: 280px;
            min-height: calc(100vh - 72px);
            background: #fff;
            border-right: 1px solid #e7eaf0;
        }
        .admin-sidebar .nav-link{
            color:#111827;
            border-radius: 12px;
            padding: .6rem .75rem;
            font-weight: 600;
        }
        .admin-sidebar .nav-link:hover{
            background:#f1f5f9;
        }
        .admin-sidebar .nav-link.active{
            background:#111827;
            color:#fff;
        }
        .admin-content{ padding: 24px; }
        .badge-admin{
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.18);
        }
    </style>
</head>
<body>

{{-- TOPBAR ADMIN --}}
<nav class="navbar admin-topbar navbar-dark py-3">
    <div class="container-fluid px-4 d-flex gap-3 align-items-center">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('admin.posts.index') }}">
            <i class="bi bi-grid-fill"></i> <span>Admin News</span>
        </a>

        <form class="flex-grow-1 d-none d-md-block" method="GET" action="{{ url()->current() }}">
            <div class="input-group">
                <span class="input-group-text bg-transparent border-0 text-white-50">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" name="q" class="form-control" placeholder="Cari di admin..." value="{{ request('q') }}">
            </div>
        </form>

        <div class="d-flex align-items-center gap-2">
            <span class="badge rounded-pill badge-admin text-white px-3 py-2">
                <i class="bi bi-shield-lock"></i> ADMIN
            </span>

            @auth
                <div class="text-white-50 small d-none d-sm-block">
                    {{ auth()->user()->name }}
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-light btn-sm">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            @endauth
        </div>
    </div>
</nav>

<div class="d-flex">
    {{-- SIDEBAR ADMIN --}}
    <aside class="admin-sidebar p-3">
        <div class="text-uppercase small fw-bold text-muted mb-2">Menu Admin</div>

        <nav class="nav flex-column gap-1">
            <a class="nav-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}"
               href="{{ route('admin.posts.index') }}">
                <i class="bi bi-newspaper me-2"></i> Posts
            </a>

            <a class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}"
               href="{{ route('admin.kategori.index') }}">
                <i class="bi bi-tags me-2"></i> Kategori
            </a>

            <hr class="my-3">

            <a class="nav-link" href="{{ route('home') }}">
                <i class="bi bi-house me-2"></i> Kembali ke User
            </a>
        </nav>
    </aside>

    {{-- CONTENT --}}
    <main class="flex-grow-1 admin-content">
        @yield('content')
    </main>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
