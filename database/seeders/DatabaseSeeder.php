<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Carrier;
use App\Models\Location;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // DATA USERS
        $users = [
            [
                'name' => 'CargoTrace Admin',
                'email' => 'admin@cargotrace.test',
                'role' => 'ADMIN',
            ],
            [
                'name' => 'Logistics Operator',
                'email' => 'operator@cargotrace.test',
                'role' => 'OPERATOR',
            ],
            [
                'name' => 'Demo Customer',
                'email' => 'customer@cargotrace.test',
                'role' => 'CUSTOMER',
            ],
        ];

        foreach ($users as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                ]
            );

            $user->role = $data['role'];
            $user->save();
        }

        // DATA CARRIERS
        $carriers = [
            [
                'name' => 'Cargo Express',
                'code' => 'CEX',
                'phone' => '081234567890',
                'email' => 'cargoexpress@test.com',
            ],
            [
                'name' => 'Global Logistics',
                'code' => 'GLB',
                'phone' => '081234567891',
                'email' => 'globallogistics@test.com',
            ],
            [
                'name' => 'Nusantara Freight',
                'code' => 'NSF',
                'phone' => '081234567892',
                'email' => 'nusantarafreight@test.com',
            ],
        ];

        foreach ($carriers as $carrier) {
            Carrier::firstOrCreate(
                ['code' => $carrier['code']],
                $carrier
            );
        }

        // DATA LOCATIONS
        $locations = [
            [
                'name' => 'Jakarta Warehouse',
                'city' => 'Jakarta',
                'country' => 'Indonesia',
                'latitude' => -6.2088,
                'longitude' => 106.8456,
            ],
            [
                'name' => 'Surabaya Warehouse',
                'city' => 'Surabaya',
                'country' => 'Indonesia',
                'latitude' => -7.2575,
                'longitude' => 112.7521,
            ],
            [
                'name' => 'Medan Warehouse',
                'city' => 'Medan',
                'country' => 'Indonesia',
                'latitude' => 3.5952,
                'longitude' => 98.6722,
            ],
            [
                'name' => 'Aceh Warehouse',
                'city' => 'Banda Aceh',
                'country' => 'Indonesia',
                'latitude' => 5.5483,
                'longitude' => 95.3238,
            ],
        ];

        foreach ($locations as $location) {
            Location::firstOrCreate(
                [
                    'name' => $location['name'],
                    'city' => $location['city'],
                ],
                $location
            );
        }
    }
}
