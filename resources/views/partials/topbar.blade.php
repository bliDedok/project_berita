<nav class="navbar news-navbar fixed-top" style="height:64px;">
    <div class="container-fluid px-3 px-md-4">

        {{-- tombol menu (mobile) --}}
        <button class="btn news-icon-btn d-md-none me-2"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#sidebarOffcanvas"
                aria-controls="sidebarOffcanvas">
            <i class="bi bi-list fs-5"></i>
        </button>

        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ url('/home') }}">
            <i class="bi bi-newspaper"></i>
            <span>News</span>
        </a>

        {{-- Search (desktop) --}}
        <form class="d-none d-md-flex ms-3 flex-grow-1" method="GET" action="{{ url('/home') }}">
            <div class="input-group">
                <span class="input-group-text border-0" style="background:rgba(255,255,255,.08); color:#fff;">
                    <i class="bi bi-search"></i>
                </span>
                <input class="form-control news-search border-0"
                       type="text" name="q" placeholder="Cari berita..."
                       value="{{ request('q') }}">
            </div>

            {{-- keep filters --}}
            <input type="hidden" name="kategori" value="{{ request('kategori') }}">
            <input type="hidden" name="city" value="{{ request('city') }}">
        </form>

        <div class="ms-auto d-flex align-items-center gap-2">
            <a class="btn news-icon-btn" href="{{ url('/home') }}" title="Beranda">
                <i class="bi bi-house-door"></i>
            </a>

            @auth
            @can('access-admin')
                <a class="btn news-icon-btn" href="{{ route('admin.posts.index') }}" title="Admin"><i class="bi bi-shield-lock"></i></a>
            @endcan
                <a class="btn news-icon-btn" href="{{ url('/profile') }}" title="Profile">
                    <i class="bi bi-person"></i>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button class="btn news-icon-btn" title="Logout">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            @else
                <a class="btn btn-sm btn-light fw-semibold" href="{{ route('login') }}">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Login
                </a>
            @endauth
        </div>
    </div>
</nav>
