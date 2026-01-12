<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
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
            return Cart::with('items.product')
                ->with('items.freebie')
                ->where('customer_id', Auth::id())->firstOrCreate(
                    ['customer_id' => Auth::id()],
                    ['session_id' => $sessionId, 'status' => 'active']
                );
        }

        return Cart::with('items.product')
            ->with('items.freebie')
            ->where('session_id', $sessionId)->firstOrCreate(
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

    public function mergeCart(Customer $customer, string $sessionId)
    {
        $guestCart = Cart::where('session_id', $sessionId)->first();
    
        if (!$guestCart) return;
    
        $existingCart = $customer->cart;

        DB::transaction(function () use ($customer, $guestCart, $existingCart, $sessionId) {
            if ($existingCart) {
                $duplicateItemIds = [];

                // Merge quantities when same product exists in both carts
                foreach ($guestCart->items as $item) {
                    $existingItem = $existingCart->items()
                        ->where([
                            'product_id' => $item->product_id,
                            'freebie_id' => $item->freebie_id,
                            'weight' => $item->weight])
                        ->first();
                    
                    if ($existingItem) {
                        $existingItem->increment('quantity', $item->quantity);
                        $duplicateItemIds[] = $item->id;
                    } 
                }

                if (!empty($duplicateItemIds)) {
                    $guestCart->items()->whereIn('id', $duplicateItemIds)->delete();
                }

                $guestCart->items()->update(['cart_id' => $existingCart->id]);
                $guestCart->delete();
            } else {
                $guestCart->update([
                    'customer_id' => $customer->id,
                    'session_id' => Session::getId(),
                ]);
            }
        });
    }
}
