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

    public function test_forecast_generation_and_performance()
    {
        // 1. Create a Telemetry Node
        $node = TelemetryNode::create([
            'name' => 'Kelani River - Colombo Node',
            'location_name' => 'Colombo',
            'latitude' => 6.9271,
            'longitude' => 79.8612,
            'status' => 'active',
            'water_level_threshold' => 4.0,
            'rainfall_threshold' => 100.0,
        ]);

        // 2. Measure execution time of generate72HourForecast
        $service = new MockForecastingService();

        $start = microtime(true);
        $service->generate72HourForecast($node);
        $duration = microtime(true) - $start;

        // 3. Verify correct number of forecasts were created
        $this->assertEquals(72, $node->forecasts()->count());

        // 4. Verify properties of forecasts
        $firstForecast = $node->forecasts()->orderBy('forecasted_for', 'asc')->first();
        $this->assertNotNull($firstForecast);
        $this->assertNotNull($firstForecast->created_at);
        $this->assertNotNull($firstForecast->updated_at);

        // Echo the duration to output
        echo "\n[BENCHMARK] Forecast generation completed in: " . number_format($duration * 1000, 2) . " ms\n";
    }
}
