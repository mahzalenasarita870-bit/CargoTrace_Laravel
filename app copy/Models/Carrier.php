<?php
namespace App\\Models;
use Illuminate\\Database\\Eloquent\\Model;
class Carrier extends Model {
    protected $fillable = ['name','code','phone','email'];
    public function shipments(){ return $this->hasMany(Shipment::class); }
}
