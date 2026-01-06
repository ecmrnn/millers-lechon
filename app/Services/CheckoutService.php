<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutService
{
    public function checkout(Cart $cart, array $data)
    {
        return DB::transaction(function () use ($cart, $data) {
            $balance = 0;
            $customerId = $cart->customer 
                ? $cart->customer->id
                : null;

            // Create the order
            $order = Order::create([
                'customer_id' => $customerId,
                'order_date' => $data['order_date'],
                'order_time' => $data['order_time'],
                'shipping_mode' => $data['shipping_mode'],
                'deliver_street' => $data['deliver_street'] ?? null,
                'deliver_city' => $data['deliver_city'] ?? null,
                'deliver_province' => $data['deliver_province'] ?? null,
                'note' => $data['note'] ?? null,
            ]);

            // Create order products records
            foreach ($cart->items as $item) {
                $freebieId = $item->freebie 
                    ? $item->freebie->id
                    : null;

                $order->products()->create([
                    'product_id' => $item->product_id,
                    'freebie_id' => $freebieId,
                    'quantity' => $item->quantity,
                    'weight' => $item->weight,
                    'price' => $item->price,
                ]);

                $balance += $item->price * $item->quantity;
            }

            // Create order transactions record
            $shippingCost = 0; // Will be calculated later

            $transaction = $order->transaction()->create([
                'shipping_cost' => $shippingCost,
                'balance' => $balance,
                'paid_amount' => 0,
            ]);

            // Create initial payment record
            $imagePath = $data['image']->store('payments') ?? null;

            $transaction->payments()->create([
                'amount' => 0,
                'image' => $imagePath,
                'mode_of_payment' => 'gcash',
            ]);

            // Clear the cart and items
            $cart->converted_order_id = $order->id;
            $cart->save();
            $cart->items()->delete();

            return $order->fresh();
        });
    }
}
