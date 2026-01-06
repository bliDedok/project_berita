@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width:480px;">
  <h1 class="h4 mb-3">Login</h1>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
      </ul>
    </div>
  @endif

  @if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  <form method="POST" action="{{ url('/login') }}">
    @csrf

    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email"
             name="{{ config('fortify.username') }}"
             value="{{ old(config('fortify.username')) }}"
             class="form-control" required autofocus>
    </div>

    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>

    <button class="btn btn-primary w-100" type="submit">Masuk</button>

    <div class="d-flex justify-content-between mt-3">
      <a href="{{ url('/register') }}">Register</a>
    </div>
  </form>
</div>
@endsection
