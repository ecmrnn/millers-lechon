<?php

use App\Models\Customer;

test('customer can register with a linked user account', function () {
    $email = 'maranan@gmail.com';
    $customerData = [
        'email' => $email,
        'password' => 'AVeryStrongPassword!',
        'first_name' => 'Ec',
        'last_name' => 'Maranan',
        'phone_number' => '09262355376',
        'street' => null,
        'city' => null,
        'province' => null,
    ];

    $response = $this->post(route('customers.register'), $customerData);
   
    $response->assertStatus(201);
    
    $this->assertDatabaseHas('users', [
        'email' => $email,
    ]);
});

// test('customer record is registered once an order is made', function() {
//     // to be continued...
// });