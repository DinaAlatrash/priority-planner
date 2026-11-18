@extends('layouts.shell')

@section('title', 'Board - Priority Planner')

@section('content')
<div id="app"
     data-page="tasks-board"
     data-tasks="{{ $tasks->toJson() }}"
     data-index-url="{{ route('tasks.index') }}"
     data-csrf="{{ csrf_token() }}"></div>
@endsection