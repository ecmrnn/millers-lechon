<?php

use App\Models\Customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class, 'customer_id')->constrained()->cascadeOnDelete();
            // Order details
            $table->date('order_date');
            $table->time('order_time');
            $table->enum('shipping_mode', ['pickup', 'delivery']);
            // Delivery address fields
            $table->string('deliver_street');
            $table->string('deliver_city');
            $table->string('deliver_province');
            // Other order info
            $table->enum('status', ['pending', 'confirmed', 'preparing', 'completed', 'cancelled'])->default('pending');
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
