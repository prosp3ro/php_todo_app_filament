<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>{{ $task->name }}</title>
    <!-- Filament CSS -->
    <link rel="stylesheet" href="{{ asset('css/filament/filament/app.css') }}">
    <!-- Tailwind CSS if you use it standalone -->
    <script src="{{ asset('js/filament/filament/app.js') }}"></script>
</head>
<body class="filament-body bg-gray-50">
    <div class="container mx-auto p-6">
        <div class="filament-page">
            <h1 class="text-3xl font-bold mb-4">Task: {{ $task->name }}</h1>
            <div class="filament-card p-6 bg-white rounded shadow">
                <p>Priority: {{ $task->priority }}</p>
                <p>Status: {{ $task->status }}</p>
                <p>Due date: {{ $task->due_date }}</p>
                <br>
                <p>{{ $task->description }}</p>
            </div>
        </div>
    </div>
</body>
</html>
