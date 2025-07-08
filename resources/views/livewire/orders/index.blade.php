<?php

use Livewire\Volt\Component;
use App\Models\Lechon;
use App\Models\Freebie;
use App\Services\OrderService;
use App\Traits\WithToast;
use function Livewire\Volt\{title, state, rules, mount, uses, usesFileUploads};
 
uses([WithToast::class]);

usesFileUploads();

state([
    'step' => 1,
    'min_order_date' => '',
    'lechons' => [],
    'freebies' => [],
    'tracking_number' => '',
    // Personal information
    'first_name' => '',
    'last_name' => '',
    'home_address' => '',
    'email' => '',
    'contact_number' => '',
    // Order details
    'cart' => [],
    'order_date' => '',
    'order_time' => '',
    'shipping_option' => 'pick up',
    'delivery_address' => '',
    'note' => '',
    // Cart details
    'lechon' => '',
    'quantity' => 1,
    'freebie' => '',
    'total' => 0,
    // Payment details
    'payment_method' => 'cash',
    'proof_of_payment' => '',
    'reference_number' => '',
    'amount_paid' => 2000,
]);

title('Orders'); 

rules()->messages([
    'cart.required' => 'Your cart cannot be empty.',
]);

mount(function () {
    $this->cart = collect();
    $this->min_order_date = now()->format('Y-m-d');
    $this->order_date = now()->format('Y-m-d');

    $this->lechons = Lechon::all();
    $this->freebies = Freebie::all();
});

$createOrder = function () {
    switch ($this->step) {
        case 1:
            $this->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'home_address' => 'required|string|max:255',
                'email' => 'nullable|string|max:255|email',
                'contact_number' => 'required|string|size:12|starts_with:9',
            ]);
            $this->step = 2;
            break;
        case 2:
            $this->validate([
                'cart' => 'required',
                'order_date' => 'required|date|after_or_equal:today',
                'order_time' => 'required',
                'shipping_option' => 'required',
                'delivery_address' => 'required_if:shipping_option,deliver|string|max:255',
                'note' => 'nullable|string|max:255',
            ]);

            $this->step = 3;
            break;
        default:
            $this->validate([
                'payment_method' => 'required',
                'proof_of_payment' => 'required_unless:payment_method,cash|image|max:1024',
                'reference_number' => 'required_unless:payment_method,cash|string|max:255',
                'amount_paid' => 'required|numeric|min:2000', /* Must be configurable */
            ]);

            $service = new OrderService;
            $result = $service->create([
                // Personal information
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'home_address' => $this->home_address,
                'email' => $this->email,
                'contact_number' => $this->contact_number,
                // Order details
                'cart' => $this->cart,
                'order_date' => $this->order_date,
                'order_time' => $this->order_time,
                'shipping_option' => $this->shipping_option,
                'delivery_address' => $this->delivery_address,
                'note' => $this->note,
                // Payment details
                'payment_method' => $this->payment_method,
                'proof_of_payment' => $this->proof_of_payment,
                'reference_number' => $this->reference_number,
                'amount_paid' => $this->amount_paid,
            ]);

            $this->dispatch('order-created');
            $this->toast('Order Created', 'Your order has been successfully created');
            $this->step = 4;
            $this->tracking_number = $result->tracking_number;
    }
};

$addToCart = function () {
    $this->validate([
        'lechon' => 'required',
        'freebie' => 'required',
        'quantity' => 'required|integer|min:1',
    ]);

    $lechon = Lechon::find($this->lechon);
    $freebie = Freebie::find($this->freebie);
    
    if ($lechon) {
        $this->cart->push([
            'id' => count($this->cart) + 1,
            'lechon' => $lechon,
            'freebie' => $freebie,
            'quantity' => $this->quantity,
        ]);

        $this->total = $this->cart->sum(function ($lechon) {
            return $lechon['lechon']->price * $lechon['quantity'];
        });

        $this->lechon = '';
        $this->freebie = '';
        $this->quantity = 1;
    }
};

$removeFromCart = function ($id) {
    $this->cart = $this->cart->reject(function ($value, $key) use ($id) {
        return $value['id'] === $id;
    });
};

$saveAsDraft = function () {
    //
};

$goToStep = function ($step) {
    $this->step = $step;
};

$resetForm = function () {
    $this->step = 1;
    // Personal information
    $this->first_name = '';
    $this->last_name = '';
    $this->home_address = '';
    $this->email = '';
    $this->contact_number = '';
    // Order details
    $this->cart = collect();
    $this->order_time = now()->format('Y-m-d');
    $this->shipping_option = 'pick up';
    $this->delivery_address = '';
    $this->note = '';
    // Cart details
    $this->lechon = '';
    $this->quantity = 1;
    $this->freebie = '';
    $this->total = 0;
    // Payment details
    $this->payment_method = 'cash';
    $this->proof_of_payment = '';
    $this->reference_number = '';
    $this->amount_paid = 2000;
};
?>

