<?php

use App\Models\Lechon;
use App\Models\Freebie;
use App\Traits\WithToast;
use App\Services\OrderService;
use function Livewire\Volt\{state, layout, mount, rules, uses, usesFileUploads};

usesFileUploads();
uses([WithToast::class]);

state([
    'step' => 1,
    'lechon' => [],
    'lechons' => [],
    'reserved_lechons' => collect(),
    'quantity' => 1,
    'freebie' => '',
    'freebies' => [],
    'order_id' => '',
    // Personal Details
    'first_name' => '',
    'last_name' => '',
    'address' => '',
    'email' => '',
    'contact_number' => '',
    'terms' => '',
    // Reservation Details
    'min_order_date' => '',
    'order_date' => '',
    'order_time' => '',
    'is_pickup' => true,
    'delivery_address' => null,
    'note' => '',
    // Payment Details
    'receipt_image' => '',
    'total_amount' => 0,
]);

rules()->messages([
    'first_name.regex' => 'The first name field may contain letters and numbers only.',
    'last_name.regex' => 'The last name field may contain letters and numbers only.',
    'contact_number.starts_with' => 'The contact number must starts with "9".',
    'contact_number.size' => 'The contact number be 10 digits long.',
    'delivery_address.required_if_declined' => 'The delivery address is required if you choose to have it delivered.',
    'reserved_lechons.required' => 'Select a lechon size and quantity.',
    'note.regex' => 'The note field may contain letters, numbers, comma, spaces, and the following characters only: (!, ?, ., \').',
    'address.regex' => 'The address field may contain letters, numbers, comma, and spaces only.',
    'delivery_address.regex' => 'The delivery address field may contain letters, numbers, comma, and spaces only.',
]);

mount(function () {
    $this->min_order_date = now()->addDay()->format('Y-m-d');
    $this->order_date = now()->addDay()->format('Y-m-d');
    $this->lechons = Lechon::all();
    $this->lechon = $this->lechons->first();
    $this->freebies = Freebie::all();
});

$selectLechon = fn (Lechon $lechon) => $this->lechon = $lechon;

$addToCart = function () {
    $this->validate([
        'quantity' => 'required|integer|min:1|max:10',
        'freebie' => 'required',
    ]);

    $this->reserved_lechons->push([
        'lechon' => $this->lechon,
        'quantity' => $this->quantity,
        'freebie' => $this->freebie,
    ]);

    $this->total_amount += ($this->lechon->price * $this->quantity);

    $this->reserved_lechons = $this->reserved_lechons->sortBy('lechon');

    $this->quantity = 1;

    $this->toast('Lechon added to cart');
};

$removeFromCart = function ($key) {
    $removed_lechon = $this->reserved_lechons->filter(function($lechon, int $_key) use ($key) {
        if ($_key == $key) {
            return $lechon;
        } 
    })->first();

    $this->reserved_lechons = $this->reserved_lechons->filter(function($lechon, int $_key) use ($key) {
        if ($_key != $key) {
            return $lechon;
        } 
    });

    $this->total_amount -= ($removed_lechon['lechon']->price * $removed_lechon['quantity']);

    $this->toast('Lechon removed from cart', 'info');
};

