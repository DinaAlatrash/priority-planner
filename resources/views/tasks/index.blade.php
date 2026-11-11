<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My tasks - Priority Planner</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    <div id="app"
         data-page="tasks-index"
         data-tasks="{{ $tasks->toJson() }}"
         data-create-url="{{ route('tasks.create') }}"></div>
</body>
</html>