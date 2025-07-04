<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SMK SASMITA - Sistem Inventaris') }}</title>
        
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('assets/images/logosmk.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="min-h-screen flex flex-col justify-center items-center">
            <div class="w-full max-w-[480px] bg-white rounded-lg shadow-md p-8 mx-4">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
