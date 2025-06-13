@props(['heading' => ''])

<div x-data="{ open: false }" class="" x-on:click.outside="open ? open = false : ''">
    <button type="button" class="flex w-full justify-between items-start px-5 py-3 cursor-pointer group" x-on:click="open = ! open">
        <flux:heading size="lg"
            class="text-left transition-all ease-in-out duration-200"
            x-bind:class="open ? 'text-emerald-600 dark:text-emerald-400' : 'dark:text-white' ">
            {{ $heading }}
        </flux:heading>
        <flux:icon.chevron-down class="size-4 mt-1 transition-all ease-in-out duration-200 group-hover:opacity-100" x-bind:class="open ? 'rotate-180 opacity-100' : 'opacity-50' " />
    </button>

    <div x-show="open" x-collapse x-cloak>
        <flux:text class="max-w-md p-5 pt-0">{{ $slot }}</flux:text>
    </div>
</div>