<?php

use App\Models\Customer;

test('customer can register with a linked user account', function () {
    $customer = Customer::factory()->create();
    $user = $customer->user;

    $this->assertDatabaseHas('users', [
        'id' => $customer->user->id,
    ]);

    $this->assertModelExists($customer->user);
});

test('customer record is registered once an order is made', function() {
    // to be continued...
});