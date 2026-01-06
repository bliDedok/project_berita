@extends('layouts.app')

@section('content')

{{-- CUACA --}}
<div id="cuaca" class="news-surface p-3 p-md-4 mb-3">
    <div class="d-flex flex-column flex-lg-row gap-3 align-items-lg-center justify-content-between">
        <div>
            <div class="d-flex align-items-center gap-2 fw-bold">
                <i class="bi bi-cloud-sun"></i>
                <span>Cuaca Bali</span>
            </div>

            @if($cuaca)
                <div class="text-muted small mt-1">
                    {{ $cuaca['kota'] }}{{ $cuaca['provinsi'] ? ', '.$cuaca['provinsi'] : '' }}
                    • <span class="fw-semibold text-dark">{{ $cuaca['status'] }}</span>
                    • Suhu <span class="fw-semibold text-dark">{{ $cuaca['suhu'] }}°C</span> (terasa {{ $cuaca['terasa'] }}°C)
                    • Kelembapan {{ $cuaca['lembap'] }}%
                    • Angin {{ $cuaca['angin'] }} km/j
                    • Max {{ $cuaca['max'] }}° / Min {{ $cuaca['min'] }}°
                    • Hujan {{ $cuaca['hujan'] }}%
                </div>
            @else
                <div class="text-danger small mt-1">Gagal ambil data cuaca.</div>
            @endif
        </div>

        <form method="GET" action="{{ url('/home') }}" class="d-flex gap-2 align-items-center">
            <input type="hidden" name="q" value="{{ request('q') }}">
            <input type="hidden" name="kategori" value="{{ request('kategori') }}">

            <select name="city" class="form-select form-select-sm" style="min-width: 220px">
                @foreach($cities as $city)
                    <option value="{{ $city }}" @selected($selectedCity === $city)>{{ $city }}</option>
                @endforeach
            </select>

            <button class="btn btn-sm news-btn-dark" type="submit">
                <i class="bi bi-arrow-repeat me-1"></i> Update
            </button>
        </form>
    </div>
</div>


{{-- KATEGORI PILLS --}}
<div class="d-flex align-items-center gap-2 overflow-auto pb-2 mb-3">
    @php
        $base = ['q' => request('q'), 'city' => request('city')];
    @endphp

    <a class="btn btn-sm news-pill {{ request('kategori') ? '' : 'active' }} text-nowrap"
       href="{{ url('/home').'?'.http_build_query($base) }}">
        Semua
    </a>

    @foreach($kategoris as $kat)
        @php $params = array_merge($base, ['kategori' => $kat->slug]); @endphp
        <a class="btn btn-sm news-pill {{ request('kategori') === $kat->slug ? 'active' : '' }} text-nowrap"
           href="{{ url('/home').'?'.http_build_query($params) }}">
            {{ $kat->nama }}
        </a>
    @endforeach
</div>


@php
    $items = $posts->getCollection();
    $featured = $items->first();
    $side = $items->slice(1, 2);
    $grid = $items->slice(3);
@endphp

