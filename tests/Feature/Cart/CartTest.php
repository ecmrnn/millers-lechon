<?php

use App\Models\Cart;
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

test('logged in user can remove item from cart', function () {
    $user = User::factory()->create();
    Customer::factory()->for($user)->create(); 

    $itemData = [
        'product_id' => Product::factory()->create()->id,
        'quantity' => 999,
        'weight' => 999,
        'freebie_id' => null,
    ];

    
    $this->actingAs($user)
    ->post(route('cart.addItem'), $itemData);

    $this->assertAuthenticated();
    
    $cart = Cart::where('customer_id', $user->id)->first();

    $itemId = $cart->items()->first()->id;

    $response = $this->actingAs($user)->post(route('cart.removeItem'), ['cart_item_id' => $itemId]);

    $response->assertStatus(200);

    $this->assertDatabaseMissing('cart_items', [
        'id' => $itemId
    ]);
});

test('logged in user can remove all items from their cart', function () {
    $user = User::factory()->create();
    Customer::factory()->for($user)->create(); 

    $items = [
        [
            'product_id' => Product::factory()->create()->id,
            'quantity' => 999,
            'weight' => 999,
            'freebie_id' => null,
        ],
        [
            'product_id' => Product::factory()->create()->id,
            'quantity' => 999,
            'weight' => 999,
            'freebie_id' => null,
        ]
    ];
    
    foreach ($items as $item) {
        $this->actingAs($user)
            ->post(route('cart.addItem'), $item);
    }

    $response = $this->actingAs($user)->post(route('cart.clear'));

    $response->assertStatus(200);

    $this->assertAuthenticated();

    $this->assertDatabaseMissing('cart_items', [
        'cart_id' => Cart::where('customer_id', $user->id)->first()->id
    ]);
});