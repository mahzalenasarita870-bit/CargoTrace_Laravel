<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('trackings', function (Blueprint $table) {
        $table->id();

        $table->foreignId('shipment_id')
            ->constrained('shipments')
            ->onDelete('cascade');

        $table->foreignId('location_id')
            ->constrained('locations')
            ->onDelete('cascade');

        $table->string('status');
        $table->text('description')->nullable();
        $table->dateTime('tracking_date');

        $table->timestamps();
    });
}
};
