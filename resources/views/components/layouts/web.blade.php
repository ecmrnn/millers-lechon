<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800 font-serif">
        <nav class="max-w-screen-lg mx-auto relative w-full">
            <flux:navbar class="absolute top-0 left-1/2 -translate-x-1/2">
                <flux:navbar.item href="{{ route('home') }}">Home</flux:navbar.item>
                <flux:navbar.item href="{{ route('home') }}">Services</flux:navbar.item>
                <flux:navbar.item href="{{ route('home') }}">Reservation</flux:navbar.item>
                <flux:navbar.item href="{{ route('home') }}">About</flux:navbar.item>
                <flux:navbar.item href="{{ route('home') }}">Contact</flux:navbar.item>
            </flux:navbar>
        </nav>

        <main class="max-w-screen-lg mx-auto">
            {{ $slot }}
        </main>

        @fluxScripts
    </body>
</html>
