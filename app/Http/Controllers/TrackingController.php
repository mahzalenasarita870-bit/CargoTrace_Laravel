<?php

namespace App\Http\Controllers;

use App\Models\TrackingEvent;
use App\Models\Shipment;
use App\Models\Location;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        $trackingEvents = TrackingEvent::with([
            'shipment',
            'location',
            'creator'
        ])
        ->latest('event_time')
        ->paginate(10);

        return view('tracking.index', compact('trackingEvents'));
    }

    public function create()
    {
        $shipments = Shipment::all();
        $locations = Location::all();

        return view('tracking.create', compact(
            'shipments',
            'locations'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipment_id' => 'required|exists:shipments,id',
            'event_type' => 'required|in:CREATED,BOOKED,PICKED_UP,IN_TRANSIT,ARRIVED,DELIVERED,DELAYED',
            'event_time' => 'required|date',
            'location_id' => 'nullable|exists:locations,id',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'description' => 'nullable|string|max:1000',
        ]);

        $validated['created_by'] = auth()->id();

        TrackingEvent::create($validated);

        return redirect()
            ->route('tracking.index')
            ->with('success', 'Tracking event berhasil ditambahkan.');
    }

    public function history(Shipment $shipment)
{
    $trackingEvents = TrackingEvent::with([
        'shipment',
        'location',
        'creator'
    ])
    ->where('shipment_id', $shipment->id)
    ->orderBy('event_time', 'asc')
    ->get();

    return view('tracking.history', compact(
        'shipment',
        'trackingEvents'
    ));
}

    public function search(Request $request)
{
    $request->validate([
        'shipment_number' => 'required|string',
    ]);

    $shipment = Shipment::where(
        'shipment_number',
        $request->shipment_number
    )->first();

    if (!$shipment) {
        return redirect()
            ->route('tracking.index')
            ->with('error', 'Shipment tidak ditemukan.');
    }

    return redirect()->route(
        'tracking.history',
        $shipment->id
    );
}
}