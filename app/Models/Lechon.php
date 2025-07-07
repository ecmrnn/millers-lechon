<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lechon extends Model
{
    public function orders(): BelongsToMany {
        return $this->belongsToMany(Order::class, 'lechon_orders')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
}
