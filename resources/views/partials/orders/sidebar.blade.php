<aside x-data="{ open: true }" class="p-6 lg:p-8 hidden lg:border-r border-zinc-200 dark:border-zinc-700 lg:flex flex-col justify-between shrink-0"
    x-bind:class="open ? 'lg:w-[248px]' : 'w-max'">
    <div x-show="open" x-cloak>
        <flux:modal.trigger name="create-order">
            <flux:button icon:leading="plus" variant="primary" class="w-full">Create Order</flux:button>
        </flux:modal>

        <flux:navlist variant="outline" class="mt-6">
            <flux:navlist.group class="grid">
                <flux:navlist.item icon="notebook-text">{{ __('List Orders') }}</flux:navlist.item>
                <flux:navlist.item icon="notebook-pen">{{ __('Draft Orders') }}</flux:navlist.item>
                <flux:navlist.item icon="trash-2">{{ __('Archived Orders') }}</flux:navlist.item>
            </flux:navlist.group>
        </flux:navlist>
    </div>

    <div x-show="! open" x-cloak>
        <flux:modal.trigger name="create-order">
            <flux:tooltip content="Create Order" position="right">
                <flux:button icon="plus" variant="primary"/>
            </flux:tooltip>
        </flux:modal.trigger>

        <div class="mt-6 grid">
            <flux:tooltip content="List Orders" position="right">
                <flux:button icon="notebook-text" variant="ghost"/>
            </flux:tooltip>
            <flux:tooltip content="Draft Orders" position="right">
                <flux:button icon="notebook-pen" variant="ghost"/>
            </flux:tooltip>
            <flux:tooltip content="Archived Orders" position="right">
                <flux:button icon="trash-2" variant="ghost"/>
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
            <flux:modal.trigger name="create-order">
                <flux:button icon:leading="plus" variant="primary" class="w-full">Create Order</flux:button>
            </flux:modal.trigger>

            <flux:navlist.item icon="notebook-text">{{ __('List Orders') }}</flux:navlist.item>
            <flux:navlist.item icon="notebook-pen">{{ __('Draft Orders') }}</flux:navlist.item>
            <flux:navlist.item icon="trash-2">{{ __('Archived Orders') }}</flux:navlist.item>
        </flux:navlist.group>
    </div>

    <flux:button icon="plus" variant="primary" x-on:click="open = ! open" />
</div>