@extends('layouts.admin')
@section('title','Manajemen Berita')


@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-1">Manajemen Kategori</h1>
            <p class="text-muted mb-0">Kelola kategori berita</p>
        </div>
        <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary">
            + Tambah Kategori
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Kategori</th>
                            <th>Slug</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kategoris as $kategori)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kategori->nama }}</td>
                                <td>{{ $kategori->slug }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.kategori.edit', $kategori) }}"
                                       class="btn btn-sm btn-outline-primary me-1">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.kategori.destroy', $kategori) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Belum ada kategori.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $kategoris->links() }}
            </div>
        </div>
    </div>

</div>
@endsection
