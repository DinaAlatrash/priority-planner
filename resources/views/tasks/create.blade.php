@extends('layouts.app')

@section('title', 'Add task')

@section('content')
<div class="container py-5" style="max-width: 560px;">
    <h1 class="h4 mb-4">Add a task</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('tasks.store') }}" class="card card-body shadow-sm">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}"
                   class="form-control @error('title') is-invalid @enderror" required>
            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description (optional)</label>
            <textarea id="description" name="description" rows="3"
                      class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="deadline" class="form-label">Deadline (optional)</label>
            <input type="datetime-local" id="deadline" name="deadline" value="{{ old('deadline') }}"
                   class="form-control @error('deadline') is-invalid @enderror">
            @error('deadline') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="estimated_minutes" class="form-label">Estimated time (minutes)</label>
            <input type="number" id="estimated_minutes" name="estimated_minutes" min="1" max="1440"
                   value="{{ old('estimated_minutes') }}"
                   class="form-control @error('estimated_minutes') is-invalid @enderror" required>
            @error('estimated_minutes') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label for="importance" class="form-label">How important is it?</label>
            <select id="importance" name="importance"
                    class="form-select @error('importance') is-invalid @enderror" required>
                @foreach (['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('importance', 'medium') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            @error('importance') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save task</button>
    </form>
</div>
@endsection