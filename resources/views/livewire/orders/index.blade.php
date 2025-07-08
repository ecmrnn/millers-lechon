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
    'freebies' => [],
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
            $service->create([
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
            $this->redirect('orders', navigate: true);
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
?>

<div class="flex h-full">
    {{-- Sidebar Actions --}}
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

            {{-- Order Form --}}
            <form x-data="{
                    shipping_option: 'pick up',
                    delivery_address: '',
                    home_address: @entangle('home_address') }"
                    wire:submit='createOrder' class="space-y-3">
                @switch($step)
                    @case(1)
                        <div class="space-y-3 p-3 border border-zinc-200 rounded-lg dark:border-zinc-700 dark:bg-zinc-700/50">
                            <hgroup>
                                <flux:heading size="lg">Customer Details</flux:heading>
                                <flux:subheading>Get the customer's information and contact details</flux:subheading>
                            </hgroup>

                            <div class="grid sm:grid-cols-2 gap-3 items-start">
                                <flux:input id="first_name" label="First name" wire:model='first_name' placeholder="Johnny" clearable />
                                <flux:input id="last_name" label="Last name" wire:model='last_name' placeholder="Maranan" clearable />
                            </div>

                            <flux:input label="Home Address" wire:model='home_address' placeholder="410 Manila East Rd., ..." clearable />
                            <div class="grid sm:grid-cols-2 gap-3 items-start">
                                <flux:field>
                                    <flux:label>Contact Number</flux:label>
                                    <flux:input.group>
                                        <flux:input.group.prefix>+63</flux:input.group.prefix>
                                        <flux:input wire:model='contact_number' placeholder="900 0000 000" mask="999 9999 999" clearable />
                                    </flux:input.group>
                                    <flux:error name="contact_number" />
                                </flux:field>
                                <flux:input type="email" wire:model='email' label="Email Address (Optional)" placeholder="johnny.maranan@millers.lechon" clearable />
                            </div>
                        </div>

                        <div class="flex gap-3 justify-between">
                            <flux:button variant="subtle" wire:click='saveAsDraft'>Save as Draft</flux:button>
                            <flux:button variant="primary" type="submit">Next</flux:button>
                        </div>
                        @break
                    @case(2)
                        <div class="space-y-3 p-3 border border-zinc-200 rounded-lg dark:border-zinc-700 dark:bg-zinc-700/50">
                            <hgroup>
                                <flux:heading size="lg">Order Details</flux:heading>
                                <flux:subheading>Select the date and time of order</flux:subheading>
                            </hgroup>

                            <div class="grid sm:grid-cols-2 gap-3 items-start">
                                <flux:input type="date" label="Order Date" wire:model='order_date' min="{{ $min_order_date }}" clearable />
                                <flux:input type="time" label="Order Time" wire:model='order_time' clearable />
                            </div>
                        </div>

                        <div class="space-y-3 p-3 border border-zinc-200 rounded-lg dark:border-zinc-700 dark:bg-zinc-700/50">
                            <hgroup>
                                <flux:heading size="lg">Lechon Orders</flux:heading>
                                <flux:subheading>Choose the size and quantity of the lechon the customer wants</flux:subheading>
                            </hgroup>

                            <div class="grid sm:grid-cols-2 gap-3 items-start">
                                <flux:select placeholder="Choose lechon size" label="Lechon Size" wire:model='lechon'>
                                    @foreach ($lechons as $lechon)
                                        <<flux:select.option value="{{ $lechon->id }}">
                                            {{ "{$lechon->weight}kg - Php" }}{{ number_format($lechon->price, 2) }}
                                        </flux:select.option>
                                    @endforeach
                                </flux:select>
                                
                                <flux:input type="number" min="1" label="Quantity" wire:model='quantity' placeholder="0" clearable />
                            </div>
                            
                            <flux:select placeholder="Choose a freebie" label="Freebie" wire:model='freebie'>
                                @foreach ($freebies as $freebie)
                                    <flux:select.option value="{{ $freebie->id }}">
                                        {{ ucwords($freebie->name) }}
                                    </flux:select.option>
                                @endforeach
                            </flux:select>

                            <div class="flex justify-between gap-3">
                                <div>
                                    @if (count($cart) > 0)
                                        <flux:modal.trigger name="view-cart">
                                            <flux:button icon:leading="shopping-cart">{{ "(" . count($cart) . ")" }} View Cart</flux:button>
                                        </flux:modal.trigger>
                                    @endif
                                </div>

                                <flux:button variant="primary" icon:leading="plus" wire:click='addToCart'>Add to Cart</flux:button>
                            </div>

                            @error('cart')
                                <flux:error name="cart" />
                            @enderror
                        </div>

                        <div class="space-y-3 p-3 border border-zinc-200 rounded-lg dark:border-zinc-700 dark:bg-zinc-700/50">
                            <flux:fieldset>
                                <flux:legend>Shipping Options</flux:legend>
                                <flux:radio.group wire:model='shipping_option' x-model="shipping_option">
                                    <flux:radio
                                        name="role" value="pick up" label="Pick Up" checked
                                        description="Customer will pick up the lechon at our store"
                                    />
                                    <flux:radio
                                        name="role" value="deliver" label="Deliver"
                                        description="We will deliver the lechon to the customer's address"
                                    />
                                </flux:radio.group>
                            </flux:fieldset>

                            <div x-show="shipping_option === 'deliver'" class="space-y-3">
                                <flux:input x-model="delivery_address" wire:model='delivery_address' label="Delivery Address" placeholder="{{ $home_address }}" clearable />
                                <flux:field variant="inline">
                                    <flux:checkbox x-on:change="delivery_address = home_address; $wire.set('delivery_address', home_address)" />
    
                                    <flux:label>Same as customer's home address</flux:label>
                                </flux:field>
                            </div>
                        </div>
                        
                        <div>
                            <flux:textarea
                                label="Order notes (Optional)"
                                placeholder="Crunchy yung balat ha? Please make sure na malasa yung meat."
                                rows="auto"
                            />
                        </div>

                        <div class="flex gap-3 justify-between">
                            <flux:button variant="subtle" wire:click='saveAsDraft'>Save as Draft</flux:button>

                            <div class="flex gap-3">
                                <flux:button variant="ghost" wire:click='goToStep(1)'>Back</flux:button>
                                <flux:button variant="primary" type="submit">Next</flux:button>
                            </div>
                        </div>
                        @break
                    @default
                        <div class="space-y-3 p-3 border border-zinc-200 rounded-lg dark:border-zinc-700 dark:bg-zinc-700/50">
                            <flux:heading size="lg">Customer Information</flux:heading>
                            
                            <div>
                                <flux:text><strong>Name: </strong>{{ ucwords(strtolower("$first_name $last_name")) }}</flux:text>
                                <flux:text><strong>Home Address: </strong>{{ ucwords(strtolower($home_address)) }}</flux:text>
                                @if ($email)
                                    <flux:text><strong>Email: </strong>{{ $email }}</flux:text>
                                @endif
                                <flux:text><strong>Contact Number: </strong>{{ $contact_number }}</flux:text>
                            </div>
                        </div>

                        <div class="space-y-3 p-3 border border-zinc-200 rounded-lg dark:border-zinc-700 dark:bg-zinc-700/50">
                            <flux:heading size="lg">Order Details</flux:heading>

                            <div>
                                <flux:text><strong>Order Date and Time: </strong>{{ date_format(date_create("$order_date $order_time"), 'F j, Y - g:i A') }}</flux:text>
                                <flux:text><strong>Shipping Option: </strong>{{ ucwords($shipping_option) }}</flux:text>
                                @if ($shipping_option === 'deliver')
                                    <flux:text><strong>Delivery Address: </strong>{{ ucwords(strtolower($delivery_address)) }}</flux:text>
                                @endif
                            </div>

                             <x-table>
                                <x-table.columns>
                                    <x-table.column>Qty.</x-table.column>
                                    <x-table.column>Order</x-table.column>
                                    <x-table.column>Freebie</x-table.column>
                                </x-table.columns>

                                <x-table.rows>
                                    @foreach ($cart as $key => $lechon_cart)
                                        <x-table.row wire:key="{{ $lechon_cart['id'] }}">
                                            <x-table.cell>{{ $lechon_cart['quantity'] }}</x-table.cell>
                                            <x-table.cell>{{ $lechon_cart['lechon']->weight . 'kg' }} - Php{{ number_format($lechon_cart['lechon']->price, 2) }}</x-table.cell>
                                            <x-table.cell>{{ ucwords($lechon_cart['freebie']->name) }}</x-table.cell>
                                        </x-table.row>
                                    @endforeach
                                </x-table.rows>
                            </x-table>

                            <div class="flex items-center justify-between text-green-600 dark:text-green-400">
                                <flux:heading size="lg">Total</flux:heading>
                                <flux:heading size="lg">Php{{ number_format($total, 2) }}</flux:heading>
                            </div>
                        </div>

                        <div x-data='{ payment_method: "cash" }' class="space-y-3 p-3 border border-zinc-200 rounded-lg dark:border-zinc-700 dark:bg-zinc-700/50">
                            <hgroup>
                                <flux:heading size="lg">Payment</flux:heading>
                                <flux:subheading>Upload customer's payment here</flux:subheading>
                            </hgroup>

                            <flux:select placeholder="Select payment method" label="Payment Method" x-model='payment_method' x-on:change="$wire.set('payment_method', payment_method)">
                                <flux:select.option value="cash">Cash</flux:select.option>
                                <flux:select.option value="gcash">GCash</flux:select.option>
                                <flux:select.option value="bank transfer">Bank Transfer</flux:select.option>
                            </flux:select>

                            <div x-show="payment_method !== 'cash'" class="space-y-3">
                                <flux:input type="file" wire:model="proof_of_payment" description="Upload an image (JPG, JPEG, or PNG) of the receipt of the transaction made. Maximum file size is 1024kb." label="Proof of payment"/>
                                <flux:input wire:model="reference_number" label="Reference Number"/>
                            </div>

                            <flux:input type="number" placeholder="0" label="Amount paid" wire:model='amount_paid' />
                        </div>

                        <div class="flex gap-3 justify-between">
                            <flux:button variant="subtle" wire:click='saveAsDraft'>Save as Draft</flux:button>

                            <div class="flex gap-3">
                                <flux:button variant="ghost" wire:click='goToStep(2)'>Back</flux:button>
                                <flux:button variant="primary" type="submit">Submit</flux:button>
                            </div>
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

            {{-- Order Breakdown --}}
        </div>
    </flux:modal>
</div>
