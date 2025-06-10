<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800 px-5">
        {{--
            Mobile Navigation
        --}}

        <nav x-data="{open: false}" class="flex w-full md:hidden justify-between items-center py-5 relative">
            <div class="flex gap-5 items-center">
                <flux:button icon="menu" x-on:click="open = !open"></flux:button>
                <x-app-logo />
            </div>

            <flux:button x-data x-on:click="$flux.dark = ! $flux.dark" icon="moon" variant="subtle" aria-label="Toggle dark mode" />

            {{-- Sidebar --}}
            <div x-show="open" x-cloak class="fixed top-0 left-0 h-svh w-screen z-50"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                >
                <div class="absolute inset-0 bg-black/50" x-on:click="open = false"></div>

                <flux:navbar class="absolute left-0 h-svh p-5! flex flex-col items-start bg-white/90 dark:bg-zinc-800/90 backdrop-blur-md w-2/3">
                    <div class="space-y-5 w-full">
                        <flux:button icon="x" x-on:click="open = false"></flux:button>

                        <flux:navlist class="w-full">
                            <flux:navlist.item wire:navigate href="{{ route('home') }}">Home</flux:navlist.item>
                            <flux:navlist.item wire:navigate href="{{ route('services') }}">Services</flux:navlist.item>
                            <flux:navlist.group heading="Order" expandable>
                                <flux:navlist.item wire:navigate href="{{ route('order') }}">Order a Lechon</flux:navlist.item>
                                <flux:navlist.item wire:navigate href="{{ route('order') }}">Find my Order</flux:navlist.item>
                            </flux:navlist.group>
                            <flux:navlist.item wire:navigate href="{{ route('about') }}">About</flux:navlist.item>
                            <flux:navlist.item wire:navigate href="{{ route('contact') }}">Contact</flux:navlist.item>
                        </flux:navlist>
                    </div>
                </flux:navbar>
            </div>
        </nav>

        {{--
            Desktop Navigation
        --}}

        <nav class="max-w-screen-lg mx-auto hidden relative w-full md:flex justify-between items-center py-5">
            <x-app-logo />

            <flux:navbar class="">
                <flux:navbar.item wire:navigate href="{{ route('home') }}">Home</flux:navbar.item>
                <flux:navbar.item wire:navigate href="{{ route('services') }}">Services</flux:navbar.item>

                <flux:dropdown>
                    <flux:navbar.item icon:trailing="chevron-down">Order</flux:navbar.item>
                    <flux:navmenu>
                        <flux:navmenu.item wire:navigate href="{{ route('order') }}">Order a Lechon</flux:navmenu.item>
                        <flux:navmenu.item wire:navigate href="{{ route('order') }}">Find my Order</flux:navmenu.item>
                    </flux:navmenu>
                </flux:dropdown>

                <flux:navbar.item wire:navigate href="{{ route('about') }}">About</flux:navbar.item>
                <flux:navbar.item wire:navigate href="{{ route('contact') }}">Contact</flux:navbar.item>
            </flux:navbar>

            <flux:button x-data x-on:click="$flux.dark = ! $flux.dark" icon="moon" variant="subtle" aria-label="Toggle dark mode" />
        </nav>

        <main class="max-w-screen-lg mx-auto mb-5">
            {{ $slot }}
        </main>

        @persist('toast')
            <x-toast />
        @endpersist

        @fluxScripts
    </body>
</html>
