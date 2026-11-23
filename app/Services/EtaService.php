<?php

namespace App\Services;

use App\Models\Shipment;
use Carbon\Carbon;

class EtaService
{
    public function evaluateDelay(Shipment $shipment, ?Carbon $newEstimatedArrival = null, ?string $reason = null): Shipment
    {
        if ($newEstimatedArrival) {
            $shipment->estimated_arrival = $newEstimatedArrival;
        }

        // Jika belum ada expected_arrival atau estimated_arrival, anggap tidak delayed
        if (!$shipment->expected_arrival || !$shipment->estimated_arrival) {
            $shipment->is_delayed = false;
            $shipment->delay_hours = 0;
            $shipment->delay_severity = null;
            $shipment->save();

            return $shipment;
        }

        $expected = Carbon::parse($shipment->expected_arrival);
        $estimated = Carbon::parse($shipment->estimated_arrival);

        // Hitung selisih dalam jam (positif jika estimated > expected)
        $diffHours = $expected->diffInHours($estimated, false);
        $threshold = (int) config('cargotrace.delay_threshold_hours', 12);

        if ($diffHours > 0) {
            $shipment->delay_hours = (int) ceil($diffHours);
            // Tandai delayed jika melewati threshold kelompok (atau > 0 sesuai aturan)
            $shipment->is_delayed = $shipment->delay_hours >= $threshold || $diffHours > 0;
            $shipment->delay_severity = $this->determineSeverity($shipment->delay_hours);

            if ($reason) {
                $shipment->delay_reason = $reason;
            } elseif (!$shipment->delay_reason) {
                $shipment->delay_reason = "Estimated arrival exceeds expected arrival by {$shipment->delay_hours} hours (Threshold: {$threshold}h).";
            }
        } else {
            $shipment->is_delayed = false;
            $shipment->delay_hours = 0;
            $shipment->delay_severity = null;
            $shipment->delay_reason = null;
        }

        $shipment->save();

        return $shipment;
    }

    private function determineSeverity(int $delayHours): string
    {
        $lowMax = config('cargotrace.delay_severity_rules.low_max', 6);
        $mediumMax = config('cargotrace.delay_severity_rules.medium_max', 24);

        if ($delayHours <= $lowMax) {
            return 'LOW';
        }

        if ($delayHours <= $mediumMax) {
            return 'MEDIUM';
        }

        return 'HIGH';
    }
}