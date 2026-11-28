<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Priority Planner')</title>
    @stack('head')
    @vite(['resources/js/app.js'])
    <style>
        .shell { display: flex; min-height: 100vh; }
        .main { flex: 1; min-width: 0; }
        #sidebar { flex: 0 0 auto; }
        @media (max-width: 720px) {
            .shell { flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="shell">
        <div id="sidebar"
             data-user-name="{{ auth()->user()->name }}"
             data-tasks-url="{{ route('tasks.index') }}"
             data-today-url="{{ route('today.show') }}"
             data-board-url="{{ route('tasks.board') }}"
             data-create-url="{{ route('tasks.create') }}"
             data-settings-url="{{ route('settings.show') }}"
             data-logout-url="{{ route('logout') }}"
             data-csrf="{{ csrf_token() }}"></div>

        <main class="main">
            @yield('content')
        </main>
    </div>
</body>
</html>