<?php
namespace App\\Http\\Controllers\\Api;
use App\\Http\\Controllers\\Controller;
use App\\Models\\Shipment;
use Illuminate\\Http\\Request;
class ShipmentApiController extends Controller {
    public function index(Request $request){
        $q=Shipment::with(['carrier','origin','destination']);
        if($request->user()->role==='CUSTOMER') $q->where('customer_id',$request->user()->id);
        if($request->filled('status')) $q->where('status',$request->status);
        return response()->json($q->paginate(15));
    }
    public function store(Request $request){
        abort_unless(in_array($request->user()->role,['ADMIN','OPERATOR'],true),403);
        $data=$request->validate([
            'customer_id'=>'required|exists:users,id','carrier_id'=>'required|exists:carriers,id',
            'origin_id'=>'required|exists:locations,id','destination_id'=>'required|exists:locations,id',
            'cargo_type'=>'required|string|max:100','weight_kg'=>'required|numeric|min:0.01',
            'expected_departure'=>'required|date','expected_arrival'=>'required|date|after:expected_departure'
        ]);
        $data['shipment_number']='CT-'.strtoupper(\\Illuminate\\Support\\Str::random(10));$data['status']='CREATED';
        return response()->json(Shipment::create($data),201);
    }
    public function show(Request $request, Shipment $shipment){
        abort_if($request->user()->role==='CUSTOMER' && $shipment->customer_id!==$request->user()->id,403);
        return response()->json($shipment->load(['carrier','origin','destination','trackingEvents.location','exceptions']));
    }
    public function update(Request $request, Shipment $shipment){
        abort_unless(in_array($request->user()->role,['ADMIN','OPERATOR'],true),403);
        $data=$request->validate(['estimated_arrival'=>'nullable|date']);
        $shipment->update($data);return response()->json($shipment);
    }
    public function destroy(Request $request, Shipment $shipment){
        abort_unless($request->user()->role==='ADMIN',403);
        $shipment->delete();return response()->json(['message'=>'Deleted']);
    }
    public function tracking(Shipment $shipment){return response()->json($shipment->trackingEvents()->with('location')->orderBy('occurred_at')->get());}
}
