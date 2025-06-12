<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        {{--
            Mobile Navigation
        --}}

        <nav x-data="{open: false}" class="flex w-full md:hidden justify-between items-center p-5 relative">
            <div class="flex gap-5 items-center">
                <flux:button icon="menu" x-on:click="open = !open"></flux:button>
                <x-app-logo />
            </div>

            <flux:button x-data x-on:click="$flux.dark = ! $flux.dark" variant="ghost" square>
                <flux:icon.moon class="text-emerald-600 dark:text-emerald-400" />
            </flux:button>

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

                <flux:navbar class="absolute left-0 h-svh p-5! flex flex-col items-start bg-white/90 dark:bg-zinc-800/90 backdrop-blur-md w-full">
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

        <nav class="border-b border-dotted border-zinc-300 dark:border-zinc-600">
            <div class="max-w-screen-lg mx-auto hidden relative w-full md:flex justify-between items-center px-5 py-2 border-x border-dotted border-zinc-300 dark:border-zinc-600">
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

                <flux:button x-data x-on:click="$flux.dark = ! $flux.dark" variant="ghost" square>
                    <flux:icon.moon class="text-emerald-600 dark:text-emerald-400" />
                </flux:button>
            </div>
        </nav>

        <main class="max-w-screen-lg mx-auto p-5 pt-10 md:p-10 min-h-svh md:border-x border-dotted border-zinc-300 dark:border-zinc-600">
            {{ $slot }}
        </main>

        <footer class="bg-emerald-800 text-white">
            <div class="max-w-screen-lg p-5 md:p-10 mx-auto flex justify-between flex-col md:flex-row gap-10">
                <div class="space-y-5">
                    <hgroup>
                        <h2 class="text-white font-serif text-3xl font-bold">Miller's Lechon</h2>
                        <address class="not-italic">410 Manila East Rd., Hulo, Pililla, Rizal</address>
                    </hgroup>

                    <div>
                        <flux:button class="text-white!" icon='facebook' href='' variant="ghost" />
                        <flux:button class="text-white!" icon='instagram' href='' variant="ghost" />
                    </div>
                </div>

                <nav class="space-y-1 md:text-right">
                    <a class="block" wire:navigate href="{{ route('home') }}">Home</a>
                    <a class="block" wire:navigate href="{{ route('services') }}">Services</a>
                    <a class="block" wire:navigate href="{{ route('order') }}">Order</a>
                    <a class="block" wire:navigate href="{{ route('about') }}">About</a>
                    <a class="block" wire:navigate href="{{ route('contact') }}">Contact</a>
                </nav>
            </div>

            <div class="bg-emerald-700 font-semibold text-white text-xs">
                <div class="p-5 md:px-10 max-w-screen-lg flex justify-between mx-auto">
                    <p>Copyright &copy; {{ date('Y') }} Miller&apos;s Lechon. All Rights Reserved.</p>
                    <p class="text-right">dev: ecmrnn</p>
                </div>
            </div>
        </footer>

        @persist('toast')
            <x-toast />
        @endpersist

        @fluxScripts
    </body>
</html>
