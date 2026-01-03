@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary mb-3">← Kembali</a>

    <div class="card">
        @if($post->image)
            <img src="{{ asset('storage/'.$post->image) }}" class="card-img-top" alt="{{ $post->judul }}">
        @endif

        <div class="card-body">
            <div class="d-flex gap-2 align-items-center mb-2">
                <span class="badge bg-secondary">{{ $post->kategori?->nama ?? 'Tanpa Kategori' }}</span>
                <small class="text-muted">
                    {{ optional($post->tanggal_unggah)->format('d M Y') }} • 👁 {{ $post->jumlah_pembaca }}
                </small>
            </div>

            <h3 class="mb-3">{{ $post->judul }}</h3>
            <p class="text-muted">{{ $post->ringkasan }}</p>

            <hr>

            <div>
                {{ $post->konten }}
            </div>
        </div>
    </div>
</div>
@endsection
