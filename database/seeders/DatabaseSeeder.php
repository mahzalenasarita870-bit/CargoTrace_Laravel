<?php

namespace Database\Seeders;

use App\Models\Carrier;
use App\Models\Location;
use App\Models\Shipment;
use App\Models\ShipmentException;
use App\Models\TrackingEvent;
use App\Models\User;
use App\Services\EtaService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Demo sesuai Role (Admin, Operator, Customer)
        $admin = User::updateOrCreate(
            ['email' => 'admin@cargotrace.test'],
            [
                'name' => 'CargoTrace Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $operator = User::updateOrCreate(
            ['email' => 'operator@cargotrace.test'],
            [
                'name' => 'Logistics Operator',
                'password' => Hash::make('password'),
                'role' => 'operator',
            ]
        );

        $customer1 = User::updateOrCreate(
            ['email' => 'customer@cargotrace.test'],
            [
                'name' => 'PT Nusantara Ekspor',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]
        );

        $customer2 = User::updateOrCreate(
            ['email' => 'customer2@cargotrace.test'],
            [
                'name' => 'Global Trade Corp',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]
        );

        // 2. Data Carriers (gunakan 'name' sebagai kunci pencarian)
        $maerskData = [];
        if (Schema::hasColumn('carriers', 'code')) {
            $maerskData['code'] = 'MSK';
        }
        if (Schema::hasColumn('carriers', 'mode')) {
            $maerskData['mode'] = 'SEA';
        }
        if (Schema::hasColumn('carriers', 'contact_email')) {
            $maerskData['contact_email'] = 'ops@maersk-demo.test';
        }
        $maersk = Carrier::updateOrCreate(['name' => 'Maersk Line'], $maerskData);

        $cmaData = [];
        if (Schema::hasColumn('carriers', 'code')) {
            $cmaData['code'] = 'CMA';
        }
        if (Schema::hasColumn('carriers', 'mode')) {
            $cmaData['mode'] = 'SEA';
        }
        if (Schema::hasColumn('carriers', 'contact_email')) {
            $cmaData['contact_email'] = 'support@cmacgm-demo.test';
        }
        $cma = Carrier::updateOrCreate(['name' => 'CMA CGM'], $cmaData);

        // 3. Data Locations (gunakan 'name' sebagai kunci pencarian & filter kolom dinamis)
        $locationsSeed = [
            'jakarta' => [
                'name' => 'Port of Tanjung Priok, Jakarta',
                'code' => 'IDJKT',
                'country' => 'Indonesia',
                'city' => 'Jakarta',
                'latitude' => -6.1025,
                'longitude' => 106.8833,
            ],
            'singapore' => [
                'name' => 'Port of Singapore (PSA)',
                'code' => 'SGSIN',
                'country' => 'Singapore',
                'city' => 'Singapore',
                'latitude' => 1.2644,
                'longitude' => 103.8222,
            ],
            'rotterdam' => [
                'name' => 'Port of Rotterdam',
                'code' => 'NLRTM',
                'country' => 'Netherlands',
                'city' => 'Rotterdam',
                'latitude' => 51.9496,
                'longitude' => 4.1453,
            ],
            'tokyo' => [
                'name' => 'Port of Tokyo',
                'code' => 'JPTYO',
                'country' => 'Japan',
                'city' => 'Tokyo',
                'latitude' => 35.6192,
                'longitude' => 139.7798,
            ],
        ];

        $savedLocations = [];
        foreach ($locationsSeed as $key => $loc) {
            $filtered = [];
            foreach (['code', 'country', 'city', 'latitude', 'longitude'] as $col) {
                if (Schema::hasColumn('locations', $col)) {
                    $filtered[$col] = $loc[$col];
                }
            }
            $savedLocations[$key] = Location::updateOrCreate(['name' => $loc['name']], $filtered);
        }

        $jakarta   = $savedLocations['jakarta'];
        $singapore = $savedLocations['singapore'];
        $rotterdam = $savedLocations['rotterdam'];
        $tokyo     = $savedLocations['tokyo'];

        $etaService = app(EtaService::class);

        // 4. Shipment 1: IN_TRANSIT & DELAYED
        $shipment1 = Shipment::updateOrCreate(
            ['shipment_number' => 'SHP-2026-0001'],
            [
                'customer_id' => $customer1->id,
                'carrier_id' => $maersk->id,
                'origin_location_id' => $jakarta->id,
                'destination_location_id' => $rotterdam->id,
                'cargo_type' => 'Containerized Coffee Beans (40ft HC)',
                'weight' => 18500.00,
                'volume' => 67.50,
                'expected_departure' => Carbon::now()->subDays(10),
                'expected_arrival' => Carbon::now()->addDays(2),
                'estimated_arrival' => Carbon::now()->addDays(3)->addHours(6),
                'current_status' => 'IN_TRANSIT',
            ]
        );
        $etaService->evaluateDelay($shipment1, null, 'Port congestion at Singapore transshipment terminal.');

        TrackingEvent::firstOrCreate(
            ['shipment_id' => $shipment1->id, 'event_type' => 'CREATED'],
            [
                'event_time' => Carbon::now()->subDays(12),
                'location_id' => $jakarta->id,
                'latitude' => -6.1025,
                'longitude' => 106.8833,
                'description' => 'Shipment order registered in CargoTrace.',
                'created_by' => $operator->id,
            ]
        );

        TrackingEvent::firstOrCreate(
            ['shipment_id' => $shipment1->id, 'event_type' => 'IN_TRANSIT'],
            [
                'event_time' => Carbon::now()->subDays(7),
                'location_id' => $singapore->id,
                'latitude' => 1.2644,
                'longitude' => 103.8222,
                'description' => 'Arrived at Singapore transshipment hub; awaiting feeder connection.',
                'created_by' => $operator->id,
            ]
        );

        ShipmentException::firstOrCreate(
            ['shipment_id' => $shipment1->id, 'exception_type' => 'PORT_CONGESTION'],
            [
                'severity' => 'HIGH',
                'status' => 'OPEN',
                'description' => 'Berth congestion at PSA Singapore delayed vessel loading by 30 hours.',
                'detected_at' => Carbon::now()->subDays(6),
            ]
        );

        // 5. Shipment 2: DELIVERED & ON-TIME
        $shipment2 = Shipment::updateOrCreate(
            ['shipment_number' => 'SHP-2026-0002'],
            [
                'customer_id' => $customer2->id,
                'carrier_id' => $cma->id,
                'origin_location_id' => $singapore->id,
                'destination_location_id' => $tokyo->id,
                'cargo_type' => 'Electronic Components',
                'weight' => 4200.00,
                'volume' => 18.00,
                'expected_departure' => Carbon::now()->subDays(8),
                'expected_arrival' => Carbon::now()->subDays(1),
                'estimated_arrival' => Carbon::now()->subDays(1),
                'actual_arrival' => Carbon::now()->subDays(1),
                'current_status' => 'DELIVERED',
                'is_delayed' => false,
                'delay_hours' => 0,
            ]
        );

        TrackingEvent::firstOrCreate(
            ['shipment_id' => $shipment2->id, 'event_type' => 'DELIVERED'],
            [
                'event_time' => Carbon::now()->subDays(1),
                'location_id' => $tokyo->id,
                'latitude' => 35.6192,
                'longitude' => 139.7798,
                'description' => 'Cargo cleared customs and delivered to consignee warehouse.',
                'created_by' => $operator->id,
            ]
        );
    }
}