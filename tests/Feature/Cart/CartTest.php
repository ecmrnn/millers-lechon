<?php

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Session;

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
    
    $this->assertDatabaseHas('carts', [
        'session_id' => Session::getId(),
    ]);
});

test('a logged in user can remove item from cart', function () {
    $product = Product::factory()->create();
    $user = User::factory()->create();
    
    $itemData = [
        'product_id' => $product->id,
        'quantity' => 999,
        'weight' => 999,
        'freebie_id' => null,
    ];

    $this->actingAs($user)
        ->post(route('cart.addItem'), $itemData);

    $itemId = CartItem::latest()->first()->id;

    $response = $this->actingAs($user)->post(route('cart.removeItem'), ['cart_item_id' => $itemId]);

    $response->assertStatus(200);

    $this->assertDatabaseMissing('cart_items', [
        'id' => $itemId
    ]);
});