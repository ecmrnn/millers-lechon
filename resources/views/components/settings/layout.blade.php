<div class="flex items-start max-md:flex-col h-full">
    <div class="p-6 lg:p-8 hidden lg:border-r border-zinc-200 dark:border-zinc-700 lg:flex flex-col justify-between h-full lg:w-[248px]">
        <flux:navlist variant="outline">
            <flux:navlist.group class="grid">
                <flux:navlist.item :href="route('settings.profile')" wire:navigate icon="circle-user-round">{{ __('Profile') }}</flux:navlist.item>
                <flux:navlist.item :href="route('settings.password')" wire:navigate icon="lock">{{ __('Password') }}</flux:navlist.item>
                <flux:navlist.item :href="route('settings.appearance')" wire:navigate icon="sun-moon">{{ __('Appearance') }}</flux:navlist.item>
            </flux:navlist.group>
        </flux:navlist>
    </div>

    <flux:separator class="md:hidden" />

    <div class="p-6 lg:p-8 flex-1 self-stretch max-md:pt-6">
        <flux:heading>{{ $heading ?? '' }}</flux:heading>
        <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>

        <div class="w-full max-w-lg">
            {{ $slot }}
        </div>
    </div>
</div>
