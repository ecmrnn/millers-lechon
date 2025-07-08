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