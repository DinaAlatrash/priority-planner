@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Welcome, {{ auth()->user()->name }}</h1>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-secondary">Log out</button>
        </form>
    </div>

    <p class="text-muted">Your dashboard will be built here.</p>
</div>
@endsection