@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-1">Manajemen Berita</h1>
            <p class="text-muted mb-0">Kelola daftar berita yang telah dibuat.</p>
        </div>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">Tambah Berita</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Penulis</th>
                            <th>Dibuat</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($posts as $post)
                            <tr>
                                <td>{{ $loop->iteration + ($posts->currentPage() - 1) * $posts->perPage() }}</td>
                                <td>{{ $post->judul }}</td>
                                <td>{{ $post->kategori->nama ?? '-' }}</td>
                                <td>{{ $post->user->name ?? '-' }}</td>
                                <td>{{ optional($post->created_at)->format('d M Y') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-outline-primary me-1">Edit</a>
                                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus berita ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada berita yang dibuat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
