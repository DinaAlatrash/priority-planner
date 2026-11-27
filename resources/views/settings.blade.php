@extends('layouts.shell')

@section('title', 'Settings - Priority Planner')

@section('content')
<div id="app"
     data-page="settings"
     data-available-hours="{{ $availableHours }}"
     data-update-url="{{ route('settings.update') }}"
     data-csrf="{{ csrf_token() }}"></div>
@endsection