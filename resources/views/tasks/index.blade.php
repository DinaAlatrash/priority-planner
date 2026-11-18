@extends('layouts.shell')

@section('title', 'My tasks - Priority Planner')

@section('content')
<div id="app"
     data-page="tasks-index"
     data-tasks="{{ $tasks->toJson() }}"
     data-create-url="{{ route('tasks.create') }}"></div>
@endsection