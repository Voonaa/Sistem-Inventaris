<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Inventaris SMK SASMITA JAYA 2') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts and Styles -->
        @viteReactRefresh
        @vite(['resources/js/app.js', 'resources/css/app.css'])

        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @if(config('app.debug'))
            <div style="position: fixed; bottom: 0; left: 0; right: 0; background: #f0f0f0; padding: 10px; z-index: 9999; font-size: 12px;">
                <pre>
Environment: {{ app()->environment() }}
Is Production: {{ var_export($isProduction, true) }}
Base URL: {{ $baseUrl }}
CSS Path: {{ $baseUrl }}/build/app.css
JS Path: {{ $baseUrl }}/build/app.js
                </pre>
            </div>
        @endif

        <div class="min-h-screen bg-gray-100">
            {{ $slot }}
        </div>
    </body>
</html>
