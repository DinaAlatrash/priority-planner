@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<h1 class="h4 text-center mb-1">Create your account</h1>
<p class="text-center text-secondary mb-4">Know what to do first, every day.</p>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}"
               class="form-control @error('name') is-invalid @enderror" required>
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}"
               class="form-control @error('email') is-invalid @enderror" required>
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" id="password" name="password"
               class="form-control @error('password') is-invalid @enderror" required>
        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-4">
        <label for="password_confirmation" class="form-label">Confirm password</label>
        <input type="password" id="password_confirmation" name="password_confirmation"
               class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">Create account</button>
</form>

<p class="text-center text-secondary mt-4 mb-0">
    Already have an account? <a href="{{ route('login') }}">Log in</a>
</p>
@endsection