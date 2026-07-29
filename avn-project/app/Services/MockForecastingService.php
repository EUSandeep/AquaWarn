<?php

namespace App\Services;

use App\Models\TelemetryNode;
use App\Models\Forecast;
use Carbon\Carbon;

class MockForecastingService
{
    public function generate72HourForecast(TelemetryNode $node)
    {
        $latestTelemetry = $node->telemetryData()->latest('recorded_at')->first();
        $baseLevel = $latestTelemetry ? $latestTelemetry->water_level : 1.5;

        // Clear old forecasts for this node
        $node->forecasts()->delete();

        $forecasts = [];
        $now = Carbon::now();

        for ($i = 1; $i <= 72; $i++) {
            // Mock LSTM: slight upward trend with some randomness
            $prediction = $baseLevel + ($i * 0.02) + (rand(-10, 10) / 100);
            $forecastedFor = (clone $now)->addHours($i);

            $forecasts[] = [
                'telemetry_node_id' => $node->id,
                'predicted_water_level' => max(0, $prediction),
                'forecasted_for' => $forecastedFor->toDateTimeString(),
                'created_at' => $now->toDateTimeString(),
                'updated_at' => $now->toDateTimeString(),
            ];
        }

        // Batch insert forecasts to reduce database roundtrips from 72 queries to 1
        Forecast::insert($forecasts);
    }
}
