@extends('layouts.shell')

@section('title', 'Task - Priority Planner')

@section('content')
<div id="app"
     data-page="tasks-show"
     data-task="{{ $task->toJson() }}"
     data-index-url="{{ route('tasks.index') }}"
     data-edit-url="{{ route('tasks.edit', $task) }}"
     data-delete-url="{{ route('tasks.destroy', $task) }}"
     data-subtask-store-url="{{ route('subtasks.store', $task) }}"
     data-csrf="{{ csrf_token() }}"></div>
@endsection