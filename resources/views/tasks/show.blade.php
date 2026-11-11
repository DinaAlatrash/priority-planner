<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task - Priority Planner</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    <div id="app"
         data-page="tasks-show"
         data-task="{{ $task->toJson() }}"
         data-index-url="{{ route('tasks.index') }}"
         data-edit-url="{{ route('tasks.edit', $task) }}"
         data-delete-url="{{ route('tasks.destroy', $task) }}"
         data-csrf="{{ csrf_token() }}"></div>
</body>
</html>