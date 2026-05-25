<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Test Site') · Laravel Test Site</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: #f7f8fa;
            color: #1f2937;
            line-height: 1.5;
        }
        header {
            background: #111827;
            color: #fff;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header a { color: #fff; text-decoration: none; margin-left: 1.5rem; }
        header a:hover { color: #93c5fd; }
        header .brand { font-weight: 700; font-size: 1.15rem; margin: 0; }
        main { max-width: 800px; margin: 2rem auto; padding: 0 1.5rem; }
        h1 { font-size: 2rem; margin-bottom: 1rem; }
        h2 { font-size: 1.4rem; margin: 1.5rem 0 0.75rem; }
        p { margin-bottom: 1rem; }
        .card {
            background: #fff;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            margin-bottom: 1rem;
        }
        .flash {
            background: #d1fae5;
            color: #065f46;
            padding: 0.75rem 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
        }
        form .field { margin-bottom: 0.75rem; }
        label { display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.25rem; }
        input[type=text], textarea {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-family: inherit;
            font-size: 0.95rem;
        }
        textarea { min-height: 70px; resize: vertical; }
        button, .btn {
            background: #2563eb;
            color: #fff;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.9rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        button:hover, .btn:hover { background: #1d4ed8; }
        .btn-danger { background: #dc2626; }
        .btn-danger:hover { background: #b91c1c; }
        .btn-secondary { background: #6b7280; }
        .btn-secondary:hover { background: #4b5563; }
        .task { display: flex; align-items: flex-start; gap: 0.75rem; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb; }
        .task:last-child { border-bottom: none; }
        .task-body { flex: 1; }
        .task-title { font-weight: 600; }
        .task-desc { font-size: 0.875rem; color: #6b7280; margin-top: 0.25rem; }
        .task.completed .task-title { text-decoration: line-through; color: #9ca3af; }
        .task-actions { display: flex; gap: 0.5rem; }
        .errors { background: #fee2e2; color: #991b1b; padding: 0.75rem 1rem; border-radius: 6px; margin-bottom: 1rem; }
        .errors ul { margin-left: 1.25rem; }
        .empty { color: #9ca3af; text-align: center; padding: 2rem 0; }
        .inline-form { display: inline; }
    </style>
</head>
<body>
    <header>
        <h1 class="brand">Laravel Test Site</h1>
        <nav>
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('tasks.index') }}">Tasks</a>
            <a href="{{ route('about') }}">About</a>
            <a href="{{ route('ping') }}">Ping</a>
        </nav>
    </header>
    <main>
        @if (session('status'))
            <div class="flash">{{ session('status') }}</div>
        @endif
        @yield('content')
    </main>
</body>
</html>
