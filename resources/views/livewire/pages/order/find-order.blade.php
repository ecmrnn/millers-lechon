<?php

use Livewire\Volt\Component;
use App\Traits\WithToast;
use App\Models\Order;
use App\Enums\OrderStatus;
use function Livewire\Volt\{state, layout, mount, rules, uses};

uses([WithToast::class]);

state([
    'order_number' => '',
    'order' => [],
    'statuses' => [],
]);

rules()->messages([
    'order_number.exists' => "Order does not exists.",
]);

mount(function ($id = null) {
    if ($id) {
        $this->order_number = $id;
        $this->findOrder();
    }
});

$findOrder = function () {
    $this->validate([
        'order_number' => 'required|exists:orders',
    ]);

    $this->order = Order::whereOrderNumber($this->order_number)
        ->with('lechons.freebie')
        ->first();

    $this->statuses = OrderStatus::forPickUp();

    if (! $this->order->is_pickup) {
        $this->statuses = OrderStatus::forDelivery();
    } 
    
    $this->toast('Order found!');
};

layout('components.layouts.web');
?>

<div class="space-y-10">
    @if ($order)
        <div x-data="{ open: false }">
            <div class="flex justify-between gap-5">
                <div>
                    <flux:heading>Your order status is: <flux:modal.trigger name="order-history" class="text-emerald-600 dark:text-emerald-400 cursor-pointer"><flux:link class="inline">{{ $order->status->label() }}</flux:link></flux:modal.trigger></flux:heading>
                    <flux:text class="mt-2">Last update at {{ date_format(date_create($order->created_at), 'F j, Y - g:i A') }}</flux:text>
                </div>

                <flux:modal.trigger name="order-history">
                    <flux:button variant="primary">More Details</flux:button>
                </flux:modal.trigger>
            </div>

            <flux:modal name="order-history" class="max-w-lg w-full">
                <div class="space-y-5">
                    <hgroup>
                        <flux:heading size="xl">Order History</flux:heading>
                        <flux:text>Track the status of your order here</flux:text>
                    </hgroup>

                    <div class="p-5 border rounded-lg border-zinc-200 dark:border-zinc-700 dark:bg-zinc-700/50">
                        @foreach ($statuses as $key => $status)
                            <div key="status-{{ $key }}">
                                <div class="flex gap-5">
                                    <div class="flex flex-col items-center">
                                        @if ($status->value <= $order->status->value)
                                            <flux:icon.circle-check class="text-emerald-600 dark:text-emerald-400 border rounded-full border-emerald-600 dark:border-emerald-400" />
                                            @if (!$loop->last)
                                                <div class="h-8 w-px bg-emerald-600 dark:bg-emerald-400"></div>
                                            @endif
                                        @else
                                            <flux:icon.circle class="text-zinc-800/25 dark:text-white/50 rounded-full border border-zinc-200 dark:border-zinc-700" />
                                            @if (!$loop->last)
                                                <div class="h-8 w-px bg-zinc-200 dark:bg-zinc-700"></div>
                                            @endif
                                        @endif
                                    </div>

                                    <hgroup>
                                        <flux:heading>{{ $status->label() }}</flux:heading>
                                        @if ($order->status == $status)
                                            <flux:text>{{ date_format(date_create($order->updated_at), 'F j, Y - g:i A') }}</flux:text>
                                        @elseif ($status->value < $order->status->value)
                                            <flux:text>{{ $status->summary() }}</flux:text>
                                        @endif
                                    </hgroup>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </flux:modal>
        </div>

        <div class="grid md:grid-cols-2 gap-5">
            <flux:callout icon="contact-round">
                <flux:callout.heading>Personal Details</flux:callout.heading>
                <flux:callout.text>
                    <div>
                        <p><strong>Name</strong>: {{ ucwords(strtolower($order->customer->first_name)) . ' ' . ucwords(strtolower($order->customer->last_name)) }}</p>
                        <p><strong>Address</strong>: {{ $order->customer->address }}</p>
                        <p><strong>Email</strong>: {{ $order->customer->email }}</p>
                        <p><strong>Contact Number</strong>: +63{{ $order->customer->contact_number }}</p>
                    </div>
                </flux:callout.text>
            </flux:callout>
            <flux:callout icon="receipt-text">
                <flux:callout.heading>Reservation Details</flux:callout.heading>
                <flux:callout.text>
                    <div>
                        <p><strong>Order Date and Time</strong>: {{ date_format(date_create($order->order_date), 'F j, Y \a\t g:i A') }}</p>
                        <p><strong>Shipping Option</strong>: {{ $order->is_pickup ? 'Pick Up' : 'Delivery' }}</p>
                        @if (! $order->is_pickup)
                            <p><strong>Delivery Address</strong>: {{ $order->delivery_address }}</p>
                        @endif
                        @if ($order->note)
                            <p><strong>Note</strong>: {{ $order->note }}</p>
                        @endif
                    </div>
                </flux:callout.text>
            </flux:callout>
        </div>

        <flux:heading size="lg">Order Summary</flux:heading>

        <div class="space-y-5">
            <x-table>
                <x-table.columns>
                    <x-table.column class="w-9">Qty</x-table.column>
                    <x-table.column>Lechon Size</x-table.column>
                    <x-table.column>Freebie</x-table.column>
                    <x-table.column class="text-right">Price</x-table.column>
                </x-table.columns>
                <x-table.rows>
                    @foreach ($order->lechons as $key => $lechon)
                        <x-table.row>
                            <x-table.cell>{{ $lechon->pivot->quantity }}</x-table.cell>
                            <x-table.cell>Lechon {{ $lechon->size }}</x-table.cell>
                            <x-table.cell>{{ $lechon->freebie->name }}</x-table.cell>
                            <x-table.cell class="text-right">Php{{ number_format($lechon->pivot->price, 2) }}</x-table.cell>
                        </x-table.row>
                    @endforeach
                </x-table.rows>
            </x-table>
            <div class="sm:flex justify-end sm:pr-5">
                @if ($order->status != OrderStatus::ORDERED)
                    <div class="grid grid-cols-2 gap-5 sm:w-max">
                        {{-- Sub Total --}}
                        <flux:heading size="lg">Subtotal</flux:heading>
                        <flux:heading size="lg" class="text-right">Php{{ number_format($order->billing->sub_total, 2) }}</flux:heading>

                        {{-- Deductions --}}
                        <flux:text>LESS: Payments</flux:text>
                        <div>
                            @foreach ($order->billing->payments as $payment)
                                <flux:text class="text-right">Php{{ number_format($payment->amount, 2) }}</flux:text>
                            @endforeach
                        </div>

                        {{-- Total Amount --}}
                        <flux:heading size="lg">Remaining Balance</flux:heading>
                        <flux:heading size="lg" class="text-right">Php{{ number_format($order->billing->balance, 2) }}</flux:heading>
                    </div>
                @else
                    <div class="flex gap-5">
                        <flux:heading size="lg">Total Amount</flux:heading>
                        <flux:heading size="lg">Php{{ number_format($order->billing->total_amount, 2) }}</flux:heading>
                    </div>
                @endif
            </div>
        </div>
    @else
        <section class="space-y-10 flex flex-col items-center justify-center">
            <div class="p-3 rounded-full bg-emerald-100/50 dark:bg-emerald-100/0">
                <flux:icon.search class="text-emerald-600 dark:text-emerald-400" />
            </div>
            
            <hgroup class="space-y-3">
                <h1 class="md:text-6xl text-4xl font-serif text-center text-emerald-600 dark:text-emerald-400 font-bold md:leading-18">Order Finder</h1>
                <flux:text class="text-base text-center max-w-sm mx-auto font-semibold">Find your order using your Order ID!</flux:text>
            </hgroup>
        </section>

        <flux:callout icon="info" class="max-w-sm mx-auto">
            <flux:callout.heading>Forgot your Order ID?</flux:callout.heading>

            <flux:callout.text>
                If you have access to the email address you used when placing your order, please check your inbox for an order notification — your Order ID will be included in that email.
            </flux:callout.text>
        </flux:callout>

        <form method="post" class="space-y-3 max-w-sm mx-auto" wire:submit='findOrder'>
            @csrf
            <flux:input label="Enter your Order ID" wire:model='order_number' placeholder="{{ 'ORD' . date('Ymd') . '00000' }}" clearable />

            <div class="md:flex justify-end">
                <flux:button type="submit" variant="primary" icon:trailing="search" class="w-full md:w-auto">Find Order</flux:button>
            </div>
        </form>
    @endif
</div>
