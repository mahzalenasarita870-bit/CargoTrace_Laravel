<?php

namespace App\Services;

use App\Models\AppNotification;
use App\Models\Shipment;
use App\Models\User;

class NotificationService
{
    public static function notifyShipment(
        Shipment $shipment,
        string $type,
        string $title,
        string $message
    ): void {
        $recipientIds = collect([
            $shipment->customer_id ?? null,
            auth()->id(),
        ])
            ->merge(User::whereIn('role', ['admin', 'operator'])->pluck('id'))
            ->filter()
            ->unique();

        foreach ($recipientIds as $userId) {
            AppNotification::create([
                'user_id' => $userId,
                'shipment_id' => $shipment->id,
                'type' => $type,
                'title' => $title,
                'message' => $message,
                'read_at' => null,
            ]);
        }
    }
}