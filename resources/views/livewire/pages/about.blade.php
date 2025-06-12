<?php

use function Livewire\Volt\{state, layout};

layout('components.layouts.web');
?>

<div class="space-y-10">
    <section class="space-y-10 flex flex-col items-center justify-center">
        <div class="p-3 rounded-full bg-emerald-100/50 dark:bg-emerald-100/0">
            <flux:icon.scroll-text class="text-emerald-600 dark:text-emerald-400" />
        </div>
        
        <hgroup class="space-y-3">
            <h1 class="md:text-6xl text-4xl font-serif text-center text-emerald-600 dark:text-emerald-400 font-bold md:leading-18">Our Story</h1>
            <flux:text class="text-base text-center max-w-sm mx-auto font-semibold">The Legacy of Mang Johnny</flux:text>
        </hgroup>
    </section>

    <div class="relative aspect-video overflow-hidden rounded-lg border border-zinc-200 dark:border-zinc-700">
        <x-placeholder-pattern class="absolute inset-0 size-full stroke-zinc-900/20 dark:stroke-zinc-100/20" />
    </div>

    <div class="flex flex-col md:flex-row gap-10 justify-around py-10">
        <div class="text-center">
            <flux:text>Lechon Served</flux:text>
            <flux:heading size="xl" class="text-3xl md:text-4xl">3,000</flux:heading>
        </div>

        <flux:separator class="md:hidden" />
        <flux:separator vertical class="hidden my-2 md:block" />

        <div class="text-center">
            <flux:text>Order Received</flux:text>
            <flux:heading size="xl" class="text-3xl md:text-4xl">3,250</flux:heading>
        </div>
        
        <flux:separator class="md:hidden" />
        <flux:separator vertical class="hidden my-2 md:block" />
        
        <div class="text-center">
            <flux:text>Cravings Satisfied</flux:text>
            <flux:heading size="xl" class="text-3xl md:text-4xl">5,000</flux:heading>
        </div>
    </div>

    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-5">
        <div class="relative aspect-video overflow-hidden rounded-lg border border-zinc-200 dark:border-zinc-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-zinc-900/20 dark:stroke-zinc-100/20" />
        </div>
        <div class="relative aspect-video overflow-hidden hidden sm:block rounded-lg border border-zinc-200 dark:border-zinc-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-zinc-900/20 dark:stroke-zinc-100/20" />
        </div>
        <div class="relative aspect-video overflow-hidden hidden md:block rounded-lg border border-zinc-200 dark:border-zinc-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-zinc-900/20 dark:stroke-zinc-100/20" />
        </div>
    </div>

    <div class="grid sm:grid-cols-2 gap-5">
        <hgroup>
            <flux:text class="font-semibold">Serving Lechon since</flux:text>
            <flux:heading size="xl" class="text-3xl">1900</flux:heading>
        </hgroup>

        <flux:text class="text-justify indent-5">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint ut autem ipsam et totam qui sequi, odio aperiam? Odio excepturi voluptate quas explicabo dolorum. Atque inventore vel suscipit, accusamus sed itaque nisi tempore aliquid velit sint aperiam tenetur, voluptates blanditiis? Dignissimos ex illum ut voluptatum iste consectetur, saepe atque beatae.
            <br><br>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint ut autem ipsam et totam qui sequi, odio aperiam? Odio excepturi voluptate quas explicabo dolorum. Atque inventore vel suscipit, accusamus sed itaque nisi tempore aliquid velit sint aperiam tenetur, voluptates blanditiis? Dignissimos ex illum ut voluptatum iste consectetur, saepe atque beatae.
        </flux:text>
    </div>
</div>
