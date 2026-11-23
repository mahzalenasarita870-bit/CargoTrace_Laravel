<?php

namespace App\Policies;

use App\Models\Shipment;
use App\Models\User;

class ShipmentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'operator', 'customer']);
    }

    public function view(User $user, Shipment $shipment): bool
    {
        if ($user->hasRole(['admin', 'operator'])) {
            return true;
        }

        // Customer hanya boleh melihat shipment miliknya sendiri
        return $user->isCustomer() && $shipment->customer_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'operator']);
    }

    public function update(User $user, Shipment $shipment): bool
    {
        return $user->hasRole(['admin', 'operator']);
    }

    public function delete(User $user, Shipment $shipment): bool
    {
        return $user->isAdmin();
    }
}