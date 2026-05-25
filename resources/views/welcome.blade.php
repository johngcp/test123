@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <h1>Welcome to the Test Site</h1>
    <div class="card">
        <p>A minimal Laravel app for poking at things. Use the navigation above to explore.</p>
        <p>
            <a href="{{ route('tasks.index') }}" class="btn">Open the tasks demo →</a>
        </p>
    </div>

    <div class="card">
        <h2>Quick links</h2>
        <ul style="margin-left: 1.5rem;">
            <li><a href="{{ route('tasks.index') }}">/tasks</a> — CRUD demo backed by SQLite</li>
            <li><a href="{{ route('about') }}">/about</a> — what this app is</li>
            <li><a href="{{ route('ping') }}">/ping</a> — JSON health check</li>
        </ul>
    </div>
@endsection
