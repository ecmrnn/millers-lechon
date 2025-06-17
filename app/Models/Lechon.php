<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Lechon extends Model
{
    protected $guarded = [];

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'lechon_orders')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }

    public function freebie()
    {
        return $this->hasOneThrough(Freebie::class, LechonOrder::class, 'lechon_id', 'id', 'id', 'freebie_id');
    }
}
