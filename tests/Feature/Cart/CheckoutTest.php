<?php

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use App\Services\CheckoutService;

test('cart can be checkedout', function () {
    $product = Product::factory()->create();
    $user = User::factory()->create();
    Customer::factory()->for($user)->create();

    $item = [
        'product_id' => $product->id,
        'quantity' => 2,
        'weight' => 1.5,
        'price' => 100.00,
    ];

    $this->actingAs($user)
        ->post(route('cart.addItem'), $item);
    
    $checkoutService = app(CheckoutService::class);

    $checkoutData = [
        'customer_id' => $user->customer->id,
        'order_date' => now()->toDateString(),
        'order_time' => now()->toTimeString(),
        'shipping_mode' => 'pick up',
        'note' => 'This is a test order'
    ];

    // WIP...
    // $checkoutService->checkout($cart, $checkoutData);

    // $this->assertDatabaseHas('orders', [
    //     'customer_id' => $user->customer->id,
    //     'shipping_mode' => 'pick up',
    //     'note' => 'This is a test order'
    // ]); 
});
