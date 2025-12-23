<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getCart(): Cart
    {
        $sessionId = Session::getId();
        $userId = Auth::id();
        
        return Cart::firstOrCreate(
            ['customer_id' => $userId],
            ['session_id' => $sessionId, 'status' => 'active']
        );
    }

    public function addItem(int $productId, int $quantity, ?int $weight = null, ?int $freebieId = null): Cart
    {
        $cart = $this->getCart();
        $product = Product::findOrFail($productId);

        // Update existing item or create new one
        $cartItem = $cart->items()->updateOrCreate(
            [
                'product_id' => $productId,
                'freebie_id' => $freebieId,
                'weight' => $weight
            ],
            [
                'quantity' => $quantity,
                'price' => $product->price,
            ]
        );

        return $cart->fresh();
    }

    public function removeItem($item): void
    {
        $cart = $this->getCart();
        $cart->items()->where('id', $item->id)->delete();
    }

    public function removeAllItems(): void
    {
        $cart = $this->getCart();
        $cart->items()->delete();
    }
}
