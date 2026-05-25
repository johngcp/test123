@extends('layouts.app')

@section('title', 'About')

@section('content')
    <h1>About</h1>
    <div class="card">
        <p>This is a clean Laravel-based test site used for experimentation.</p>
        <h2>What's included</h2>
        <ul style="margin-left: 1.5rem;">
            <li>Laravel {{ app()->version() }} on PHP {{ PHP_VERSION }}</li>
            <li>SQLite database (no external DB needed)</li>
            <li>Tasks CRUD demo (create, toggle, delete)</li>
            <li>JSON <code>/ping</code> endpoint for health checks</li>
        </ul>
    </div>
@endsection
