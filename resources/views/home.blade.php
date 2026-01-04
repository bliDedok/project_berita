@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card mb-3">
        <div class="card-body d-flex flex-column flex-md-row gap-3 align-items-md-center justify-content-between">
            <div>
                <div class="fw-semibold">Cuaca Bali</div>
                @if($cuaca)
                    <div class="text-muted small">
                        {{ $cuaca['kota'] }}{{ $cuaca['provinsi'] ? ', '.$cuaca['provinsi'] : '' }}
                        • {{ $cuaca['status'] }}
                        • Suhu {{ $cuaca['suhu'] }}°C (terasa {{ $cuaca['terasa'] }}°C)
                        • Kelembapan {{ $cuaca['lembap'] }}%
                        • Angin {{ $cuaca['angin'] }} km/j
                        • Max {{ $cuaca['max'] }}° / Min {{ $cuaca['min'] }}°
                        • Peluang hujan {{ $cuaca['hujan'] }}%
                    </div>
                @else
                    <div class="text-danger small">Gagal ambil data cuaca.</div>
                @endif
            </div>

            <form method="GET" action="{{ url('/home') }}" class="d-flex gap-2 align-items-center">
                <input type="hidden" name="q" value="{{ request('q') }}">
                <input type="hidden" name="kategori" value="{{ request('kategori') }}">

                <select name="city" class="form-select form-select-sm" style="min-width: 180px">
                    @foreach($cities as $city)
                        <option value="{{ $city }}" @selected($selectedCity === $city)>{{ $city }}</option>
                    @endforeach
                </select>

                <button class="btn btn-sm btn-outline-primary" type="submit">Update</button>
            </form>
        </div>
    </div>

    <div class="d-flex flex-column flex-md-row gap-3 align-items-md-center justify-content-between mb-3">
        <h4 class="m-0">Berita Terbaru</h4>

        <form class="d-flex gap-2" method="GET" action="{{ url('/home') }}">
            <input class="form-control form-control-sm" type="text" name="q" placeholder="Cari berita..."
                   value="{{ request('q') }}">

            <select class="form-select form-select-sm" name="kategori">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $kat)
                    <option value="{{ $kat->slug }}" @selected(request('kategori') === $kat->slug)>
                        {{ $kat->nama }}
                    </option>
                @endforeach
            </select>

            <button class="btn btn-sm btn-primary" type="submit">Filter</button>
        </form>
    </div>

    @if($posts->count() === 0)
        <div class="alert alert-info">Belum ada berita.</div>
    @else
        <div class="row g-3">
            @foreach($posts as $post)
                <div class="col-md-4">
                    <div class="card h-100">
                        @if($post->gambar)
                            <img src="{{ asset('storage/'.$post->gambar) }}" class="card-img-top" alt="{{ $post->judul }}">
                        @endif

                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-secondary">
                                    {{ $post->kategori?->nama ?? 'Tanpa Kategori' }}
                                </span>
                                <small class="text-muted">
                                    {{ optional($post->tanggal_unggah)->format('d M Y') }}
                                </small>
                            </div>

                            <h5 class="card-title">{{ $post->judul }}</h5>
                            <p class="card-text text-muted">
                                {{ $post->ringkasan }}
                            </p>
                        </div>

                        <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
                            <small class="text-muted">👁 {{ $post->jumlah_pembaca }}</small>

                            <div class="d-flex gap-2">
                                @auth
                                    @php $isSaved = in_array($post->id, $savedIds ?? []); @endphp

                                    <form method="POST" action="{{ route('daftar-bacaan.toggle', $post) }}">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-sm {{ $isSaved ? 'btn-success' : 'btn-outline-success' }}">
                                            {{ $isSaved ? 'Tersimpan' : 'Simpan' }}
                                        </button>
                                    </form>
                                @else
                                    <a
                                        href="{{ route('login') }}?redirect={{ urlencode(url()->current()) }}"
                                        class="btn btn-sm btn-outline-success"
                                    >
                                        Simpan
                                    </a>
                                @endauth

                                <a href="{{ route('berita.show', $post->slug) }}" class="btn btn-sm btn-outline-primary">
                                    Baca
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-3">
            {{ $posts->links() }}
        </div>
    @endif
</div>
@endsection


