<?php

use App\Models\Customer;
use App\Models\Freebie;
use App\Models\Lechon;
use App\Models\Order;
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
            $table->foreignIdFor(Customer::class)->constrained()->cascadeOnDelete();
            $table->string('order_number')->unique();

            // Choose either pickup or delivery
            $table->timestamp('order_date');
            $table->boolean('is_pickup')->default(true);
            
            // For delivery orders
            $table->string('delivery_address')->nullable();
            $table->string('delivery_fee')->default(0);

            $table->string('note')->nullable();
            $table->tinyInteger('status');
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
