<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Billing;
use App\Models\Customer;
use App\Models\Freebie;
use App\Models\Lechon;
use App\Models\LechonOrder;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderService {
    public function create($data) {
        return DB::transaction(function () use ($data) {
            // 1. Update or Create Customer Data
            $customer = Customer::updateOrCreate([
                'email' => $data['email'],
            ],[
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'contact_number' => $data['contact_number'],
                'address' => $data['address'],
                'is_active' => true,
            ]);

            // 2. Create Order
            $order_number = 'ORD' . now()->format('Ymd') . random_int(10000, 99999);
            $order = $customer->orders()->create([
                'order_number' => $order_number,
                'order_date' => $data['order_date'] . ' ' . $data['order_time'],
                'is_pickup' => filter_var($data['is_pickup'], FILTER_VALIDATE_BOOLEAN),
                'delivery_address' => $data['delivery_address'],
                'delivery_fee' => $data['delivery_fee'] ?? 0,
                'note' => $data['note'],
                'status' => OrderStatus::ORDERED,
            ]);

            // 3. Create Lechon Orders
            foreach ($data['reserved_lechons'] as $lechon) {
                $freebie = Freebie::whereName($lechon['freebie'])->first();
                
                LechonOrder::create([
                    'order_id' => $order->id,
                    'lechon_id' => $lechon['lechon']->id,
                    'freebie_id' => $freebie->id,
                    'quantity' => $lechon['quantity'],
                    'price' => $lechon['lechon']->price,
                ]);
            }

            // 4. Create Billing
            $billing = Billing::create([
                'order_id' => $order->id,
                'sub_total' => $data['total_amount'],
                'total_amount' => $data['total_amount'],
                'balance' => $data['total_amount'],
                'status' => 0,
            ]);

            // 5. Create Payment
            $billing->payments()->create([
                'customer_id' => $customer->id,
                'amount' => 0,
                'receipt_image' => $data['receipt_image']->storeAs('receipts', "Receipt - {$order->order_number}.jpg"),
            ]);

            // 6. Send Email
            // Mail::to($data['email'])->send(new ReservationReceived);

            return $order;
        });
    }
}