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

    public function test_forecast_generation_correctness_and_performance(): void
    {
        // 1. Arrange: Create a TelemetryNode
        $node = TelemetryNode::create([
            'name' => 'Kelani Ganga Colombo Node',
            'location_name' => 'Colombo',
            'latitude' => 6.9271,
            'longitude' => 79.8612,
            'water_level_threshold' => 3.5,
            'rainfall_threshold' => 50.0,
        ]);

        $service = new MockForecastingService();

        // 2. Act: Measure execution time of generate72HourForecast
        $startTime = microtime(true);
        $service->generate72HourForecast($node);
        $endTime = microtime(true);

        $executionTimeMs = ($endTime - $startTime) * 1000;

        // 3. Assert: Verify exactly 72 forecasts were created
        $forecastCount = Forecast::where('telemetry_node_id', $node->id)->count();
        $this->assertEquals(72, $forecastCount);

        // Verify the forecasted entries have expected data
        $firstForecast = Forecast::where('telemetry_node_id', $node->id)
            ->orderBy('forecasted_for', 'asc')
            ->first();

        $this->assertNotNull($firstForecast);
        $this->assertGreaterThanOrEqual(0, $firstForecast->predicted_water_level);
        $this->assertNotNull($firstForecast->created_at);
        $this->assertNotNull($firstForecast->updated_at);

        // Assert performance (should be extremely fast, typically < 10ms with SQLite)
        $this->assertLessThan(100, $executionTimeMs, "Bulk insertion was too slow: {$executionTimeMs}ms");
    }
}