<div class="flex h-full">
    {{-- Sidebar Actions --}}
    @include('partials.orders.sidebar')

    {{-- Main Content --}}
    <div class="p-6 lg:p-8 w-full">
        <div class="flex w-full gap-3 justify-between">
            <flux:button icon:leading="list-filter">Filter</flux:button>
            <flux:input icon="magnifying-glass" placeholder="Search orders" class="w-max" />
        </div>
    </div>

    {{-- Create Order Model --}}
    <flux:modal name="create-order" class="max-w-xl w-full">
        <div class="space-y-3">
            <hgroup>
                <flux:heading size="xl">Create Order</flux:heading>
                <flux:subheading>Fill up this form to create a new order</flux:subheading>
            </hgroup>

            {{-- Steps --}}
            @if ($step <= 3)
                <div x-data="{ step: @entangle('step') }" class="grid sm:grid-cols-3 gap-3">
                    @if ($step == 1)
                        <flux:button variant="primary" icon:leading="circle-user-round" class="w-full">Customer Details</flux:button>
                    @else
                        <flux:button variant="filled" icon:leading="circle-user-round" class="w-full" wire:click='goToStep(1)'>Customer Details</flux:button>
                    @endif

                    @if ($step == 2)
                        <flux:button variant="primary" icon:leading="piggy-bank" class="w-full">Order Details</flux:button>
                    @elseif ($step >= 2)
                        <flux:button variant="filled" icon:leading="piggy-bank" class="w-full" wire:click='goToStep(2)'>Order Details</flux:button>
                    @else
                        <flux:button disabled variant="subtle" icon:leading="piggy-bank" class="w-full">Order Details</flux:button>
                    @endif

                    @if ($step == 3)
                        <flux:button variant="primary" icon:leading="wallet-cards" class="w-full">Payment</flux:button>
                    @else
                        <flux:button disabled variant="subtle" icon:leading="wallet-cards" class="w-full">Payment</flux:button>
                    @endif
                </div>
            @endif

            {{-- Order Form --}}
            <form x-data="{
                    shipping_option: 'pick up',
                    delivery_address: '',
                    home_address: @entangle('home_address') }"
                    wire:submit='createOrder' class="space-y-3">
                @switch($step)
                    @case(1)
                        {{-- Customer Details --}}
                        @include('partials.orders.customer-details')
                        @break
                    @case(2)
                        {{-- Order Details --}}
                        @include('partials.orders.order-details')
                        @break
                    @case(3)
                        {{-- Payment --}}
                        @include('partials.orders.payment')
                        @break
                    @default
                        {{-- Success --}}
                        <div class="p-3 pt-6 text-center border rounded-lg border-zinc-200 dark:border-zinc-700 dark:bg-zinc-700/50 grid place-items-center gap-3">
                            <flux:icon.badge-check class="size-12" />

                            <hgroup class="text-center">
                                <flux:heading size="lg">Order Created!</flux:heading>
                                <flux:subheading>Your order has been successfully created!</flux:subheading>
                            </hgroup>

                            <flux:input label="Order ID" description="Copy and send this Order ID to the customer for tracking purposes" wire:model='tracking_number' copyable readonly />

                            <flux:button variant="primary" wire:click='resetForm' icon:leading="plus">Create Order</flux:button>
                        </div>
                    @endswitch
            </form>
        </div>
    </flux:modal>

    {{-- Cart Modal --}}
    <flux:modal name="view-cart" class="max-w-lg w-full">
        <div class="space-y-6">
            <hgroup>
                <flux:heading size="xl">Lechon Cart</flux:heading>
                <flux:subheading>Your current lechon orders</flux:subheading>
            </hgroup>

            @if (count($cart) > 0)
                <x-table>
                    <x-table.columns>
                        <x-table.column>Qty.</x-table.column>
                        <x-table.column>Order</x-table.column>
                        <x-table.column>Freebie</x-table.column>
                        <x-table.column></x-table.column>
                    </x-table.columns>

                    <x-table.rows>
                        @foreach ($cart as $key => $lechon_cart)
                            <x-table.row wire:key="{{ $lechon_cart['id'] }}">
                                <x-table.cell>{{ $lechon_cart['quantity'] }}</x-table.cell>
                                <x-table.cell>{{ $lechon_cart['lechon']->weight . 'kg' }} - Php{{ number_format($lechon_cart['lechon']->price, 2) }}</x-table.cell>
                                <x-table.cell>{{ ucwords($lechon_cart['freebie']->name) }}</x-table.cell>
                                <x-table.cell class="text-right">
                                    <flux:tooltip content="Remove from cart" position="top">
                                        <flux:button size="sm" variant="danger" icon="trash-2" square wire:click="removeFromCart({{ $lechon_cart['id'] }})" />
                                    </flux:tooltip>
                                </x-table.cell>
                            </x-table.row>
                        @endforeach
                    </x-table.rows>
                </x-table>

                <div class="flex items-center justify-between text-green-600 dark:text-green-400">
                    <flux:heading size="lg">Total</flux:heading>
                    <flux:heading size="lg">Php{{ number_format($total, 2) }}</flux:heading>
                </div>
            @else
                <div class="p-6 text-center border rounded-lg border-zinc-200 dark:border-zinc-700 dark:bg-zinc-700/50 grid place-items-center gap-3">
                    <flux:icon.piggy-bank class="size-12" />

                    <hgroup>
                        <flux:heading size="lg">Your cart is empty!</flux:heading>
                        <flux:subheading>Add a lechon to your cart</flux:subheading>
                    </hgroup>
                </div>
            @endif
        </div>
    </flux:modal>
</div>
