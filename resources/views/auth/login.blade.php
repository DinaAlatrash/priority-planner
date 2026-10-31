@extends('layouts.app')

@section('title', 'Log in')

@section('content')
<div class="container py-5" style="max-width: 440px;">
    <h1 class="h3 mb-4 text-center">Log in</h1>

    <form method="POST" action="{{ route('login') }}" class="card card-body shadow-sm">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror" required autofocus>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" id="remember" name="remember" class="form-check-input">
            <label for="remember" class="form-check-label">Remember me</label>
        </div>

        <button type="submit" class="btn btn-primary w-100">Log in</button>
    </form>

    <p class="text-center mt-3">New here? <a href="{{ route('register') }}">Create an account</a></p>
</div>
@endsection