$submit = function () {
    switch ($this->step) {
        case 1:
            $this->validate([
                'first_name' => 'required|string|min:2|max:255|regex:/^[A-Za-z0-9\s]+$/',
                'last_name' => 'required|string|min:2|max:255|regex:/^[A-Za-z0-9\s]+$/',
                'address' => 'required|string|min:10|max:255|regex:/^[A-Za-z0-9\s\.\,]+$/',
                'email' => 'required|email|max:255',
                'contact_number' => 'required|string|size:12|starts_with:9',
                'terms' => 'required|accepted',
            ]);

            $this->step = 2;
            break;
        case 2:
            $this->validate([
                'order_date' => 'required|date|after_or_equal:' . $this->min_order_date,
                'order_time' => 'required',
                'is_pickup' => 'required',
                'delivery_address' => 'nullable|string|max:255|regex:/^[A-Za-z0-9\s\.\,]+$/|required_if_declined:is_pickup',
                'reserved_lechons' => 'required',
                'note' => 'nullable|string|regex:/^[A-Za-z0-9\s\!\.\'\?\,]+$/|max:255',
            ]);

            if (filter_var($this->is_pickup, FILTER_VALIDATE_BOOLEAN)) {
                $this->delivery_address == '';
            }

            $this->step = 3;
            break;
        case 3:
            $this->validate([
                'receipt_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $data = collect([
                // Personal Details
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'address' => $this->address,
                'email' => $this->email,
                'contact_number' => $this->contact_number,
                // Reservation Details
                'order_date' => $this->order_date,
                'order_time' => $this->order_time,
                'is_pickup' => $this->is_pickup,
                'delivery_address' => $this->delivery_address,
                'reserved_lechons' => $this->reserved_lechons,
                'note' => $this->note,
                // Payment
                'receipt_image' => $this->receipt_image,
                'total_amount' => $this->total_amount,
            ]);

            // Process Order
            $order = new OrderService;
            $created_order = $order->create($data);
            $this->order_id = $created_order->order_number;

            $this->step = 4;
            $this->toast('Reservation submitted!');

            break;
    }
};

$back = fn () => $this->step--;

layout('components.layouts.web');
?>

