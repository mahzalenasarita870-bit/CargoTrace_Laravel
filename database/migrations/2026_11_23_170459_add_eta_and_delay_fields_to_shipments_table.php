<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dateTime('estimated_arrival')->nullable()->after('expected_arrival');
            $table->dateTime('actual_arrival')->nullable()->after('estimated_arrival');
            $table->boolean('is_delayed')->default(false)->after('current_status');
            $table->integer('delay_hours')->default(0)->after('is_delayed');
            $table->string('delay_severity')->nullable()->after('delay_hours'); // LOW, MEDIUM, HIGH
            $table->text('delay_reason')->nullable()->after('delay_severity');
        });
    }

    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropColumn([
                'estimated_arrival',
                'actual_arrival',
                'is_delayed',
                'delay_hours',
                'delay_severity',
                'delay_reason',
            ]);
        });
    }
};