<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Billing extends Model
{
    protected $guarded = [];

    public function order(): BelongsTo {
        return $this->belongsTo(Order::class);
    }

    public function discounts(): HasMany {
        return $this->hasMany(Discount::class);
    }

    public function payments(): HasMany {
        return $this->hasMany(Payment::class);
    }
}
