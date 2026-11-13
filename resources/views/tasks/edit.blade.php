@extends('layouts.app')

@section('title', 'Edit task')

@section('content')
<div class="container py-5" style="max-width: 560px;">
    <h1 class="h4 mb-4">Edit task</h1>

    <form method="POST" action="{{ route('tasks.update', $task) }}" class="card card-body shadow-sm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" id="title" name="title" value="{{ old('title', $task->title) }}"
                   class="form-control @error('title') is-invalid @enderror" required>
            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description (optional)</label>
            <textarea id="description" name="description" rows="3"
                      class="form-control @error('description') is-invalid @enderror">{{ old('description', $task->description) }}</textarea>
            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="deadline" class="form-label">Deadline (optional)</label>
            <input type="datetime-local" id="deadline" name="deadline"
                   value="{{ old('deadline', $task->deadline?->format('Y-m-d\TH:i')) }}"
                   class="form-control @error('deadline') is-invalid @enderror">
            @error('deadline') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="estimated_minutes" class="form-label">Estimated time (minutes)</label>
            <input type="number" id="estimated_minutes" name="estimated_minutes" min="1" max="1440"
                   value="{{ old('estimated_minutes', $task->estimated_minutes) }}"
                   class="form-control @error('estimated_minutes') is-invalid @enderror" required>
            @error('estimated_minutes') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label for="importance" class="form-label">How important is it?</label>
            <select id="importance" name="importance"
                    class="form-select @error('importance') is-invalid @enderror" required>
                @foreach (['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('importance', $task->importance) === $value)>{{ $label }}</option>
                @endforeach
            </select>
            @error('importance') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Save changes</button>
            <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection