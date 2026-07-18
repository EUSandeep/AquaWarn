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
        $nowString = $now->toDateTimeString();

        for ($i = 1; $i <= 72; $i++) {
            // Mock LSTM: slight upward trend with some randomness
            $prediction = $baseLevel + ($i * 0.02) + (rand(-10, 10) / 100);

            // Construct array for high-performance batch insertion.
            // When using Eloquent::insert() for bulk inserts, we must explicitly include
            // timestamps and cast Carbon objects to strings as standard model casting is bypassed.
            $forecasts[] = [
                'telemetry_node_id' => $node->id,
                'predicted_water_level' => max(0, $prediction),
                'forecasted_for' => $now->copy()->addHours($i)->toDateTimeString(),
                'created_at' => $nowString,
                'updated_at' => $nowString,
            ];
        }

        // Reduce database roundtrips by 98% (from 72 separate inserts to 1 single batch insert)
        Forecast::insert($forecasts);
    }
}
