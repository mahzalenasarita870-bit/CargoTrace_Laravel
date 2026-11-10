<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\User;
use App\Models\Carrier;
use App\Models\Location;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function index()
    {
        $shipments = Shipment::with([
            'customer',
            'carrier',
            'origin',
            'destination'
        ])->latest()->paginate(10);

        return view('shipments.index', compact('shipments'));
    }

    public function create()
    {
        $customers = User::where('role', 'CUSTOMER')->get();
        $carriers = Carrier::all();
        $locations = Location::all();

        return view('shipments.create', compact(
            'customers',
            'carriers',
            'locations'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipment_number' => 'required|string|unique:shipments,shipment_number',
            'customer_id' => 'required|exists:users,id',
            'carrier_id' => 'required|exists:carriers,id',
            'origin_location_id' => 'required|exists:locations,id',
            'destination_location_id' => 'required|exists:locations,id',
            'cargo_type' => 'required|string|max:255',
            'weight' => 'nullable|numeric|min:0',
            'volume' => 'nullable|numeric|min:0',
            'expected_departure' => 'nullable|date',
            'expected_arrival' => 'nullable|date|after_or_equal:expected_departure',
            'current_status' => 'required|in:CREATED,BOOKED,PICKED_UP,IN_TRANSIT,DELIVERED',
        ]);

        Shipment::create($validated);

        return redirect()
            ->route('shipments.index')
            ->with('success', 'Shipment berhasil ditambahkan.');
    }
}
