<?php
namespace App\\Http\\Controllers;
use App\\Models\\Shipment;
use App\\Models\\ShipmentException;
class DashboardController extends Controller {
    public function index(){
        $stats = [
            'total'=>Shipment::count(),
            'in_transit'=>Shipment::where('status','IN_TRANSIT')->count(),
            'delivered'=>Shipment::where('status','DELIVERED')->count(),
            'delayed'=>Shipment::whereNotNull('estimated_arrival')->whereColumn('estimated_arrival','>','expected_arrival')->count(),
            'open_exceptions'=>ShipmentException::whereIn('status',['OPEN','INVESTIGATING'])->count(),
        ];
        $shipments=Shipment::with(['carrier','origin','destination'])->latest()->paginate(8);
        return view('dashboard',compact('stats','shipments'));
    }
}
