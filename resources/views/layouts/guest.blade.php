<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Tailwind Utility -->
    <style>
        body {
            background: linear-gradient(to bottom right, #e0f2fe, #f0fdf4);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center font-sans antialiased">
    <div class="w-full max-w-md p-8 bg-white rounded-2xl shadow-2xl animate-fadeIn">
        <div class="flex justify-center mb-6">
            <x-application-logo class="w-12 h-12 text-indigo-500" />
        </div>

        {{ $slot }}
    </div>
</body>
</html>
