<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Board - Priority Planner</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    <div id="app"
         data-page="tasks-board"
         data-tasks="{{ $tasks->toJson() }}"
         data-index-url="{{ route('tasks.index') }}"
         data-csrf="{{ csrf_token() }}"></div>
</body>
</html>