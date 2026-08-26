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
        Schema::table('telemetry_data', function (Blueprint $table) {
            $table->index('recorded_at');
            $table->index(['telemetry_node_id', 'recorded_at']);
        });

        Schema::table('alerts', function (Blueprint $table) {
            $table->index('triggered_at');
            $table->index(['telemetry_node_id', 'triggered_at']);
        });

        Schema::table('forecasts', function (Blueprint $table) {
            $table->index(['telemetry_node_id', 'forecasted_for']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('telemetry_data', function (Blueprint $table) {
            $table->dropIndex(['recorded_at']);
            $table->dropIndex(['telemetry_node_id', 'recorded_at']);
        });

        Schema::table('alerts', function (Blueprint $table) {
            $table->dropIndex(['triggered_at']);
            $table->dropIndex(['telemetry_node_id', 'triggered_at']);
        });

        Schema::table('forecasts', function (Blueprint $table) {
            $table->dropIndex(['telemetry_node_id', 'forecasted_for']);
        });
    }
};
