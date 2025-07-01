<?php

use Livewire\Volt\Component;
use function Livewire\Volt\{title};

title('Orders');
?>

<div class="flex h-full">
    {{-- Sidebar Actions --}}
    <aside x-data="{ open: true }" class="p-6 lg:p-8 hidden lg:border-r border-zinc-200 dark:border-zinc-700 lg:flex flex-col justify-between">
        <div x-show="open" x-cloak>
            <flux:button icon:leading="plus" variant="primary" class="w-full">Create Order</flux:button>
            <flux:navlist variant="outline" class="mt-6">
                <flux:navlist.group class="grid">
                    <flux:navlist.item icon="notebook-text">{{ __('List Orders') }}</flux:navlist.item>
                    <flux:navlist.item icon="notebook-pen">{{ __('Draft Orders') }}</flux:navlist.item>
                    <flux:navlist.item icon="trash">{{ __('Archived Orders') }}</flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>
        </div>

        <div x-show="! open" x-cloak>
            <flux:tooltip content="Create Order" position="right">
                <flux:button icon="plus" variant="primary"/>
            </flux:tooltip>

            <div class="mt-6 grid">
                <flux:tooltip content="List Orders" position="right">
                    <flux:button icon="notebook-text" variant="ghost"/>
                </flux:tooltip>
                <flux:tooltip content="Draft Orders" position="right">
                    <flux:button icon="notebook-pen" variant="ghost"/>
                </flux:tooltip>
                <flux:tooltip content="Archived Orders" position="right">
                    <flux:button icon="trash" variant="ghost"/>
                </flux:tooltip>
            </div>
        </div>

        <div>
            <flux:tooltip content="Toggle Sidebar" position="right">
                <flux:button icon="chevron-right" variant="ghost" x-on:click="open = ! open" x-bind:class="open ? 'rotate-180' : 'rotate-0'" />
            </flux:tooltip>
        </div>
    </aside>

    {{-- Mobile Actions --}}
    <div x-data="{ open: false }" class="fixed bottom-6 right-6 lg:hidden z-0 flex flex-col items-end gap-3">
        <div x-show="open" x-cloak class="p-1 border rounded-lg bg-white dark:bg-zinc-700/50 border-zinc-200 dark:border-zinc-700"
            x-on:click.outside="open = false"
            x-transition>
            <flux:navlist.group>
                <flux:button icon:leading="plus" variant="primary" class="w-full">Create Order</flux:button>
                <flux:navlist.item icon="notebook-text">{{ __('List Orders') }}</flux:navlist.item>
                <flux:navlist.item icon="notebook-pen">{{ __('Draft Orders') }}</flux:navlist.item>
                <flux:navlist.item icon="trash">{{ __('Archived Orders') }}</flux:navlist.item>
            </flux:navlist.group>
        </div>

        <flux:button icon="plus" variant="primary" x-on:click="open = ! open" />
    </div>

    {{-- Main Content --}}
    <div class="p-6 lg:p-8 w-full">
        <div class="flex w-full gap-3 justify-between">
            <flux:button icon:leading="list-filter">Filter</flux:button>
            <flux:input icon="magnifying-glass" placeholder="Search orders" class="w-max" />
        </div>


    </div>
</div>
