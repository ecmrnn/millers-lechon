<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Discount extends Model
{
    protected $guarded = [];

    public function billing(): BelongsTo {
        return $this->belongsTo(Billing::class);
    }
}
