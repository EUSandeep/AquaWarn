<?php

namespace Tests\Feature;

use App\Models\TelemetryNode;
use App\Models\Forecast;
use App\Services\MockForecastingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PerformanceBenchmarkTest extends TestCase
{
    use RefreshDatabase;

    public function test_forecast_generation_correctness_and_performance()
    {
        // 1. Arrange: Create a telemetry node
        $node = TelemetryNode::create([
            'name' => 'Kaduwela_Node_Benchmark',
            'location_name' => 'Kelani River Basin - Kaduwela',
            'latitude' => 6.9271,
            'longitude' => 79.8612,
            'water_level_threshold' => 5.0,
            'rainfall_threshold' => 100.0,
        ]);

        // 2. Act: Benchmark mock forecast generation
        $service = new MockForecastingService();

        $startTime = microtime(true);
        $service->generate72HourForecast($node);
        $endTime = microtime(true);

        $executionTimeMs = ($endTime - $startTime) * 1000;

        // 3. Assert: Verify 72 forecasts were inserted successfully
        $forecastsCount = Forecast::where('telemetry_node_id', $node->id)->count();
        $this->assertEquals(72, $forecastsCount, "Exactly 72 hourly forecasts should be generated.");

        // Print benchmark info
        echo "\n[BENCHMARK] Generate 72-Hour Forecast execution time: " . number_format($executionTimeMs, 2) . " ms\n";
    }
}
