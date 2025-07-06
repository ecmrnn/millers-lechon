<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class OrderService {
    public function create($order) {
        DB::transaction(function () use ($order) {
            // Create customer record
            // Create order record
            // Create lechon orders record
            // Create payment record
        });
    }
}