<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shipment extends Model
{
    protected $fillable = [
        'shipment_number',
        'customer_id',
        'carrier_id',
        'origin_location_id',
        'destination_location_id',
        'cargo_type',
        'weight',
        'volume',
        'expected_departure',
        'expected_arrival',
        'estimated_arrival',
        'actual_arrival',
        'current_status',
        'is_delayed',
        'delay_hours',
        'delay_severity',
        'delay_reason',
    ];

    protected $casts = [
        'expected_departure' => 'datetime',
        'expected_arrival' => 'datetime',
        'estimated_arrival' => 'datetime',
        'actual_arrival' => 'datetime',
        'weight' => 'decimal:2',
        'volume' => 'decimal:2',
        'is_delayed' => 'boolean',
        'delay_hours' => 'integer',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function carrier(): BelongsTo
    {
        return $this->belongsTo(Carrier::class);
    }

    public function origin(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'origin_location_id');
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'destination_location_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(ShipmentItem::class);
    }

    public function trackingEvents(): HasMany
    {
        return $this->hasMany(TrackingEvent::class)->orderBy('event_time', 'asc');
    }

    public function exceptions(): HasMany
    {
        return $this->hasMany(ShipmentException::class);
    }
}