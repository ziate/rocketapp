<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Area extends Model
{
    protected $fillable = [
        'governorate_id',
        'name',
        'delivery_price_default',
    ];

    public function governorate(): BelongsTo
    {
        return $this->belongsTo(Governorate::class);
    }

    public function customers(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class)
            ->withPivot(['custom_delivery_price'])
            ->withTimestamps();
    }
}
