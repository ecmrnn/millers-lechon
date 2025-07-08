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