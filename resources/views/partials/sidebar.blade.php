{{-- Sidebar Desktop --}}
<aside class="d-none d-md-block sidebar-desktop">
    <div class="p-3">
        <div class="text-uppercase small text-muted fw-semibold mb-2">Menu</div>

        <a href="{{ url('/home') }}"
           class="d-flex align-items-center gap-2 sidebar-link {{ request()->is('home') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i> Beranda
        </a>

        @auth
            <a href="{{ url('/profile') }}"
               class="d-flex align-items-center gap-2 sidebar-link {{ request()->is('profile') ? 'active' : '' }}">
                <i class="bi bi-person"></i> Profile
            </a>
        @endauth

        <hr class="my-3">

        <div class="text-uppercase small text-muted fw-semibold mb-2">Cepat</div>
        <a href="{{ url('/home') }}#cuaca" class="d-flex align-items-center gap-2 sidebar-link">
            <i class="bi bi-cloud-sun"></i> Cuaca
        </a>
        <a href="{{ url('/home') }}#berita" class="d-flex align-items-center gap-2 sidebar-link">
            <i class="bi bi-fire"></i> Trending
        </a>
    </div>
</aside>

{{-- Offcanvas Mobile --}}
<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title fw-bold" id="sidebarOffcanvasLabel">
            <i class="bi bi-newspaper me-1"></i> News
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-2">
        <a href="{{ url('/home') }}" class="d-flex align-items-center gap-2 sidebar-link">
            <i class="bi bi-house-door"></i> Beranda
        </a>

        @auth
            <a href="{{ url('/profile') }}" class="d-flex align-items-center gap-2 sidebar-link">
                <i class="bi bi-person"></i> Profile
            </a>
        @endauth

        <hr class="my-3">

        <a href="{{ url('/home') }}#cuaca" class="d-flex align-items-center gap-2 sidebar-link">
            <i class="bi bi-cloud-sun"></i> Cuaca
        </a>
        <a href="{{ url('/home') }}#berita" class="d-flex align-items-center gap-2 sidebar-link">
            <i class="bi bi-fire"></i> Trending
        </a>
    </div>
</div>
