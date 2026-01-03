@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width:520px;">
  <h1 class="h4 mb-3">Lupa Password</h1>

  @if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ url('/forgot-password') }}">
    @csrf
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
    </div>
    <button class="btn btn-primary w-100" type="submit">Kirim Link Reset</button>
  </form>

  <div class="mt-3">
    <a href="{{ url('/login') }}">Kembali ke login</a>
  </div>
</div>
@endsection
