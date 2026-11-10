<?php
namespace App\\Models;
use Illuminate\\Database\\Eloquent\\Model;
class Shipment extends Model {
    protected $fillable = ['shipment_number','customer_id','carrier_id','origin_id','destination_id','cargo_type','weight_kg','expected_departure','expected_arrival','estimated_arrival','status'];
    protected $casts = ['expected_departure'=>'datetime','expected_arrival'=>'datetime','estimated_arrival'=>'datetime','weight_kg'=>'decimal:2'];
    public function customer(){ return $this->belongsTo(User::class,'customer_id'); }
    public function carrier(){ return $this->belongsTo(Carrier::class); }
    public function origin(){ return $this->belongsTo(Location::class,'origin_id'); }
    public function destination(){ return $this->belongsTo(Location::class,'destination_id'); }
    public function trackingEvents(){ return $this->hasMany(TrackingEvent::class)->orderBy('occurred_at'); }
    public function exceptions(){ return $this->hasMany(ShipmentException::class); }
}
