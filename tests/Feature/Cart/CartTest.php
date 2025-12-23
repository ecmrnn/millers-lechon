<?php

use App\Models\Product;

test('can add item to cart', function () {
    $product = Product::factory()->create();

    $item = [
        'product_id' => $product->id,
        'quantity' => 999,
        'weight' => 999,
        'freebie_id' => null,
    ];

    $response = $this->post(route('cart.addItem'), $item);

    $response->assertStatus(201);

    $this->assertDatabaseHas('cart_items', $item);
});

// test('can remove item from cart', function () {
//     // ...
// });