<div x-data="{ address: @entangle('address'), delivery_address: @entangle('delivery_address') }" class="space-y-5">
    @if ($step < 4)
        <hgroup>
            <flux:heading size="xl">Reservation</flux:heading>
            <flux:subheading>Fill up the form below to reserve a Lechon</flux:subheading>
        </hgroup>

        <form method="post" wire:submit='submit' class="flex flex-col md:flex-row md:border border-zinc-200 dark:border-zinc-700 rounded-lg">
            @csrf
            {{-- Steps --}}
            <div class="p-5 bg-zinc-100/50 rounded-lg md:rounded-e-none border md:border-0 md:border-r border-zinc-200 dark:border-zinc-700 dark:bg-zinc-700/50 md:w-1/3 shrink-0">
                <div class="sticky top-5 space-y-3">
                    <div class="flex gap-5 items-center">
                        <flux:button icon="contact-round" />
                        <hgroup>
                            <flux:text class="text-xs">Step 1</flux:text>
                            <flux:heading>Personal Details</flux:heading>
                        </hgroup>
                    </div>
                    <div class="flex gap-5 items-center">
                        <flux:button icon="receipt-text" />
                        <hgroup>
                            <flux:text class="text-xs">Step 2</flux:text>
                            <flux:heading>Reservation Details</flux:heading>
                        </hgroup>
                    </div>
                    <div class="flex gap-5 items-center">
                        <flux:button icon="credit-card" />
                        <hgroup>
                            <flux:text class="text-xs">Step 3</flux:text>
                            <flux:heading>Payment</flux:heading>
                        </hgroup>
                    </div>
                </div>
            </div>

            <div class="w-full md:p-5 pt-5">
                @switch($step)
                    @case(1)
                        {{--
                            Personal Details
                        --}}
                        <section class="space-y-5">
                            <hgroup>
                                <flux:heading size="xl">Personal Details</flux:heading>
                                <flux:subheading>Enter your name, address, and contact details here</flux:subheading>
                            </hgroup>

                            <div class="grid md:grid-cols-2 gap-5 items-start">
                                <flux:input label="First name" placeholder="Johnny" clearable wire:model='first_name' />
                                <flux:input label="Last name" placeholder="Maranan" clearable wire:model='last_name' />
                            </div>

                            <flux:input label="Address" placeholder="1234 Lechon St." clearable wire:model='address' />

                            <div class="grid md:grid-cols-2 gap-5 items-start">
                                <flux:input label="Email Address" description="Your email address will be used to send you notifications about your reservation" placeholder="johnny@order.lechon" clearable wire:model='email' />

                                <flux:field>
                                    <flux:label>Contact Number</flux:label>
                                    <flux:description>Your phone number will be used to confirm your reservation</flux:description>

                                    <flux:input.group>
                                        <flux:input.group.prefix>+63</flux:input.group.prefix>
                                        <flux:input wire:model='contact_number' mask="999 999 9999" placeholder="912 345 6789" clearable />
                                    </flux:input.group>

                                    <flux:error name='contact_number' />
                                </flux:field>
                            </div>

                            <flux:field variant="inline">
                                <flux:checkbox wire:model="terms" />
                                
                                <flux:label>By processing an order on this reservation form, I allow Miller's Lechon to store and use my data solely for their operational use.</flux:label>

                                <flux:error name="terms" />
                            </flux:field>

                            <div class="flex justify-end">
                                <flux:button type="submit" icon:trailing="chevron-right" class="w-full md:w-auto" variant="primary">Next</flux:button>
                            </div>
                        </section>
                        @break
                    @case(2)
                        {{--
                            Reservation Details
                        --}}
                        <section class="space-y-5">
                            <hgroup>
                                <flux:heading size="xl">Reservation Details</flux:heading>
                                <flux:subheading>Enter the date and time of your reservation</flux:subheading>
                            </hgroup>

                            <div class="grid md:grid-cols-2 gap-5 items-start">
                                <flux:input type="date" min="{{ $min_order_date }}" label="Date to Reserve" description="Select the date when you want to reserve a lechon, minimum date is tommorrow" wire:model='order_date' clearable  />
                                <flux:input type="time" label="Time to Reserve" description="Select the time when you want to receive the lechon" wire:model='order_time' clearable  />
                            </div>

                            <div class="space-y-5">
                                <hgroup>
                                    <flux:label>Choose a Lechon Size and Quantity</flux:label>
                                    <flux:description>Select your desired size and quantity of lechon</flux:description>
                                </hgroup>

                                <div class="p-5 space-y-3 border rounded-lg border-zinc-200 dark:bg-zinc-700/50 dark:border-zinc-700">
                                    <x-img src="{{ $lechon->image }}" alt="No image preview for this lechon" />

                                    <flux:heading size="lg">Select Size</flux:heading>

                                    <div class="flex gap-3 flex-wrap">
                                        @foreach ($lechons as $_lechon)
                                            @if ($_lechon->id == $lechon->id)
                                                <flux:button size="sm" variant="primary">{{ $_lechon->size }}</flux:button>
                                            @else
                                                <flux:button size="sm" :loading="false" wire:click='selectLechon({{ $_lechon->id }})'>{{ $_lechon->size }}</flux:button>
                                            @endif
                                        @endforeach
                                    </div>

                                    <hgroup>
                                        <flux:heading size="xl">Lechon {{ $lechon->size }}</flux:heading>
                                        <flux:text class="text-base font-semibold">Php{{ number_format($lechon->price, 2) }}</flux:text>
                                        <flux:text class="mt-3">{{ $lechon->description }}</flux:text>
                                    </hgroup>

                                    <div class="grid md:grid-cols-2 items-start gap-3">
                                        <flux:input type="number" label="Quantity" placeholder="1" min="1" max="10" wire:model='quantity' />
                                        <flux:select wire:model="freebie" label="Freebie" placeholder="Choose your freebie">
                                            @foreach ($freebies as $_freebie)
                                                <flux:select.option value="{{ $_freebie['name'] }}">{{ $_freebie->name }}</flux:select.option>
                                            @endforeach
                                        </flux:select>
                                    </div>
                                    <flux:button type="button" variant="primary" icon:leading="plus" class="w-full md:w-auto" wire:click='addToCart'>Add to Cart</flux:button>
                                </div>
                            </div>

                            <flux:callout icon="shopping-cart">
                                <flux:callout.heading>Your Lechon Cart</flux:callout.heading>
                                <flux:callout.text>Lechon sizes added to your cart and their quantity will appear here</flux:callout.text>

                                <x-slot name="actions">
                                    <flux:modal.trigger name="view-cart">
                                        <flux:button type="button">View Cart ({{ count($reserved_lechons) }})</flux:button>
                                    </flux:modal.trigger>
                                </x-slot>
                            </flux:callout>

                            <flux:error name="reserved_lechons" />

                            {{-- 
                                Lechon Cart Modal
                            --}}
                            <flux:modal name="view-cart" class="max-w-lg">
                                <div class="space-y-5">
                                    <hgroup>
                                        <flux:heading size="lg">Your Lechon Orders</flux:heading>
                                        <flux:subheading>Lechon sizes and quantities added to your cart will appear here</flux:subheading>
                                    </hgroup>

                                    @if (count($reserved_lechons) > 0)
                                        <div class="space-y-5">
                                            {{-- Reserved Lechons --}}
                                            <div class="space-y-3">
                                                @foreach ($reserved_lechons as $key => $_lechon)
                                                    <div wire:key='reserved-lechons-{{ $key }}' class="p-3 rounded-md flex items-start gap-3 border border-zinc-200 dark:border-zinc-700">
                                                        <x-img aspect="square" src="{{ $_lechon['lechon']->image }}" class="w-12" />
                                                
                                                        <hgroup class="grow">
                                                            <flux:heading>Lechon {{ $_lechon['lechon']->size }}</flux:heading>
                                                            <flux:text>Price: Php{{ number_format($_lechon['lechon']->price, 2) }}</flux:text>
                                                            <flux:text>Quantity: {{ number_format($_lechon['quantity']) }}</flux:text>
                                                            <flux:text>Freebies: Original Miller's Lechon Sauce, {{ $_lechon['freebie'] }}</flux:text>
                                                        </hgroup>

                                                        <flux:button icon="trash-2" type="button" size="sm" variant="danger" class="shrink-0" wire:click='removeFromCart({{ $key }})' />
                                                    </div>
                                                @endforeach
                                            </div>

                                            {{-- Breakdown --}}
                                            <div>
                                                @foreach ($reserved_lechons as $key => $_lechon)
                                                    <div wire:key="breakdown-{{ $key }}">
                                                        <div class="flex justify-between items-center">
                                                            <flux:heading>Lechon {{ $_lechon['lechon']->size }} ({{ $_lechon['quantity'] }})</flux:heading>
                                                            <flux:text>{{ number_format($_lechon['lechon']->price * $_lechon['quantity'], 2) }}</flux:text>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <flux:separator />

                                            <div class="flex justify-between items-center">
                                                <flux:heading size="xl">Total</flux:heading>
                                                <flux:heading size="xl">Php{{ number_format($total_amount, 2) }}</flux:heading>
                                            </div>
                                        </div>
                                    @else
                                        <div class="p-5 grid place-items-center border rounded-lg border-dashed border-zinc-200 dark:border-zinc-700">
                                            <div class="flex items-center flex-col gap-3">
                                                <flux:icon.shopping-cart class="size-12 opacity-50" />
                                                <flux:text>Your cart is empty</flux:text>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </flux:modal>
                            
                            <div x-data="{ is_pickup: @entangle('is_pickup') }" class="space-y-5">
                                <flux:radio.group x-model='is_pickup' label="Choose your shipping option" description="Select an option how you want to receive your lechon">
                                    <flux:radio value="true" icon="cube" label="Pick Up" description="You will personally pick up the lechon at our address, no additional fees required" />
                                    <flux:radio value="false" icon="truck" label="Deliver" description="The lechon will be deliver to your address, additional fees may depend on your location" />
                                </flux:radio.group>

                                <div x-show="is_pickup == 'false' || !is_pickup" class="space-y-3">
                                    <flux:input label="Delivery Address" placeholder="1234 Lechon St." clearable wire:model='delivery_address' />

                                    <flux:field variant="inline">
                                        <flux:checkbox x-on:click="if ($el.checked) $wire.set('delivery_address', address)" />
                                        <flux:label>Same as my address</flux:label>
                                    </flux:field>
                                </div>
                            </div>

                            <flux:textarea label='Note (Optional)' rows="auto" description='If you have special requests or landmark near your address, write it here!' placeholder='Craving for a crunchy Miller&apos;s Lechon!' wire:model='note' />

                            <div class="flex justify-between gap-5">
                                <flux:button type="button" icon:leading="chevron-left" class="w-full md:w-auto" wire:click='back'>Back</flux:button>
                                <flux:button type="submit" icon:trailing="chevron-right" class="w-full md:w-auto" variant="primary">Next</flux:button>
                            </div>
                        </section>
                        @break
                    @case(3)
                        {{--
                            Payment
                        --}}
                        <section class="space-y-5">
                            <hgroup>
                                <flux:heading size="xl">Payment</flux:heading>
                                <flux:subheading>Submit your payment here to process your order</flux:subheading>
                            </hgroup>

                            <flux:callout icon="contact-round">
                                <flux:callout.heading>Personal Details</flux:callout.heading>

                                <flux:callout.text>
                                    <div>
                                        <p><strong>Name</strong>: {{ ucwords(strtolower($first_name)) . ' ' . ucwords(strtolower($last_name)) }}</p>
                                        <p><strong>Address</strong>: {{ $address }}</p>
                                        <p><strong>Email</strong>: {{ $email }}</p>
                                        <p><strong>Contact Number</strong>: {{ $contact_number }}</p>
                                    </div>
                                </flux:callout.text>
                            </flux:callout>

                            <flux:callout icon="receipt-text">
                                <flux:callout.heading>Reservation Details</flux:callout.heading>

                                <flux:callout.text>
                                    <div>
                                        <p><strong>Order Date and Time</strong>: {{ date_format(date_create($order_date), 'F j, Y') . ' at ' . date_format(date_create($order_time), 'g:i A') }}</p>
                                        <p><strong>Shipping Option</strong>: {{ $is_pickup == true || $is_pickup == 'true' ? 'Pick Up' : 'Delivery' }}</p>
                                        @if (! filter_var($is_pickup, FILTER_VALIDATE_BOOLEAN))
                                            <p><strong>Delivery Address</strong>: {{ $delivery_address }}</p>
                                        @endif
                                        @if ($note)
                                            <p><strong>Note</strong>: {{ $note }}</p>
                                        @endif
                                    </div>
                                </flux:callout.text>
                            </flux:callout>

                            <flux:callout icon="credit-card">
                                <flux:callout.heading>Upload Payment Receipt</flux:callout.heading>
                                <flux:callout.text>
                                    To successfully process your order, submit a proof of payment made via GCash with a minimum amount of <strong>Php{{ number_format($total_amount * .5, 2) }}</strong>.
                                    <br /><br />
                                    <p><strong>GCash Account</strong></p>
                                    <br />
                                    <p><strong>Name</strong>: Evelyn Martinez</p>
                                    <p><strong>Account Number</strong>: +63 917 208 1519</p>
                                </flux:callout.text>

                                <x-slot name="actions">
                                    <flux:modal.trigger name="upload-receipt">
                                        <flux:button type="button" variant="primary">Upload Receipt</flux:button>
                                    </flux:modal.trigger>
                                </x-slot>

                                <flux:error name="receipt_image" />
                            </flux:callout>

                            <flux:modal name="upload-receipt" class="max-w-lg w-full">
                                <div class="space-y-5 overflow-clip">
                                    <hgroup>
                                        <flux:heading size="xl">Upload Receipt</flux:heading>
                                        <flux:subheading>Upload an image (JPG, JPEG, or PNG) with a maximum file size of 2MB.</flux:subheading>
                                    </hgroup>

                                    <div class="p-5 rounded-lg border border-zinc-200 dark:border-zinc-700 dark:bg-zinc-700/25">
                                        <flux:text>
                                            To successfully process your order, submit a proof of payment made via GCash with a minimum amount of <strong>Php{{ number_format($total_amount * .5, 2) }}</strong>.
                                            <br /><br />
                                            <p><strong>GCash Account</strong></p>
                                            <br />
                                            <p><strong>Name</strong>: Evelyn Martinez</p>
                                            <p><strong>Account Number</strong>: +63 917 208 1519</p>
                                        </flux:text>
                                    </div>

                                    <flux:input type="file" wire:model='receipt_image' label="Upload Receipt Here" description='This receipt will serve as your downpayment for your order.' class="overflow-hidden" />
                                </div>
                            </flux:modal>

                            <flux:heading>Order Summary</flux:heading>

                            <div class="space-y-3">
                                @foreach ($reserved_lechons as $key => $_lechon)
                                    <div wire:key='payment-reserved-lechons-{{ $key }}' class="p-3 rounded-lg flex items-start gap-3 border border-zinc-200 dark:border-zinc-700">
                                        <x-img aspect="square" src="{{ $_lechon['lechon']->image }}" class="w-12" />
                                
                                        <hgroup class="grow">
                                            <flux:heading>Lechon {{ $_lechon['lechon']->size }}</flux:heading>
                                            <flux:text>Price: Php{{ number_format($_lechon['lechon']->price, 2) }}</flux:text>
                                            <flux:text>Quantity: {{ number_format($_lechon['quantity']) }}</flux:text>
                                            <flux:text>Freebies: Original Miller's Lechon Sauce, {{ $_lechon['freebie'] }}</flux:text>
                                        </hgroup>
                                    </div>
                                @endforeach

                                <div>
                                    @foreach ($reserved_lechons as $key => $_lechon)
                                        <div wire:key="breakdown-{{ $key }}">
                                            <div class="flex justify-between items-center">
                                                <flux:heading>Lechon {{ $_lechon['lechon']->size }} ({{ $_lechon['quantity'] }})</flux:heading>
                                                <flux:text>{{ number_format($_lechon['lechon']->price * $_lechon['quantity'], 2) }}</flux:text>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <flux:separator />

                                <div class="flex justify-between items-center">
                                    <flux:heading size="xl">Total</flux:heading>
                                    <flux:heading size="xl">Php{{ number_format($total_amount, 2) }}</flux:heading>
                                </div>
                            </div>

                            <div class="flex justify-between gap-5">
                                <flux:button type="button" icon:leading="chevron-left" class="w-full md:w-auto" wire:click='back'>Back</flux:button>
                                <flux:button type="submit" icon:trailing="chevron-right" class="w-full md:w-auto" variant="primary">Submit</flux:button>
                            </div>
                        </section>
                        @break
                    @default
                        
                @endswitch
            </div>
        </form>
    @else
        <div class="space-y-5 max-w-md mx-auto">
            <div class="pt-5 flex justify-center">
                <div class="p-3 rounded-full bg-emerald-100/50 dark:bg-emerald-100/0">
                    <flux:icon.badge-check class="text-emerald-600 dark:text-emerald-400" />
                </div>
            </div>

            <hgroup class="text-center">
                <flux:heading size="xl" class="text-emerald-600 dark:text-emerald-400">Reservation Success!</flux:heading>
                <flux:subheading>You may send your Order ID to our facebook page to notify our staff about your order.</flux:subheading>
            </hgroup>

            <div class="p-5 rounded-lg border border-zinc-200 dark:border-zinc-700 dark:bg-zinc-700/25">
                <flux:input label="Order ID" description="Keep your Order ID somewhere safe, you may use this to track your order." value="{{ $order_id }}" copyable readonly />
            </div>

            <div class="grid grid-cols-2 gap-5">
                <flux:button class="w-full" wire:navigate href="{{ route('find-order', ['id' => $order_id]) }}">Track my Order</flux:button>
                <flux:button variant="primary" wire:navigate href="{{ route('order') }}" class="w-full">Create Order</flux:button>
            </div>
        </div>
    @endif
</div>
