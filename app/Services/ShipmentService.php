<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ShipmentService
{
    public function __construct(
        protected EtaService $etaService
    ) {}

    public function createShipment(array $data, User $actor): Shipment
    {
        return DB::transaction(function () use ($data, $actor) {
            $data['current_status'] = 'CREATED';
            $data['estimated_arrival'] = $data['estimated_arrival'] ?? $data['expected_arrival'] ?? null;

            $shipment = Shipment::create($data);
            $this->etaService->evaluateDelay($shipment);

            $this->logAudit($actor, 'CREATED', $shipment, null, $shipment->toArray());

            return $shipment;
        });
    }

    public function transitionStatus(Shipment $shipment, string $newStatus, User $actor): Shipment
    {
        $currentStatus = $shipment->current_status;
        $allowedTransitions = config("cargotrace.status_transitions.{$currentStatus}", []);

        if (!in_array($newStatus, $allowedTransitions, true)) {
            throw ValidationException::withMessages([
                'status' => "Invalid status transition from {$currentStatus} to {$newStatus}.",
            ]);
        }

        return DB::transaction(function () use ($shipment, $currentStatus, $newStatus, $actor) {
            $oldValues = ['current_status' => $currentStatus];

            $shipment->current_status = $newStatus;

            if ($newStatus === 'DELIVERED') {
                $shipment->actual_arrival = now();
            }

            $shipment->save();

            $this->logAudit($actor, 'STATUS_CHANGED', $shipment, $oldValues, [
                'current_status' => $newStatus,
            ]);

            return $shipment;
        });
    }

    private function logAudit(User $actor, string $action, Shipment $shipment, ?array $oldValues, ?array $newValues): void
    {
        AuditLog::create([
            'user_id' => $actor->id,
            'action' => $action,
            'auditable_type' => Shipment::class,
            'auditable_id' => $shipment->id,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()?->ip(),
        ]);
    }
}