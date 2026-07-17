<?php

namespace Tests\Feature;

use App\Models\TelemetryNode;
use App\Models\Forecast;
use App\Services\MockForecastingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class PerformanceBenchmarkTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the forecasting service correctly generates 72 forecasts using optimized bulk insert.
     */
    public function test_forecast_generation_is_correct_and_complete(): void
    {
        // 1. Arrange: Create a Telemetry Node
        $node = TelemetryNode::create([
            'name' => 'NODE-TEST',
            'location_name' => 'Kelani Basin Test Node',
            'latitude' => 6.9271,
            'longitude' => 79.8612,
            'status' => 'active',
            'water_level_threshold' => 5.0,
            'rainfall_threshold' => 100.0,
        ]);

        $service = new MockForecastingService();

        // 2. Act: Generate forecast
        $service->generate72HourForecast($node);

        // 3. Assert: Verify exactly 72 forecasts exist for the node
        $this->assertEquals(72, $node->forecasts()->count());

        // Verify some properties of the generated forecasts
        $firstForecast = $node->forecasts()->orderBy('forecasted_for', 'asc')->first();
        $lastForecast = $node->forecasts()->orderBy('forecasted_for', 'desc')->first();

        $this->assertNotNull($firstForecast);
        $this->assertNotNull($lastForecast);

        $this->assertGreaterThan(0, $firstForecast->predicted_water_level);
        $this->assertGreaterThan(0, $lastForecast->predicted_water_level);

        // Verify forecasted_for times are in the future
        $now = Carbon::now();
        $this->assertTrue(Carbon::parse($firstForecast->forecasted_for)->isAfter($now));
        $this->assertTrue(Carbon::parse($lastForecast->forecasted_for)->isAfter($now));

        // Verify timestamps are correctly populated
        $this->assertNotNull($firstForecast->created_at);
        $this->assertNotNull($firstForecast->updated_at);
    }

    /**
     * Benchmark forecast generation performance.
     */
    public function test_forecast_generation_performance(): void
    {
        $node = TelemetryNode::create([
            'name' => 'NODE-BENCHMARK',
            'location_name' => 'Kelani Basin Benchmark Node',
            'latitude' => 6.9271,
            'longitude' => 79.8612,
            'status' => 'active',
            'water_level_threshold' => 5.0,
            'rainfall_threshold' => 100.0,
        ]);

        $service = new MockForecastingService();

        // Run forecast generation multiple times to measure average time
        $iterations = 50;
        $start = microtime(true);

        for ($i = 0; $i < $iterations; $i++) {
            $service->generate72HourForecast($node);
        }

        $end = microtime(true);
        $totalTime = $end - $start;
        $averageTime = ($totalTime / $iterations) * 1000; // in milliseconds

        echo "\n[BENCHMARK] Average forecast generation (72 hours bulk insert) time: " . round($averageTime, 2) . "ms over $iterations iterations\n";

        // Assert performance is reasonable (typically well under 10ms for SQLite in-memory)
        $this->assertLessThan(50, $averageTime, "Forecast generation should be fast (< 50ms average)");
    }
}
