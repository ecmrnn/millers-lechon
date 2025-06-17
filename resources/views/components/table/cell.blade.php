<td {{ $attributes->merge(['class' => 'px-5 py-3 dark:bg-zinc-700/25']) }}>
    <flux:text class="min-w-max">{{ $slot }}</flux:text>
</td>