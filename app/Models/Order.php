<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'order_type_id',
        'area_id',
        'delivery_driver_id',
        'recipient_name',
        'recipient_phone',
        'recipient_address',
        'collect_required',
        'collect_amount',
        'delivery_price',
        'notes',
        'status',
        'scheduled_at',
    ];

    protected $casts = [
        'collect_required' => 'boolean',
        'scheduled_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderType(): BelongsTo
    {
        return $this->belongsTo(OrderType::class);
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function deliveryDriver(): BelongsTo
    {
        return $this->belongsTo(DeliveryDriver::class);
    }
}
