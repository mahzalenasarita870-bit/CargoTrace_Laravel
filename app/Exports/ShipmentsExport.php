<?php

namespace App\Exports;

use App\Models\Shipment;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ShipmentsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $shipments;

    public function __construct(Collection $shipments)
    {
        $this->shipments = $shipments;
    }

    public function collection()
    {
        return $this->shipments;
    }

    public function headings(): array
    {
        return [
            'No',
            'Shipment Number',
            'Cargo Type',
            'Weight (kg)',
            'Status',
            'Expected Arrival',
            'Tanggal Dibuat',
        ];
    }

    public function map($shipment): array
    {
        return [
            $shipment->id,
            $shipment->shipment_number,
            $shipment->cargo_type,
            $shipment->weight,
            $shipment->current_status,
            $shipment->expected_arrival,
            $shipment->created_at?->format('d-m-Y'),
        ];
    }
}
