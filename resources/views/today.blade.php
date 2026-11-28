@extends('layouts.shell')

@section('title', 'Today - Priority Planner')

@section('content')
<div id="app"
     data-page="today"
     data-planned="{{ $planned->toJson() }}"
     data-skipped="{{ $skipped->toJson() }}"
     data-available-minutes="{{ $availableMinutes }}"
     data-planned-minutes="{{ $plannedMinutes }}"
     data-left-minutes="{{ $leftMinutes }}"
     data-settings-url="{{ $settingsUrl }}"
     data-create-url="{{ route('tasks.create') }}"></div>
@endsection