<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $guarded = [];

    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class);
    }

    public function billing(): HasOne {
        return $this->hasOne(Billing::class);
    }

    public function lechons(): BelongsToMany
    {
        return $this->belongsToMany(Lechon::class, 'lechon_orders')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }

    public $casts = [
        'status' => OrderStatus::class,
    ];
}
