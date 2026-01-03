@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-1">Profile</h1>
            <p class="text-muted mb-0">Atur informasi akun kamu dan daftar bacaan.</p>
        </div>
        <a href="{{ url('/home') }}" class="btn btn-secondary">Kembali</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Gagal:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

  
    <ul class="nav nav-tabs mb-3" id="profileTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="akun-tab" data-bs-toggle="tab" data-bs-target="#akun" type="button" role="tab">
                Info Akun
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab">
                Ganti Password
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="bacaan-tab" data-bs-toggle="tab" data-bs-target="#bacaan" type="button" role="tab">
                Daftar Bacaan
            </button>
        </li>
    </ul>

    <div class="tab-content" id="profileTabContent">
       
        <div class="tab-pane fade show active" id="akun" role="tabpanel">
            <div class="card">
                <div class="card-header bg-white"><strong>Info Akun</strong></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                   value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        
        <div class="tab-pane fade" id="password" role="tabpanel">
            <div class="card">
                <div class="card-header bg-white"><strong>Ganti Password</strong></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.password') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Password Lama</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="bacaan" role="tabpanel">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <strong>Daftar Bacaan</strong>
                    <small class="text-muted">Berita yang kamu simpan</small>
                </div>
                <div class="card-body">
                    @if(($savedPosts ?? collect())->count() === 0)
                        <div class="alert alert-info mb-0">Daftar bacaan kamu masih kosong.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm align-middle">
                                <thead>
                                    <tr>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Disimpan</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($savedPosts as $post)
                                        <tr>
                                            <td class="fw-semibold">{{ $post->judul }}</td>
                                            <td>{{ $post->kategori?->nama ?? '-' }}</td>
                                            <td>
                                                {{ optional($post->pivot->created_at)->format('d M Y H:i') }}
                                            </td>
                                            <td class="text-end">
                                                <div class="d-inline-flex gap-2">
                                                    <a class="btn btn-sm btn-outline-primary"
                                                       href="{{ route('berita.show', $post->slug) }}">
                                                        Baca
                                                    </a>

                                                    <form method="POST" action="{{ route('daftar-bacaan.toggle', $post) }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-2">
                            {{ $savedPosts->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
