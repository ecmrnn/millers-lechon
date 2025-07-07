<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    protected $guarded = [];
    
    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class);
    }

    public function lechons(): BelongsToMany {
        return $this->belongsToMany(Lechon::class, 'lechon_orders')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
        
    }
}
