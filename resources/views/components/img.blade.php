@props([
    'aspect' => 'video',
    'src' => '',
    'alt' => '',
])

@if ($src && file_exists(public_path($src)))
    <img src="{{ $src }}" alt="{{ $alt ?? 'Delicious food' }}" {{ $attributes->merge(['class' => "w-full rounded-lg aspect-$aspect"]) }}>
@else
    <div {{ $attributes->merge(['class' => "grid place-items-center aspect-$aspect border rounded-lg border-zinc-200 bg-zinc-100/50 dark:bg-white/10 dark:border-white/10"]) }} class="">
        <flux:icon.image-off class=" min-w-3 w-1/2 max-w-12 opacity-50" />
    </div>
@endif