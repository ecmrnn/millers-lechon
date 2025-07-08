<?php

namespace App\Services;

use App\Models\Customer;
use App\Enums\OrderStatus;
use App\Models\LechonOrder;
use Illuminate\Support\Facades\DB;

class OrderService {
    public function create($order) {
        DB::transaction(function () use ($order) {
            // Create customer record
            $customer = null;

            if (! Customer::whereEmail($order['email'])->exists()) {
                $customer = Customer::create([
                    'first_name' => $order['first_name'],
                    'last_name' => $order['last_name'],
                    'home_address' => $order['home_address'],
                    'email' => $order['email'],
                    'contact_number' => $order['contact_number'],
                ]);
            } else {
                $customer = Customer::whereEmail($order['email'])->first();
            }

            // Create order record
            $created_order = $customer->orders()->create([
                'order_date' => $order['order_date'],
                'order_time' => $order['order_time'],
                'shipping_option' => $order['shipping_option'],
                'delivery_address' => $order['shipping_option'] === 'deliver' ? $order['delivery_address'] : null,
                'note' => $order['note'],
            ]);

            // Create lechon orders record
            foreach ($order['cart'] as $key => $cart) {
                LechonOrder::create([
                    'order_id' => $created_order->id,
                    'lechon_id' => $cart['lechon']->id,
                    'freebie_id' => $cart['freebie']->id,
                    'quantity' => $cart['quantity'],
                    'price' => $cart['lechon']->price,
                ]);
            }

            // Create payment record
            // dd('test');
        });
    }
}