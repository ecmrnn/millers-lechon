<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProduct extends Pivot
{
    public function freebie(): BelongsTo
    {
        return $this->belongsTo(Freebie::class);
    }
}
