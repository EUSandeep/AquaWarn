<?php

namespace Tests\Feature;

use App\Models\TelemetryNode;
use App\Models\TelemetryData;
use App\Models\Forecast;
use App\Services\MockForecastingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class PerformanceBenchmarkTest extends TestCase
{
    use RefreshDatabase;

    public function test_forecast_generation_performance()
    {
        $node = TelemetryNode::create([
            'name' => 'Test Node',
            'location_name' => 'Test Location',
            'latitude' => 6.9271,
            'longitude' => 79.8612,
            'status' => 'active',
            'water_level_threshold' => 5.0,
            'rainfall_threshold' => 100.0,
        ]);

        TelemetryData::create([
            'telemetry_node_id' => $node->id,
            'water_level' => 2.5,
            'rainfall' => 10.0,
            'recorded_at' => now(),
        ]);

        $service = new MockForecastingService();

        $start = microtime(true);
        $service->generate72HourForecast($node);
        $end = microtime(true);

        $executionTime = ($end - $start) * 1000; // in milliseconds

        echo "\nForecast Generation Time: " . round($executionTime, 2) . "ms\n";

        $this->assertEquals(72, Forecast::where('telemetry_node_id', $node->id)->count());
    }
}
