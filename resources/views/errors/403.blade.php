<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Access Denied</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css') <!-- Adjust if needed -->
</head>
<body class="bg-cover bg-center min-h-screen" style="background-image: url('/images/login-background.png');">
<div class="min-h-screen flex flex-col justify-center items-center">
    <h1 class="text-6xl font-bold text-white mb-6">403</h1>
    <h2 class="text-3xl font-semibold text-white mb-4">Access Denied</h2>
    <p class="text-white mb-8">You don't have permission to view this page.</p>

    <!-- Button to go back to the homepage -->
    <a href="/" class="bg-teal-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-teal-700 transition-colors">
        Go to Home Page
    </a>
</div>
</body>
</html>
