<?php

use function Livewire\Volt\{state, layout};

layout('components.layouts.web');
?>

<div class="space-y-10">
    <section class="space-y-10 flex flex-col items-center justify-center">
        <div class="p-3 rounded-full bg-emerald-100/50 dark:bg-emerald-100/0">
            <flux:icon.inbox class="text-emerald-600 dark:text-emerald-400" />
        </div>
        
        <hgroup class="space-y-3">
            <h1 class="md:text-6xl text-4xl font-serif text-center text-emerald-600 dark:text-emerald-400 font-bold md:leading-18">Our Contacts</h1>
            <flux:text class="text-base text-center max-w-sm mx-auto font-semibold">If you have any inquiries, feel free to reach us out!</flux:text>
        </hgroup>
    </section>

    <section class="grid md:grid-cols-3 gap-5">
        <div class="p-5 border border-zinc-200 dark:border-zinc-700 dark:bg-zinc-700/50 rounded-lg space-y-5">
            <flux:icon.smartphone />

            <hgroup>
                <flux:heading size="lg">Contact Number</flux:heading>
                <flux:subheading>+63 917 208 1519</flux:subheading>
            </hgroup>
        </div>

        <div class="p-5 border border-zinc-200 dark:border-zinc-700 dark:bg-zinc-700/50 rounded-lg space-y-5">
            <flux:icon.phone />

            <hgroup>
                <flux:heading size="lg">Landline</flux:heading>
                <flux:subheading>+63 2 808 8080</flux:subheading>
            </hgroup>
        </div>

        <div class="p-5 border border-zinc-200 dark:border-zinc-700 dark:bg-zinc-700/50 rounded-lg space-y-5">
            <flux:icon.mail />

            <hgroup>
                <flux:heading size="lg">Email Address</flux:heading>
                <flux:subheading>millerslechon@gmail.com</flux:subheading>
            </hgroup>
        </div>
    </section>

    <section class="space-y-10">
        <hgroup class="text-center">
            <flux:heading size="xl">Send us an Email</flux:heading>
            <flux:subheading>Fill up the form then send your email</flux:subheading>
        </hgroup>

        <livewire:pages.send-email />
    </section>
</div>
