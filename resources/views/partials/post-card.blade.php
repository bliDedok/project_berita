<div class="col">
    <article class="card h-100 border-0 shadow-sm">
        <div class="row g-0">
            <div class="col-4 d-none d-md-block">
                @if($post->image)
                <img src="{{ asset('storage/'.$post->image) }}" alt="{{ $post->judul }}" class="img-cover h-100">
                @endif
            </div>
            <div class="col">
                <div class="card-body">
                    <a href="{{ route('berita.show', $post->slug ?? $post->id) }}" class="text-dark text-decoration-none">
                        <h3 class="h6 fw-semibold">{{ Str::limit($post->judul, 96) }}</h3>
                    </a>
                    <div class="small text-muted mb-2">{{ optional($post->created_at)->format('d M Y') }} · {{ $post->kategori?->nama ?? 'Umum' }}</div>
                    <p class="small text-muted mb-3">{{ Str::limit(strip_tags($post->ringkasan ?? $post->konten), 120) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="small text-muted">oleh {{ $post->author?->name ?? 'Redaksi' }}</div>
                        <a href="{{ route('berita.show', $post->slug ?? $post->id) }}" class="btn btn-sm btn-outline-primary">Baca</a>
                    </div>
                </div>
            </div>
        </div>
    </article>
</div>
