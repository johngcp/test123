@extends('layouts.app')

@section('title', 'Tasks')

@section('content')
    <h1>Tasks</h1>

    <div class="card">
        <h2>Add a task</h2>
        @if ($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('tasks.store') }}">
            @csrf
            <div class="field">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required>
            </div>
            <div class="field">
                <label for="description">Description (optional)</label>
                <textarea id="description" name="description">{{ old('description') }}</textarea>
            </div>
            <button type="submit">Add task</button>
        </form>
    </div>

    <div class="card">
        <h2>{{ $tasks->count() }} {{ Str::plural('task', $tasks->count()) }}</h2>
        @forelse ($tasks as $task)
            <div class="task {{ $task->completed ? 'completed' : '' }}">
                <form method="POST" action="{{ route('tasks.toggle', $task) }}" class="inline-form">
                    @csrf
                    @method('PATCH')
                    <input type="checkbox" onchange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                </form>
                <div class="task-body">
                    <div class="task-title">{{ $task->title }}</div>
                    @if ($task->description)
                        <div class="task-desc">{{ $task->description }}</div>
                    @endif
                </div>
                <div class="task-actions">
                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="inline-form" onsubmit="return confirm('Delete this task?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty">No tasks yet. Add one above.</div>
        @endforelse
    </div>
@endsection
