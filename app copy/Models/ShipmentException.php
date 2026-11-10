<?php
namespace App\\Models;
use Illuminate\\Database\\Eloquent\\Model;
class ShipmentException extends Model {
    protected $fillable = ['shipment_id','type','severity','status','detected_at','resolved_at','description','created_by'];
    protected $casts = ['detected_at'=>'datetime','resolved_at'=>'datetime'];
    public function shipment(){ return $this->belongsTo(Shipment::class); }
}
