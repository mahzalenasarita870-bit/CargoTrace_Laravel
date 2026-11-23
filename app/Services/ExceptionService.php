<?php

namespace App\Services;

use App\Models\AppNotification;
use App\Models\AuditLog;
use App\Models\Shipment;
use App\Models\ShipmentException;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ExceptionService
{
    public function reportException(Shipment $shipment, array $data, User $actor): ShipmentException
    {
        $allowedTypes = config('cargotrace.exception_types', []);
        if (!in_array($data['exception_type'], $allowedTypes, true)) {
            throw ValidationException::withMessages([
                'exception_type' => 'Invalid exception type provided.',
            ]);
        }

        return DB::transaction(function () use ($shipment, $data, $actor) {
            $exception = ShipmentException::create([
                'shipment_id' => $shipment->id,
                'exception_type' => $data['exception_type'],
                'severity' => $data['severity'] ?? 'MEDIUM',
                'status' => 'OPEN',
                'description' => $data['description'],
                'detected_at' => $data['detected_at'] ?? now(),
            ]);

            AuditLog::create([
                'user_id' => $actor->id,
                'action' => 'EXCEPTION_REPORTED',
                'auditable_type' => ShipmentException::class,
                'auditable_id' => $exception->id,
                'new_values' => $exception->toArray(),
                'ip_address' => request()?->ip(),
            ]);

            AppNotification::create([
                'user_id' => $shipment->customer_id,
                'shipment_id' => $shipment->id,
                'type' => 'EXCEPTION_OPENED',
                'title' => "Alert on Shipment {$shipment->shipment_number}",
                'message' => "Exception reported ({$exception->exception_type} - {$exception->severity}): {$exception->description}",
            ]);

            return $exception;
        });
    }

    public function updateStatus(ShipmentException $exception, string $newStatus, User $actor): ShipmentException
    {
        $allowedStatuses = ['OPEN', 'INVESTIGATING', 'RESOLVED'];
        if (!in_array($newStatus, $allowedStatuses, true)) {
            throw ValidationException::withMessages([
                'status' => 'Invalid exception status.',
            ]);
        }

        return DB::transaction(function () use ($exception, $newStatus, $actor) {
            $oldValues = ['status' => $exception->status];

            $exception->status = $newStatus;
            if ($newStatus === 'RESOLVED') {
                $exception->resolved_at = now();
                $exception->resolved_by = $actor->id;
            }
            $exception->save();

            AuditLog::create([
                'user_id' => $actor->id,
                'action' => 'EXCEPTION_UPDATED',
                'auditable_type' => ShipmentException::class,
                'auditable_id' => $exception->id,
                'old_values' => $oldValues,
                'new_values' => ['status' => $newStatus, 'resolved_at' => $exception->resolved_at],
                'ip_address' => request()?->ip(),
            ]);

            return $exception;
        });
    }
}