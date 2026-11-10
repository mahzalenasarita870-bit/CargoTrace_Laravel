<?php
namespace App\\Http\\Controllers;
use App\\Models\\Shipment;
use App\\Models\\Carrier;
use App\\Models\\Location;
use Illuminate\\Http\\Request;
use Illuminate\\Support\\Str;

class ShipmentController extends Controller {
    private const TRANSITIONS = [
        'CREATED'=>['BOOKED'], 'BOOKED'=>['PICKED_UP'],
        'PICKED_UP'=>['IN_TRANSIT'], 'IN_TRANSIT'=>['DELIVERED'],
        'DELIVERED'=>[]
    ];
    public function index(Request $request){
        $q=Shipment::with(['customer','carrier','origin','destination']);
        if($request->filled('search')) $q->where('shipment_number','like','%'.$request->search.'%');
        if($request->filled('status')) $q->where('status',$request->status);
        $shipments=$q->latest()->paginate(10)->withQueryString();
        return view('shipments.index',compact('shipments'));
    }
    public function create(){ return view('shipments.create',['carriers'=>Carrier::all(),'locations'=>Location::all()]); }
    public function store(Request $request){
        $data=$request->validate([
            'customer_id'=>'required|exists:users,id','carrier_id'=>'required|exists:carriers,id',
            'origin_id'=>'required|exists:locations,id','destination_id'=>'required|exists:locations,id',
            'cargo_type'=>'required|string|max:100','weight_kg'=>'required|numeric|min:0.01',
            'expected_departure'=>'required|date','expected_arrival'=>'required|date|after:expected_departure',
        ]);
        $data['shipment_number']='CT-'.strtoupper(Str::random(10)); $data['status']='CREATED';
        $shipment=Shipment::create($data);
        return redirect()->route('shipments.show',$shipment)->with('success','Shipment berhasil dibuat.');
    }
    public function show(Shipment $shipment){
        $shipment->load(['customer','carrier','origin','destination','trackingEvents.location','exceptions']);
        return view('shipments.show',compact('shipment'));
    }
    public function edit(Shipment $shipment){ return view('shipments.edit',['shipment'=>$shipment,'carriers'=>Carrier::all(),'locations'=>Location::all()]); }
    public function update(Request $request, Shipment $shipment){
        $data=$request->validate([
            'status'=>'required|in:CREATED,BOOKED,PICKED_UP,IN_TRANSIT,DELIVERED',
            'estimated_arrival'=>'nullable|date',
        ]);
        if($data['status']!==$shipment->status && !in_array($data['status'],self::TRANSITIONS[$shipment->status]??[],true))
            return back()->withErrors(['status'=>'Transisi status tidak valid.']);
        $shipment->update($data);
        return redirect()->route('shipments.show',$shipment)->with('success','Shipment diperbarui.');
    }
    public function destroy(Shipment $shipment){ $shipment->delete(); return redirect()->route('shipments.index')->with('success','Shipment dihapus.'); }
}
