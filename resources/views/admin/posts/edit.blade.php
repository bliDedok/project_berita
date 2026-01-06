@extends('layouts.admin')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-1">Edit Berita</h1>
            <p class="text-muted mb-0">Perbarui informasi berita.</p>
        </div>
        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Gagal menyimpan:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="judul" class="form-label">Judul</label>
                    <input type="text"
                           name="judul"
                           id="judul"
                           class="form-control @error('judul') is-invalid @enderror"
                           value="{{ old('judul', $post->judul) }}"
                           required>
                    @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="ringkasan" class="form-label">Ringkasan</label>
                    <textarea name="ringkasan"
                              id="ringkasan"
                              rows="3"
                              class="form-control @error('ringkasan') is-invalid @enderror"
                              required>{{ old('ringkasan', $post->ringkasan) }}</textarea>
                    @error('ringkasan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="konten" class="form-label">Konten</label>
                    <textarea name="konten"
                              id="konten"
                              rows="6"
                              class="form-control @error('konten') is-invalid @enderror"
                              required>{{ old('konten', $post->konten) }}</textarea>
                    @error('konten') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="kategori_id" class="form-label">Kategori</label>
                    <select name="kategori_id"
                            id="kategori_id"
                            class="form-select @error('kategori_id') is-invalid @enderror"
                            required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}"
                                @selected(old('kategori_id', $post->kategori_id) == $kategori->id)>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Gambar saat ini</label><br>
                    @if($post->gambar)
                        <img src="{{ asset('storage/'.$post->gambar) }}" alt="Gambar" style="max-width:220px" class="rounded border">
                    @else
                        <div class="text-muted">Belum ada gambar</div>
                    @endif
                </div>

                <div class="mb-4">
                    <label for="gambar" class="form-label">Ganti Gambar (opsional)</label>
                    <input type="file"
                           name="gambar"
                           id="gambar"
                           class="form-control @error('gambar') is-invalid @enderror">
                    @error('gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
