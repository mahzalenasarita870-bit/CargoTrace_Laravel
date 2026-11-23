<?php

namespace App\Http\Controllers;

use App\Models\Carrier;
use App\Models\Location;
use App\Models\Shipment;
use App\Models\User;
use App\Services\EtaService;
use App\Services\ExternalLogisticsService;
use App\Services\ShipmentService;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ShipmentController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Shipment::query()
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
            );

        // Customer hanya dapat melihat shipment miliknya sendiri
        if ($request->user()->isCustomer()) {
            $query->where('shipments.customer_id', $request->user()->id);
        }

        // Fitur Search & Filter server-side
        if ($request->filled('search')) {
            $query->where('shipments.shipment_number', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('shipments.current_status', $request->status);
        }

        if ($request->filled('carrier_id')) {
            $query->where('shipments.carrier_id', $request->carrier_id);
        }

        if ($request->filled('delayed')) {
            $query->where('shipments.is_delayed', filter_var($request->delayed, FILTER_VALIDATE_BOOLEAN));
        }

        $shipments = $query->latest('shipments.created_at')->paginate(10)->withQueryString();

        return view('shipments.index', compact('shipments'));
    }

    public function create()
    {
        $this->authorize('create', Shipment::class);

        $customers = User::where('role', 'customer')->orderBy('name')->get();
        if ($customers->isEmpty()) {
            $customers = User::orderBy('name')->get();
        }

        $carriers = Carrier::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();

        return view('shipments.create', compact(
            'customers',
            'carriers',
            'locations'
        ));
    }

    public function store(Request $request, ShipmentService $shipmentService)
    {
        $this->authorize('create', Shipment::class);

        $validated = $request->validate([
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
            'estimated_arrival' => 'nullable|date',
        ]);

        $shipmentService->createShipment($validated, $request->user());

        return redirect()->route('shipments.index')
            ->with('success', 'Data shipment berhasil ditambahkan.');
    }

    public function show(Shipment $shipment, ExternalLogisticsService $externalService)
    {
        $this->authorize('view', $shipment);

        $shipment->load([
            'customer',
            'carrier',
            'origin',
            'destination',
            'trackingEvents.location',
            'exceptions',
        ]);

        $latestEvent = $shipment->trackingEvents->last();
        $lat = $latestEvent?->latitude ?? $shipment->destination?->latitude;
        $lng = $latestEvent?->longitude ?? $shipment->destination?->longitude;
        $weather = $externalService->getWeatherByCoordinates($lat, $lng);

        return view('shipments.show', compact('shipment', 'weather'));
    }

    public function edit(Shipment $shipment)
    {
        $this->authorize('update', $shipment);

        $customers = User::where('role', 'customer')->orderBy('name')->get();
        if ($customers->isEmpty()) {
            $customers = User::orderBy('name')->get();
        }

        $carriers = Carrier::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();

        return view('shipments.edit', compact(
            'shipment',
            'customers',
            'carriers',
            'locations'
        ));
    }

    public function update(
        Request $request,
        Shipment $shipment,
        ShipmentService $shipmentService,
        EtaService $etaService
    ) {
        $this->authorize('update', $shipment);

        $validated = $request->validate([
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
            'estimated_arrival' => 'nullable|date',
            'current_status' => 'required|string|max:255',
        ]);

        // Validasi transisi status via ShipmentService jika status berubah
        if ($validated['current_status'] !== $shipment->current_status) {
            $shipmentService->transitionStatus($shipment, $validated['current_status'], $request->user());
        }

        $shipment->fill([
            'shipment_number' => $validated['shipment_number'],
            'customer_id' => $validated['customer_id'],
            'carrier_id' => $validated['carrier_id'],
            'origin_location_id' => $validated['origin_location_id'],
            'destination_location_id' => $validated['destination_location_id'],
            'cargo_type' => $validated['cargo_type'],
            'weight' => $validated['weight'] ?? null,
            'volume' => $validated['volume'] ?? null,
            'expected_departure' => $validated['expected_departure'] ?? null,
            'expected_arrival' => $validated['expected_arrival'] ?? null,
        ]);
        $shipment->save();

        // Evaluasi ulang ETA & keterlambatan
        $newEta = !empty($validated['estimated_arrival'])
            ? Carbon::parse($validated['estimated_arrival'])
            : ($shipment->estimated_arrival ?? $shipment->expected_arrival);

        $etaService->evaluateDelay($shipment, $newEta);

        return redirect()->route('shipments.index')
            ->with('success', 'Data shipment berhasil diperbarui.');
    }

    public function destroy(Shipment $shipment)
    {
        $this->authorize('delete', $shipment);

        $shipment->delete();

        return redirect()->route('shipments.index')
            ->with('success', 'Data shipment berhasil dihapus.');
    }
}