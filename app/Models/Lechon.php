<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lechon extends Model
{
    protected $guarded = [];

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(LechonOrder::class, 'lechon_orders')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }
}
