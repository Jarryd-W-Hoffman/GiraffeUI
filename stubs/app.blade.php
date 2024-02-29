<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Meta tags for character set and viewport -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Page title, with default fallback -->
        <title>{{ $title ?? 'Page Title' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Vite asset inclusion with livewire styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="antialiased" x-data="{ 'darkMode': false }" x-init="
        // Initialize darkMode based on localStorage.
        darkMode = JSON.parse(localStorage.getItem('darkMode'));

        // Watch for changes in darkMode and update localStorage accordingly.
        $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    >
        <!-- Main Application Layout with dark mode support -->
        <div :class="{'dark': darkMode === true}">
            {{ $slot }}
        </div>
        <!-- Livewire scripts -->
        @livewireScripts
    </body>
</html>
