<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Priority Planner')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/theme.css'])
    <style>
        body { min-height: 100vh; display: flex; align-items: center; }
        .auth-wrap { width: 100%; max-width: 420px; margin: 0 auto; padding: 24px 16px; }
        .brand { text-align: center; font-size: 22px; font-weight: 700; color: var(--primary); margin-bottom: 20px; }
        .auth-card { border-radius: 14px; box-shadow: 0 6px 24px rgba(47, 42, 36, 0.08); }
    </style>
</head>
<body>
    <div class="auth-wrap">
        <div class="brand">Priority Planner</div>
        <div class="card auth-card">
            <div class="card-body p-4">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>