<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="/css/app.css">
        <link rel="stylesheet" href="/css/tdr.css">

        @livewireStyles

        @stack('styles')

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>

    </head>
    <body class="font-sans antialiased">

        <div x-data class="min-h-screen w-full"> <!-- removed x-cloak -->

            <!-- Page Heading -->
            <x-site-header />

            <!-- Page navigation -->
            @livewire('navigation-user')
            @livewire('navigation-menu')

            <!-- Page Content -->
            <main>

                {{ $slot }}
            </main>

            <x-site-footer />
        </div>

        @stack('modals')

        @livewireScripts

        @stack('scripts')
    </body>
</html>
