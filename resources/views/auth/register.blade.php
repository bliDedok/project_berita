@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width:520px;">
  <h1 class="h4 mb-3">Register</h1>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ url('/register') }}">
    @csrf

    <div class="mb-3">
      <label class="form-label">Nama</label>
      <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Konfirmasi Password</label>
      <input type="password" name="password_confirmation" class="form-control" required>
    </div>

    <button class="btn btn-primary w-100" type="submit">Daftar</button>

    <div class="mt-3">
      <a href="{{ url('/login') }}">Sudah punya akun? Login</a>
    </div>
  </form>
</div>
@endsection
