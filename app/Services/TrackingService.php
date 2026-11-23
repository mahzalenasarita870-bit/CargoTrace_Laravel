<?php

namespace App\Services;

use App\Models\AppNotification;
use App\Models\Location;
use App\Models\Shipment;
use App\Models\TrackingEvent;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TrackingService
{
    public function __construct(
        protected ShipmentService $shipmentService,
        protected EtaService $etaService
    ) {}

    public function recordEvent(Shipment $shipment, array $data, User $actor): TrackingEvent
    {
        // 1. Validasi status terminal tidak bisa ditambah event sembarangan
        if (in_array($shipment->current_status, ['DELIVERED', 'CANCELLED'], true)) {
            throw ValidationException::withMessages([
                'shipment' => "Cannot add tracking events to a shipment with terminal status {$shipment->current_status}.",
            ]);
        }

        // 2. Validasi urutan waktu (tidak boleh lebih lama dari event terakhir)
        $eventTime = Carbon::parse($data['event_time']);
        $latestEvent = $shipment->trackingEvents()->latest('event_time')->first();

        if ($latestEvent && $eventTime->lt(Carbon::parse($latestEvent->event_time))) {
            throw ValidationException::withMessages([
                'event_time' => "Event time cannot be earlier than the previous tracking event ({$latestEvent->event_time}).",
            ]);
        }

        return DB::transaction(function () use ($shipment, $data, $eventTime, $actor) {
            // Ambil koordinat dari Location jika latitude/longitude kosong
            if (!empty($data['location_id']) && (empty($data['latitude']) || empty($data['longitude']))) {
                $location = Location::find($data['location_id']);
                if ($location) {
                    $data['latitude'] = $location->latitude ?? null;
                    $data['longitude'] = $location->longitude ?? null;
                }
            }

            // Simpan tracking event baru (historis)
            $event = TrackingEvent::create([
                'shipment_id' => $shipment->id,
                'event_type' => $data['event_type'],
                'event_time' => $eventTime,
                'location_id' => $data['location_id'] ?? null,
                'latitude' => $data['latitude'] ?? null,
                'longitude' => $data['longitude'] ?? null,
                'description' => $data['description'] ?? null,
                'created_by' => $actor->id,
            ]);

            // Jika event_type adalah status lifecycle baru yang berbeda dari current_status, validasi & perbarui
            $lifecycleStatuses = array_keys(config('cargotrace.status_transitions', []));
            if (in_array($data['event_type'], $lifecycleStatuses, true) && $data['event_type'] !== $shipment->current_status) {
                $this->shipmentService->transitionStatus($shipment, $data['event_type'], $actor);
            }

            // Perbarui ETA jika operator menyertakan estimated_arrival baru
            if (!empty($data['estimated_arrival'])) {
                $this->etaService->evaluateDelay(
                    $shipment,
                    Carbon::parse($data['estimated_arrival']),
                    $data['description'] ?? null
                );
            }

            // Buat notifikasi in-app untuk Customer pemilik shipment
            AppNotification::create([
                'user_id' => $shipment->customer_id,
                'shipment_id' => $shipment->id,
                'type' => 'STATUS_UPDATE',
                'title' => "Shipment {$shipment->shipment_number} Updated",
                'message' => "New tracking event: {$event->event_type}. " . ($event->description ?? ''),
            ]);

            return $event;
        });
    }
}