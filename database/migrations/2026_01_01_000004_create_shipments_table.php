<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();

            $table->string('shipment_number')->unique();

            $table->foreignId('customer_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('carrier_id')
                ->constrained('carriers')
                ->cascadeOnDelete();

            $table->foreignId('origin_location_id')
                ->constrained('locations');

            $table->foreignId('destination_location_id')
                ->constrained('locations');

            $table->string('cargo_type');
            $table->decimal('weight', 10, 2)->nullable();
            $table->decimal('volume', 10, 2)->nullable();

            $table->dateTime('expected_departure')->nullable();
            $table->dateTime('expected_arrival')->nullable();

            $table->string('current_status')->default('CREATED');

            $table->timestamps();

            $table->index('current_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};