<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\ShipmentException;
use App\Services\ExceptionService;
use App\Services\ExternalLogisticsService;
use App\Services\ShipmentService;
use App\Services\TrackingService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShipmentApiController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request): JsonResponse
    {
        $query = Shipment::with(['customer:id,name,email', 'carrier:id,name,code', 'origin', 'destination']);

        // Customer hanya melihat shipment miliknya
        if ($request->user()->isCustomer()) {
            $query->where('customer_id', $request->user()->id);
        }

        if ($request->filled('status')) {
            $query->where('current_status', $request->status);
        }

        if ($request->filled('shipment_number')) {
            $query->where('shipment_number', 'like', '%' . $request->shipment_number . '%');
        }

        if ($request->filled('is_delayed')) {
            $query->where('is_delayed', filter_var($request->is_delayed, FILTER_VALIDATE_BOOLEAN));
        }

        return response()->json($query->latest()->paginate(15), 200);
    }

    public function store(Request $request, ShipmentService $shipmentService): JsonResponse
    {
        $this->authorize('create', Shipment::class);

        $validated = $request->validate([
            'shipment_number' => 'required|string|unique:shipments,shipment_number',
            'customer_id' => 'required|exists:users,id',
            'carrier_id' => 'required|exists:carriers,id',
            'origin_location_id' => 'required|exists:locations,id',
            'destination_location_id' => 'required|exists:locations,id|different:origin_location_id',
            'cargo_type' => 'required|string|max:100',
            'weight' => 'nullable|numeric|min:0',
            'volume' => 'nullable|numeric|min:0',
            'expected_departure' => 'nullable|date',
            'expected_arrival' => 'nullable|date|after_or_equal:expected_departure',
            'estimated_arrival' => 'nullable|date',
        ]);

        $shipment = $shipmentService->createShipment($validated, $request->user());

        return response()->json([
            'message' => 'Shipment created successfully.',
            'data' => $shipment->load(['customer', 'carrier', 'origin', 'destination']),
        ], 201);
    }

    public function show(Shipment $shipment, ExternalLogisticsService $externalService): JsonResponse
    {
        $this->authorize('view', $shipment);

        $shipment->load(['customer', 'carrier', 'origin', 'destination', 'items', 'trackingEvents.location', 'exceptions']);

        // Ambil informasi cuaca terkini di lokasi terakhir atau tujuan
        $latestEvent = $shipment->trackingEvents->last();
        $lat = $latestEvent?->latitude ?? $shipment->destination?->latitude;
        $lng = $latestEvent?->longitude ?? $shipment->destination?->longitude;
        $weather = $externalService->getWeatherByCoordinates($lat, $lng);

        return response()->json([
            'data' => $shipment,
            'operational_weather' => $weather,
        ], 200);
    }

    public function update(Request $request, Shipment $shipment, ShipmentService $shipmentService): JsonResponse
    {
        $this->authorize('update', $shipment);

        $validated = $request->validate([
            'current_status' => 'sometimes|string',
            'cargo_type' => 'sometimes|string|max:100',
            'weight' => 'nullable|numeric|min:0',
            'volume' => 'nullable|numeric|min:0',
        ]);

        if (isset($validated['current_status']) && $validated['current_status'] !== $shipment->current_status) {
            $shipmentService->transitionStatus($shipment, $validated['current_status'], $request->user());
            unset($validated['current_status']);
        }

        if (!empty($validated)) {
            $shipment->update($validated);
        }

        return response()->json([
            'message' => 'Shipment updated successfully.',
            'data' => $shipment->fresh(),
        ], 200);
    }

    public function destroy(Shipment $shipment): JsonResponse
    {
        $this->authorize('delete', $shipment);

        $shipment->delete();

        return response()->json([
            'message' => 'Shipment deleted successfully.',
        ], 200);
    }

    public function trackingIndex(Shipment $shipment): JsonResponse
    {
        $this->authorize('view', $shipment);

        return response()->json([
            'data' => $shipment->trackingEvents()->with(['location', 'creator:id,name'])->get(),
        ], 200);
    }

    public function trackingStore(Request $request, Shipment $shipment, TrackingService $trackingService): JsonResponse
    {
        $this->authorize('update', $shipment);

        $validated = $request->validate([
            'event_type' => 'required|string',
            'event_time' => 'required|date',
            'location_id' => 'nullable|exists:locations,id',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'description' => 'nullable|string',
            'estimated_arrival' => 'nullable|date',
        ]);

        $event = $trackingService->recordEvent($shipment, $validated, $request->user());

        return response()->json([
            'message' => 'Tracking event recorded.',
            'data' => $event,
        ], 201);
    }

    public function exceptionIndex(Shipment $shipment): JsonResponse
    {
        $this->authorize('view', $shipment);

        return response()->json([
            'data' => $shipment->exceptions()->latest()->get(),
        ], 200);
    }

    public function exceptionStore(Request $request, Shipment $shipment, ExceptionService $exceptionService): JsonResponse
    {
        $this->authorize('update', $shipment);

        $validated = $request->validate([
            'exception_type' => 'required|string',
            'severity' => 'required|in:LOW,MEDIUM,HIGH',
            'description' => 'required|string',
            'detected_at' => 'nullable|date',
        ]);

        $exception = $exceptionService->reportException($shipment, $validated, $request->user());

        return response()->json([
            'message' => 'Shipment exception reported.',
            'data' => $exception,
        ], 201);
    }

    public function exceptionUpdate(Request $request, ShipmentException $exception, ExceptionService $exceptionService): JsonResponse
    {
        abort_unless($request->user()->hasRole(['admin', 'operator']), 403, 'Forbidden.');

        $validated = $request->validate([
            'status' => 'required|in:OPEN,INVESTIGATING,RESOLVED',
        ]);

        $updated = $exceptionService->updateStatus($exception, $validated['status'], $request->user());

        return response()->json([
            'message' => 'Exception status updated.',
            'data' => $updated,
        ], 200);
    }
}