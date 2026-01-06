@extends('layouts.admin')

@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-3">
    <div>
        <h1 class="h3 mb-1">Manajemen Users</h1>
        <p class="text-muted mb-0">Daftar akun yang terdaftar di sistem.</p>
    </div>

    <form class="d-flex gap-2" method="GET" action="{{ route('admin.users.index') }}">
        <div class="input-group">
            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
            <input type="text" name="q" class="form-control" placeholder="Cari nama / email..."
                   value="{{ request('q') }}">
        </div>
        <button class="btn btn-primary">Cari</button>
    </form>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:70px">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th style="width:170px">Dibuat</th>
                        <th style="width:170px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $i => $u)
                        <tr>
                            <td class="text-muted">{{ $users->firstItem() + $i }}</td>
                            <td class="fw-semibold">{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td class="text-muted">{{ optional($u->created_at)->format('d M Y') }}</td>
                            <td class="text-start">
                                <form method="POST"
                                    action="{{ route('admin.users.destroy', $u) }}"
                                    onsubmit="return confirm('Yakin hapus user: {{ $u->name }} ?')"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-outline-danger"
                                            {{ auth()->id() === $u->id ? 'disabled' : '' }}>
                                        hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada user.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($users->hasPages())
        <div class="card-footer bg-white">
            {{-- aman untuk bootstrap 5 --}}
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
