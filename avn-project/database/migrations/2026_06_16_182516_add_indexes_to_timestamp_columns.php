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
        });

        Schema::table('forecasts', function (Blueprint $table) {
            $table->index('forecasted_for');
        });

        Schema::table('alerts', function (Blueprint $table) {
            $table->index('triggered_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('telemetry_data', function (Blueprint $table) {
            $table->dropIndex(['recorded_at']);
        });

        Schema::table('forecasts', function (Blueprint $table) {
            $table->dropIndex(['forecasted_for']);
        });

        Schema::table('alerts', function (Blueprint $table) {
            $table->dropIndex(['triggered_at']);
        });
    }
};
