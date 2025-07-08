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