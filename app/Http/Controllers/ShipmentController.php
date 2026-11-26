<?php

namespace App\Http\Controllers;

use App\Models\Carrier;
use App\Models\Location;
use App\Models\Shipment;
use App\Models\User;
use App\Services\EtaService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ShipmentController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Shipment::with(['customer', 'carrier', 'origin', 'destination']);

        if ($user->isCustomer()) {
            $query->where('customer_id', $user->id);
        }

        if ($request->filled('status')) {
            $query->where('current_status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('shipment_number', 'like', '%' . $request->search . '%');
        }

        $shipments = $query->latest()->paginate(10);

        return view('shipments.index', compact('shipments'));
    }

    public function show(Shipment $shipment)
    {
        Gate::authorize('view', $shipment);

        $shipment->load([
            'customer',
            'carrier',
            'origin',
            'destination',
            'trackingEvents' => fn ($q) => $q->with(['location', 'creator'])->orderBy('event_time', 'asc'),
            'exceptions' => fn ($q) => $q->latest('detected_at'),
        ]);

        return view('shipments.show', compact('shipment'));
    }

    public function create()
    {
        Gate::authorize('create', Shipment::class);

        $customers = User::where('role', 'customer')->get();
        $carriers = Carrier::all();
        $locations = Location::all();

        return view('shipments.create', compact('customers', 'carriers', 'locations'));
    }

    public function store(Request $request, EtaService $etaService)
    {
        Gate::authorize('create', Shipment::class);

        $validated = $request->validate([
            'shipment_number' => 'required|string|unique:shipments,shipment_number',
            'customer_id' => 'required|exists:users,id',
            'carrier_id' => 'required|exists:carriers,id',
            'origin_location_id' => 'required|exists:locations,id',
            'destination_location_id' => 'required|exists:locations,id|different:origin_location_id',
            'cargo_type' => 'required|string|max:255',
            'weight' => 'nullable|numeric|min:0',
            'volume' => 'nullable|numeric|min:0',
            'expected_departure' => 'required|date',
            'expected_arrival' => 'required|date|after_or_equal:expected_departure',
            'estimated_arrival' => 'nullable|date',
        ]);

        $validated['estimated_arrival'] = $validated['estimated_arrival'] ?? $validated['expected_arrival'];
        $validated['current_status'] = 'CREATED';

        $shipment = Shipment::create($validated);
        $etaService->evaluateDelay($shipment);
        $shipment->refresh();

        $isDelayed = (bool) ($shipment->is_delayed ?? false);

        NotificationService::notifyShipment(
            $shipment,
            $isDelayed ? 'DELAY_ALERT' : 'STATUS_UPDATE',
            $isDelayed
                ? "Peringatan Delay {$shipment->shipment_number}"
                : "Shipment Baru {$shipment->shipment_number} Dibuat",
            $shipment->delay_reason
                ?: "Pengiriman {$shipment->shipment_number} ({$shipment->cargo_type}) berhasil dibuat dengan status {$shipment->current_status}."
        );

        return redirect()->route('shipments.show', $shipment)->with('success', 'Shipment berhasil dibuat.');
    }

    public function edit(Shipment $shipment)
    {
        Gate::authorize('update', $shipment);

        $customers = User::where('role', 'customer')->get();
        $carriers = Carrier::all();
        $locations = Location::all();

        return view('shipments.edit', compact('shipment', 'customers', 'carriers', 'locations'));
    }

    public function update(Request $request, Shipment $shipment, EtaService $etaService)
    {
        Gate::authorize('update', $shipment);

        $validated = $request->validate([
            'shipment_number' => 'required|string|max:100|unique:shipments,shipment_number,' . $shipment->id,
            'customer_id' => 'required|exists:users,id',
            'carrier_id' => 'required|exists:carriers,id',
            'origin_location_id' => 'required|exists:locations,id',
            'destination_location_id' => 'required|exists:locations,id|different:origin_location_id',
            'cargo_type' => 'required|string|max:255',
            'weight' => 'nullable|numeric|min:0',
            'volume' => 'nullable|numeric|min:0',
            'expected_departure' => 'required|date',
            'expected_arrival' => 'required|date|after_or_equal:expected_departure',
            'estimated_arrival' => 'nullable|date',
            'current_status' => 'required|string',
            'delay_reason' => 'nullable|string|max:500',
        ]);

        if ($validated['current_status'] === 'DELIVERED' && !$shipment->actual_arrival) {
            $validated['actual_arrival'] = now();
        }

        $shipment->update($validated);
        $etaService->evaluateDelay($shipment, null, $validated['delay_reason'] ?? $shipment->delay_reason);
        $shipment->refresh();

        $isDelayed = (bool) ($shipment->is_delayed ?? false);
        $isDelivered = strtoupper($shipment->current_status) === 'DELIVERED';

        $type = $isDelayed ? 'DELAY_ALERT' : 'STATUS_UPDATE';
        $title = $isDelayed
            ? "Peringatan Delay {$shipment->shipment_number}"
            : ($isDelivered
                ? "Pengiriman {$shipment->shipment_number} Selesai (DELIVERED)"
                : "Update Status {$shipment->shipment_number}: {$shipment->current_status}");

        $message = $isDelayed
            ? ($shipment->delay_reason ?: "Terjadi indikasi keterlambatan pada pengiriman {$shipment->shipment_number}.")
            : ($isDelivered
                ? "Pengiriman {$shipment->shipment_number} telah berstatus DELIVERED."
                : "Status pengiriman {$shipment->shipment_number} diperbarui menjadi {$shipment->current_status}.");

        NotificationService::notifyShipment($shipment, $type, $title, $message);

        return redirect()->route('shipments.show', $shipment)->with('success', 'Data shipment berhasil diperbarui.');
    }

    public function destroy(Shipment $shipment)
    {
        Gate::authorize('delete', $shipment);

        $shipment->delete();

        return redirect()->route('shipments.index')->with('success', 'Shipment berhasil dihapus.');
    }
}