<?php
namespace App\\Models;
use Illuminate\\Database\\Eloquent\\Model;
class TrackingEvent extends Model {
    protected $fillable = ['shipment_id','event_type','occurred_at','location_id','latitude','longitude','description','created_by'];
    protected $casts = ['occurred_at'=>'datetime'];
    public function shipment(){ return $this->belongsTo(Shipment::class); }
    public function location(){ return $this->belongsTo(Location::class); }
    public function creator(){ return $this->belongsTo(User::class,'created_by'); }
}
