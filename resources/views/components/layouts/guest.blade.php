<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - The Daily Word Game for Laravel Devs</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    {{ $styles ?? '' }}
</head>
<body class="welcome-page">
    <!-- Floating Cubes Background -->
    <div class="cubes-bg" aria-hidden="true">
        <div class="cube"></div>
        <div class="cube"></div>
        <div class="cube"></div>
        <div class="cube"></div>
        <div class="cube"></div>
        <div class="cube"></div>
        <div class="cube"></div>
        <div class="cube"></div>
        <div class="cube"></div>
        <div class="cube"></div>
        <div class="cube"></div>
        <div class="cube"></div>
    </div>

    @include('components.layouts.partials.nav')

    <main>
        {{ $slot }}
    </main>

    @include('components.layouts.partials.footer')

    {{ $scripts ?? '' }}
</body>
</html>