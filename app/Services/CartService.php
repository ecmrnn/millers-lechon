<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getCart(): Cart
    {
        $sessionId = Session::getId();
        $userId = Auth::id();
        
        if ($userId)
        {
            return Cart::where('customer_id', Auth::id())->firstOrCreate(
                ['customer_id' => Auth::id()],
                ['session_id' => $sessionId, 'status' => 'active']
            );
        }

        return Cart::where('session_id', $sessionId)->firstOrCreate(
            ['session_id' => $sessionId],
            ['status' => 'active']
        );
    }

    public function addItem(int $productId, int $quantity, ?int $weight = null, ?int $freebieId = null)
    {
        $cart = $this->getCart();
        $product = Product::findOrFail($productId);

        // Update existing item or create new one
        return DB::transaction(function () use ($cart, $productId, $quantity, $weight, $freebieId, $product) {
            $item = $cart->items()
                ->where([
                    'product_id' => $productId,
                    'freebie_id' => $freebieId,
                    'weight' => $weight,
                ])
                ->first();

            if ($item) {    
                $item->increment('quantity', $quantity);
                return $item->fresh();
            }

            return $cart->items()->create([
                'product_id' => $productId,
                'freebie_id' => $freebieId,
                'quantity' => $quantity,
                'price' => $product->price,
                'weight' => $weight,
            ]);
        });
    }

    public function removeItem($itemId)
    {
        $cart = $this->getCart();

        return DB::transaction(function () use ($cart, $itemId) {
            $cart->items()->where('id', $itemId)->delete();
        });
    }

    public function removeAllItems()
    {
        $cart = $this->getCart();

        return DB::transaction(function () use ($cart) {
            $cart->items()->delete();
        });
    }
}