<div id="berita" class="row g-3">

    {{-- HERO (berita pertama besar) --}}
    <div class="col-12 col-lg-8">
        @if($featured)
            <div class="news-card h-100">
                <div class="ratio ratio-16x9 bg-light">
                    @if($featured->gambar)
                        <img src="{{ asset('storage/'.$featured->gambar) }}"
                             class="w-100 h-100" style="object-fit:cover;"
                             alt="{{ $featured->judul }}">
                    @else
                        <div class="d-flex justify-content-center align-items-center text-muted">
                            Tidak ada gambar
                        </div>
                    @endif
                </div>

                <div class="p-3 p-md-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="badge news-badge px-3 py-2">
                            {{ $featured->kategori?->nama ?? 'Tanpa Kategori' }}
                        </span>
                        <small class="text-muted">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ optional($featured->tanggal_unggah)->format('d M Y') }}
                        </small>
                    </div>

                    <h3 class="fw-bold mb-2" style="letter-spacing:-0.3px;">
                        {{ $featured->judul }}
                    </h3>

                    <p class="text-muted mb-3">
                        {{ \Illuminate\Support\Str::limit($featured->ringkasan, 140) }}
                    </p>

                    <div class="d-flex flex-wrap align-items-center gap-2 justify-content-between">
                        <div class="text-muted small">
                            <i class="bi bi-eye me-1"></i> {{ $featured->jumlah_pembaca }}
                        </div>

                        <div class="d-flex gap-2">
                            @auth
                                @php $isSaved = in_array($featured->id, $savedIds ?? []); @endphp
                                <form method="POST" action="{{ route('daftar-bacaan.toggle', $featured) }}">
                                    @csrf
                                    <button class="btn btn-sm {{ $isSaved ? 'btn-success' : 'btn-outline-dark' }}">
                                        <i class="bi bi-bookmark{{ $isSaved ? '-fill' : '' }} me-1"></i>
                                        {{ $isSaved ? 'Tersimpan' : 'Simpan' }}
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}?redirect={{ urlencode(url()->full()) }}"
                                   class="btn btn-sm btn-outline-dark">
                                    <i class="bi bi-bookmark me-1"></i> Simpan
                                </a>
                            @endauth

                            <a href="{{ route('berita.show', $featured->slug) }}" class="btn btn-sm news-btn-dark">
                                <i class="bi bi-arrow-right me-1"></i> Baca
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- SIDE TRENDING (2 berita samping) --}}
    <div class="col-12 col-lg-4">
        <div class="news-surface p-3 h-100">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="fw-bold">
                    <i class="bi bi-fire me-1"></i> Trending
                </div>
                <small class="text-muted">Top hari ini</small>
            </div>

            @if($side->count() === 0)
                <div class="text-muted small">Belum ada berita.</div>
            @else
                <div class="d-flex flex-column gap-3">
                    @foreach($side as $p)
                        <a href="{{ route('berita.show', $p->slug) }}" class="text-decoration-none text-dark">
                            <div class="d-flex gap-3">
                                <div class="ratio ratio-1x1 bg-light rounded-3 overflow-hidden" style="width: 88px; flex:0 0 auto;">
                                    @if($p->gambar)
                                        <img src="{{ asset('storage/'.$p->gambar) }}"
                                             class="w-100 h-100" style="object-fit:cover;"
                                             alt="{{ $p->judul }}">
                                    @endif
                                </div>

                                <div class="flex-grow-1">
                                    <div class="small text-muted mb-1">
                                        {{ $p->kategori?->nama ?? 'Tanpa Kategori' }}
                                        • {{ optional($p->tanggal_unggah)->format('d M') }}
                                    </div>
                                    <div class="fw-semibold" style="line-height:1.2;">
                                        {{ \Illuminate\Support\Str::limit($p->judul, 58) }}
                                    </div>
                                    <div class="text-muted small mt-1">
                                        <i class="bi bi-eye me-1"></i>{{ $p->jumlah_pembaca }}
                                    </div>
                                </div>
                            </div>
                        </a>
                        <hr class="my-0">
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- GRID (sisa berita) --}}
    <div class="col-12 mt-1">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="fw-bold">
                <i class="bi bi-newspaper me-1"></i> Berita Terbaru
            </div>

            {{-- Search mobile (biar tetap ada) --}}
            <form class="d-md-none d-flex gap-2" method="GET" action="{{ url('/home') }}">
                <input class="form-control form-control-sm" type="text" name="q" placeholder="Cari..."
                       value="{{ request('q') }}">
                <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                <input type="hidden" name="city" value="{{ request('city') }}">
                <button class="btn btn-sm news-btn-dark">Cari</button>
            </form>
        </div>
    </div>

    @if($items->count() === 0)
        <div class="col-12">
            <div class="alert alert-info">Belum ada berita.</div>
        </div>
    @else
        @foreach($grid as $post)
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="news-card h-100">

                    <div class="position-relative">
                        <div class="ratio ratio-16x9 bg-light">
                            @if($post->gambar)
                                <img src="{{ asset('storage/'.$post->gambar) }}"
                                     class="w-100 h-100" style="object-fit:cover;"
                                     alt="{{ $post->judul }}">
                            @else
                                <div class="d-flex justify-content-center align-items-center text-muted small">
                                    Tidak ada gambar
                                </div>
                            @endif
                        </div>

                        {{-- Save overlay --}}
                        <div class="position-absolute top-0 end-0 p-2">
                            @auth
                                @php $isSaved = in_array($post->id, $savedIds ?? []); @endphp
                                <form method="POST" action="{{ route('daftar-bacaan.toggle', $post) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $isSaved ? 'btn-success' : 'btn-light' }} border">
                                        <i class="bi bi-bookmark{{ $isSaved ? '-fill' : '' }}"></i>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}?redirect={{ urlencode(url()->full()) }}"
                                   class="btn btn-sm btn-light border">
                                    <i class="bi bi-bookmark"></i>
                                </a>
                            @endauth
                        </div>
                    </div>

                    <div class="p-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge news-badge px-3 py-2">
                                {{ $post->kategori?->nama ?? 'Tanpa Kategori' }}
                            </span>
                            <small class="text-muted">
                                {{ optional($post->tanggal_unggah)->format('d M') }}
                            </small>
                        </div>

                        <div class="fw-bold" style="line-height:1.2;">
                            {{ \Illuminate\Support\Str::limit($post->judul, 60) }}
                        </div>

                        <div class="text-muted small mt-2" style="min-height: 38px;">
                            {{ \Illuminate\Support\Str::limit($post->ringkasan, 90) }}
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <small class="text-muted">
                                <i class="bi bi-eye me-1"></i>{{ $post->jumlah_pembaca }}
                            </small>

                            <a href="{{ route('berita.show', $post->slug) }}" class="btn btn-sm btn-outline-dark">
                                Baca <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="col-12 mt-3">
            {{ $posts->links() }}
        </div>
    @endif
</div>

@endsection
