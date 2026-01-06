@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex flex-column flex-md-row gap-2 align-items-md-center justify-content-between mb-3">
        <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>

        <div class="d-flex flex-wrap gap-2">
            @auth
                <form method="POST" action="{{ route('daftar-bacaan.toggle', $post) }}">
                    @csrf
                    <button type="submit"
                        class="btn btn-sm rounded-pill {{ $isSaved ? 'btn-success' : 'btn-outline-dark' }}">
                        <i class="bi bi-bookmark{{ $isSaved ? '-fill' : '' }} me-1"></i>
                        {{ $isSaved ? 'Tersimpan' : 'Simpan' }}
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}?redirect={{ urlencode($currentUrl) }}"
                   class="btn btn-sm btn-outline-dark rounded-pill">
                    <i class="bi bi-bookmark me-1"></i> Simpan
                </a>
            @endauth

            <a href="{{ $waLink }}" target="_blank" rel="noopener"
               class="btn btn-sm btn-outline-success rounded-pill">
                <i class="bi bi-whatsapp me-1"></i> Share WA
            </a>
        </div>
    </div>

    <article class="card border-0 shadow-sm rounded-4 overflow-hidden">
        @if($post->gambar)
            <div class="position-relative">
                <img src="{{ asset('storage/'.$post->gambar) }}" class="w-100"
                     style="max-height: 420px; object-fit: cover;" alt="{{ $post->judul }}">
                <div class="position-absolute top-0 start-0 w-100 h-100"
                     style="background: linear-gradient(180deg, rgba(0,0,0,.35) 0%, rgba(0,0,0,0) 55%);"></div>
                <div class="position-absolute top-0 start-0 p-3 p-md-4">
                    <span class="badge rounded-pill text-bg-dark bg-opacity-75">
                        {{ $post->kategori?->nama ?? 'Tanpa Kategori' }}
                    </span>
                </div>
            </div>
        @endif

        <div class="card-body p-3 p-md-4 p-lg-5">

            <div class="d-flex flex-wrap gap-2 align-items-center text-muted small mb-3">
                <span class="d-inline-flex align-items-center gap-1">
                    <i class="bi bi-calendar3"></i>
                    {{ optional($publishDate)->format('d M Y') }}
                </span>
                <span>•</span>
                <span class="d-inline-flex align-items-center gap-1">
                    <i class="bi bi-clock"></i>
                    {{ optional($publishDate)->format('H:i') }}
                </span>
                <span>•</span>
                <span class="d-inline-flex align-items-center gap-1">
                    <i class="bi bi-eye"></i>
                    {{ $post->jumlah_pembaca }} dibaca
                </span>

                @if(!$post->gambar)
                    <span>•</span>
                    <span class="badge rounded-pill text-bg-secondary">
                        {{ $post->kategori?->nama ?? 'Tanpa Kategori' }}
                    </span>
                @endif
            </div>

            <h1 class="h3 h2-md fw-bold mb-3">{{ $post->judul }}</h1>

            @if($post->ringkasan)
                <p class="lead text-secondary mb-4">{{ $post->ringkasan }}</p>
            @endif

            <hr class="my-4">

            <div class="fs-6 lh-lg">
                {!! nl2br(e($post->konten)) !!}
            </div>

            <hr class="my-4">

            <div class="d-flex flex-column flex-md-row gap-2 justify-content-between align-items-md-center mt-4">
                <div class="text-muted small">
                    <i class="bi bi-pencil-square me-1"></i>
                    Terakhir diperbarui:
                    <span class="fw-semibold">{{ optional($updatedDate)->format('d M Y H:i') }}</span>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    @auth
                        <form method="POST" action="{{ route('daftar-bacaan.toggle', $post) }}">
                            @csrf
                            <button type="submit"
                                class="btn btn-sm rounded-pill {{ $isSaved ? 'btn-success' : 'btn-outline-dark' }}">
                                <i class="bi bi-bookmark{{ $isSaved ? '-fill' : '' }} me-1"></i>
                                {{ $isSaved ? 'Tersimpan' : 'Simpan' }}
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}?redirect={{ urlencode($currentUrl) }}"
                           class="btn btn-sm btn-outline-dark rounded-pill">
                            <i class="bi bi-bookmark me-1"></i> Simpan
                        </a>
                    @endauth

                    <a href="{{ $waLink }}" target="_blank" rel="noopener"
                       class="btn btn-sm btn-outline-success rounded-pill">
                        <i class="bi bi-whatsapp me-1"></i> Share WA
                    </a>
                </div>
            </div>

        </div>
    </article>
</div>
@endsection
