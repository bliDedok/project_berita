@extends('layouts.admin')

@section('content')
<div class="container">
    <h3>{{ isset($kategori) ? 'Edit' : 'Tambah' }} Kategori</h3>

    <form method="POST"
          action="{{ isset($kategori) 
            ? route('admin.kategori.update', $kategori)
            : route('admin.kategori.store') }}">
        @csrf
        @isset($kategori) @method('PUT') @endisset

        <div class="mb-3">
            <label>Nama Kategori</label>
            <input type="text" name="nama" class="form-control"
                   value="{{ old('nama', $kategori->nama ?? '') }}" required>
        </div>

        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
