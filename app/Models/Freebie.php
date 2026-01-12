<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Freebie extends Model
{
    protected $guarded = [];

    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
}
