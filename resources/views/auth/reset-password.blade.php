@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width:520px;">
  <h1 class="h4 mb-3">Reset Password</h1>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ url('/reset-password') }}">
    @csrf

    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" value="{{ old('email', $request->email) }}" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Password Baru</label>
      <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Konfirmasi Password</label>
      <input type="password" name="password_confirmation" class="form-control" required>
    </div>

    <button class="btn btn-primary w-100" type="submit">Reset</button>
  </form>
</div>
@endsection
