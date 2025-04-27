<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Cinetech') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-white">
        <!-- Pattern background -->
        <div id="pattern-bg" class="fixed inset-0 w-full h-full pointer-events-none z-0"></div>
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-10 pb-24">
            <div class="mt-6">
                <a href="/" class="flex items-center">
                    <x-application-logo class="w-20 h-20 fill-current text-red-500" />
                </a>
            </div>

            {{ $slot }}
        </div>
        <x-footer />
        <!-- Dot pattern script -->
        <script src="{{ asset('js/dotPattern.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const pattern = new DotPattern({
                    dotSize: 3,
                    dotSpacing: 40,
                    dotColor: 'rgba(255, 100, 50, 0.4)', // Orange theme
                    glowColor: 'rgba(255, 100, 50, 0.6)', // Orange theme
                    waveIntensity: 40,
                    waveRadius: 180
                });
                pattern.init('pattern-bg');
            });
        </script>
    </body>
</html>