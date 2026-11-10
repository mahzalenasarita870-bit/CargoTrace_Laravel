<?php
namespace App\\Http\\Controllers;
use App\\Models\\Shipment;
use App\\Models\\Location;
use Illuminate\\Http\\Request;
class TrackingController extends Controller {
    public function index(Shipment $shipment){
        $shipment->load('trackingEvents.location');
        return view('tracking.index',['shipment'=>$shipment,'locations'=>Location::all()]);
    }
    public function store(Request $request, Shipment $shipment){
        $data=$request->validate([
            'event_type'=>'required|string|max:80','occurred_at'=>'required|date',
            'location_id'=>'nullable|exists:locations,id','latitude'=>'nullable|numeric|between:-90,90',
            'longitude'=>'nullable|numeric|between:-180,180','description'=>'required|string|max:1000'
        ]);
        if($shipment->trackingEvents()->where('occurred_at','>',$data['occurred_at'])->exists())
            return back()->withErrors(['occurred_at'=>'Waktu event tidak boleh lebih awal dari event yang sudah tercatat.']);
        $data['created_by']=$request->user()->id;
        $shipment->trackingEvents()->create($data);
        if(in_array($data['event_type'],['BOOKED','PICKED_UP','IN_TRANSIT','DELIVERED'],true)){
            $shipment->update(['status'=>$data['event_type']]);
        }
        return back()->with('success','Tracking event ditambahkan.');
    }
}
