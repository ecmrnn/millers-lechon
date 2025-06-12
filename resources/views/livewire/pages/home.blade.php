<?php

use function Livewire\Volt\{state, layout};

layout('components.layouts.web');
?>

<div class="space-y-10">
    <section class="space-y-10 flex flex-col items-center justify-center">
        <div class="p-3 rounded-full bg-emerald-100/50 dark:bg-emerald-100/0">
            <flux:icon.ham class="text-emerald-600 dark:text-emerald-400" />
        </div>
        
        <hgroup class="space-y-3">
            <h1 class="md:text-6xl text-4xl font-serif text-center text-emerald-600 dark:text-emerald-400 font-bold md:leading-18">Original & Native <br> Miller's Lechon</h1>
            <flux:text class="text-base text-center max-w-sm mx-auto font-semibold">The crispiest, the crunchiest, and the juciest lechon you will ever taste!</flux:text>
        </hgroup>

        <flux:button variant="primary" href="{{ route('order') }}" wire:navigate>Order a Lechon</flux:button>
    </section>

    <div class="relative aspect-video overflow-hidden rounded-lg border border-zinc-200 dark:border-zinc-700">
        <x-placeholder-pattern class="absolute inset-0 size-full stroke-zinc-900/20 dark:stroke-zinc-100/20" />
    </div>
</div>
