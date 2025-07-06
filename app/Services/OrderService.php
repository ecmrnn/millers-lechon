<?php

namespace App\Services;

use App\Models\Customer;
use App\Enums\OrderStatus;
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
            $order = $customer->orders()->create([
                'order_date' => $order['order_date'],
                'order_time' => $order['order_time'],
                'shipping_option' => $order['shipping_option'],
                'delivery_address' => $order['shipping_option'] === 'deliver' ? $order['delivery_address'] : null,
            ]);

            // Create lechon orders record
            
            // Create payment record
        });
    }
}