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
        Schema::create('telemetry_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('telemetry_node_id')->constrained()->onDelete('cascade');
            $table->decimal('water_level', 8, 2);
            $table->decimal('rainfall', 8, 2);
            $table->decimal('battery_voltage', 5, 2)->nullable();
            $table->timestamp('recorded_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telemetry_data');
    }
};
