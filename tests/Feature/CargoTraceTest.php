<?php

namespace Tests\Feature;

use App\Models\Carrier;
use App\Models\Location;
use App\Models\Shipment;
use App\Models\User;
use App\Services\EtaService;
use App\Services\ShipmentService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CargoTraceTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_access_protected_routes(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
        $this->getJson('/api/shipments')->assertStatus(401);
    }

    public function test_api_login_returns_token_for_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'operator@cargotrace.test',
            'password' => bcrypt('password123'),
            'role' => 'operator',
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'operator@cargotrace.test',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['message', 'user', 'token']);
    }

    public function test_customer_cannot_view_another_customers_shipment(): void
    {
        $customerA = User::factory()->create(['role' => 'customer']);
        $customerB = User::factory()->create(['role' => 'customer']);
        $carrier = Carrier::create(['name' => 'Maersk Line', 'code' => 'MSK']);
        $origin = Location::create(['name' => 'Port of Singapore', 'code' => 'SGSIN', 'country' => 'Singapore', 'city' => 'Singapore']);
        $dest = Location::create(['name' => 'Port of Rotterdam', 'code' => 'NLRTM', 'country' => 'Netherlands', 'city' => 'Rotterdam']);

        $shipmentB = Shipment::create([
            'shipment_number' => 'SHP-9999',
            'customer_id' => $customerB->id,
            'carrier_id' => $carrier->id,
            'origin_location_id' => $origin->id,
            'destination_location_id' => $dest->id,
            'cargo_type' => 'Electronics',
            'current_status' => 'IN_TRANSIT',
        ]);

        // Customer A mencoba mengakses shipment milik Customer B via Web dan API
        $this->actingAs($customerA)
            ->get("/shipments/{$shipmentB->id}")
            ->assertStatus(403);

        $this->actingAs($customerA, 'sanctum')
            ->getJson("/api/shipments/{$shipmentB->id}")
            ->assertStatus(403);
    }

    public function test_invalid_shipment_status_transition_is_rejected(): void
    {
        $operator = User::factory()->create(['role' => 'operator']);
        $customer = User::factory()->create(['role' => 'customer']);
        $carrier = Carrier::create(['name' => 'MSC', 'code' => 'MSC']);
        $origin = Location::create(['name' => 'Jakarta', 'code' => 'IDJKT', 'country' => 'Indonesia', 'city' => 'Jakarta']);
        $dest = Location::create(['name' => 'Tokyo', 'code' => 'JPTYO', 'country' => 'Japan', 'city' => 'Tokyo']);

        $shipment = Shipment::create([
            'shipment_number' => 'SHP-1001',
            'customer_id' => $customer->id,
            'carrier_id' => $carrier->id,
            'origin_location_id' => $origin->id,
            'destination_location_id' => $dest->id,
            'cargo_type' => 'Textiles',
            'current_status' => 'CREATED',
        ]);

        $service = app(ShipmentService::class);

        // Melompat langsung dari CREATED ke DELIVERED harus ditolak
        $this->expectException(ValidationException::class);
        $service->transitionStatus($shipment, 'DELIVERED', $operator);
    }

    public function test_eta_service_marks_shipment_delayed_and_sets_severity(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $carrier = Carrier::create(['name' => 'CMA CGM', 'code' => 'CMA']);
        $origin = Location::create(['name' => 'Belawan', 'code' => 'IDBLW', 'country' => 'Indonesia', 'city' => 'Medan']);
        $dest = Location::create(['name' => 'Hamburg', 'code' => 'DEHAM', 'country' => 'Germany', 'city' => 'Hamburg']);

        $expected = Carbon::parse('2026-12-01 10:00:00');
        $estimated = Carbon::parse('2026-12-02 16:00:00'); // Terlambat 30 jam (> 24 jam = HIGH)

        $shipment = Shipment::create([
            'shipment_number' => 'SHP-2002',
            'customer_id' => $customer->id,
            'carrier_id' => $carrier->id,
            'origin_location_id' => $origin->id,
            'destination_location_id' => $dest->id,
            'cargo_type' => 'Coffee Beans',
            'expected_arrival' => $expected,
            'current_status' => 'IN_TRANSIT',
        ]);

        $etaService = app(EtaService::class);
        $updated = $etaService->evaluateDelay($shipment, $estimated, 'Port congestion at transshipment hub');

        $this->assertTrue($updated->is_delayed);
        $this->assertEquals(30, $updated->delay_hours);
        $this->assertEquals('HIGH', $updated->delay_severity);
    }
}