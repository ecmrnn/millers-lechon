<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    protected $guarded = [];

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'order_items')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }
}
