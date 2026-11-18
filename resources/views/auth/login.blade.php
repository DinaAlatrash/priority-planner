@extends('layouts.auth')

@section('title', 'Log in')

@section('content')
<h1 class="h4 text-center mb-1">Welcome back</h1>
<p class="text-center text-secondary mb-4">Log in to see your plan.</p>

<form method="POST" action="{{ route('login') }}">
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

    <div class="form-check mb-4">
        <input type="checkbox" id="remember" name="remember" class="form-check-input">
        <label for="remember" class="form-check-label">Remember me</label>
    </div>

    <button type="submit" class="btn btn-primary w-100">Log in</button>
</form>

<p class="text-center text-secondary mt-4 mb-0">
    New here? <a href="{{ route('register') }}">Create an account</a>
</p>
@endsection