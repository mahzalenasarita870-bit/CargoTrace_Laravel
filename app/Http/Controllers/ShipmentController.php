<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\User;
use App\Models\Carrier;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ShipmentController extends Controller
{
    public function index()
    {
        $shipments = Shipment::query()
            ->join('users', 'shipments.customer_id', '=', 'users.id')
            ->join('carriers', 'shipments.carrier_id', '=', 'carriers.id')
            ->join('locations as origin', 'shipments.origin_location_id', '=', 'origin.id')
            ->join('locations as destination', 'shipments.destination_location_id', '=', 'destination.id')
            ->select(
                'shipments.*',
                'users.name as customer_name',
                'carriers.name as carrier_name',
                'origin.name as origin_name',
                'destination.name as destination_name'
            )
            ->latest('shipments.created_at')
            ->paginate(10);

        return view('shipments.index', compact('shipments'));
    }

    public function create()
    {
        $customers = User::orderBy('name')->get();
        $carriers = Carrier::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();

        return view('shipments.create', compact(
            'customers',
            'carriers',
            'locations'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipment_number' => 'required|string|max:255|unique:shipments,shipment_number',
            'customer_id' => 'required|exists:users,id',
            'carrier_id' => 'required|exists:carriers,id',
            'origin_location_id' => 'required|exists:locations,id',
            'destination_location_id' => [
                'required',
                'exists:locations,id',
                'different:origin_location_id',
            ],
            'cargo_type' => 'required|string|max:255',
            'weight' => 'nullable|numeric|min:0',
            'volume' => 'nullable|numeric|min:0',
            'expected_departure' => 'nullable|date',
            'expected_arrival' => 'nullable|date|after_or_equal:expected_departure',
            'current_status' => 'nullable|string|max:255',
        ]);

        $shipment = new Shipment();

        $shipment->shipment_number = $request->shipment_number;
        $shipment->customer_id = $request->customer_id;
        $shipment->carrier_id = $request->carrier_id;
        $shipment->origin_location_id = $request->origin_location_id;
        $shipment->destination_location_id = $request->destination_location_id;
        $shipment->cargo_type = $request->cargo_type;
        $shipment->weight = $request->weight;
        $shipment->volume = $request->volume;
        $shipment->expected_departure = $request->expected_departure;
        $shipment->expected_arrival = $request->expected_arrival;
        $shipment->current_status = $request->current_status ?? 'CREATED';

        $shipment->save();

        return redirect()->route('shipments.index')
            ->with('success', 'Data shipment berhasil ditambahkan.');
    }

    public function edit(Shipment $shipment)
    {
        $customers = User::orderBy('name')->get();
        $carriers = Carrier::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();

        return view('shipments.edit', compact(
            'shipment',
            'customers',
            'carriers',
            'locations'
        ));
    }

    public function update(Request $request, Shipment $shipment)
    {
        $request->validate([
            'shipment_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('shipments', 'shipment_number')->ignore($shipment->id),
            ],
            'customer_id' => 'required|exists:users,id',
            'carrier_id' => 'required|exists:carriers,id',
            'origin_location_id' => 'required|exists:locations,id',
            'destination_location_id' => [
                'required',
                'exists:locations,id',
                'different:origin_location_id',
            ],
            'cargo_type' => 'required|string|max:255',
            'weight' => 'nullable|numeric|min:0',
            'volume' => 'nullable|numeric|min:0',
            'expected_departure' => 'nullable|date',
            'expected_arrival' => 'nullable|date|after_or_equal:expected_departure',
            'current_status' => 'required|string|max:255',
        ]);

        $shipment->shipment_number = $request->shipment_number;
        $shipment->customer_id = $request->customer_id;
        $shipment->carrier_id = $request->carrier_id;
        $shipment->origin_location_id = $request->origin_location_id;
        $shipment->destination_location_id = $request->destination_location_id;
        $shipment->cargo_type = $request->cargo_type;
        $shipment->weight = $request->weight;
        $shipment->volume = $request->volume;
        $shipment->expected_departure = $request->expected_departure;
        $shipment->expected_arrival = $request->expected_arrival;
        $shipment->current_status = $request->current_status;

        $shipment->save();

        return redirect()->route('shipments.index')
            ->with('success', 'Data shipment berhasil diperbarui.');
    }

    public function destroy(Shipment $shipment)
    {
        $shipment->delete();

        return redirect()->route('shipments.index')
            ->with('success', 'Data shipment berhasil dihapus.');
    }
}
