<?php

use Livewire\Volt\Component;
use function Livewire\Volt\{state};

state([
    'email' => '',
    'subject' => '',
    'body' => '',
]);

$submit = function () {
    $this->validate([
        'email' => 'required|email',
        'subject' => 'required|string|max:50|min:5',
        'body' => 'required|string|max:255',
    ]);
};
?>

<form method='post' class="max-w-sm mx-auto space-y-3" wire:submit='submit'>
    @csrf
    <flux:input wire:model='email' label="Your Email" type="email" placeholder="millers.lechon@order.now" clearable />
    <flux:input wire:model='subject' label="What's in your mind?" placeholder="Let's talk about a juicy lechon" clearable />
    <flux:textarea wire:model='body' label="Describe your idea" placeholder="..." resize="vertical" />

    <div class="md:flex justify-end">
        <flux:button variant="primary" type="submit" icon:trailing="send-horizontal" class="w-full md:w-auto">Send Email</flux:button>
    </div>
</form>