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

    public function test_forecast_generation_batch_insert_is_correct_and_fast()
    {
        // 1. Arrange: Create a telemetry node
        $node = TelemetryNode::create([
            'name' => 'Kelani River - Colombo Node',
            'location_name' => 'Colombo',
            'latitude' => 6.9271,
            'longitude' => 79.8612,
            'status' => 'active',
            'water_level_threshold' => 5.0,
            'rainfall_threshold' => 100.0,
        ]);

        $service = new MockForecastingService();

        // 2. Act: Measure execution time of generate72HourForecast
        $startTime = microtime(true);
        $service->generate72HourForecast($node);
        $endTime = microtime(true);
        $elapsedTime = ($endTime - $startTime) * 1000; // in milliseconds

        // 3. Assert: Verify exactly 72 forecast records were created
        $this->assertEquals(72, Forecast::count());
        $this->assertEquals(72, $node->forecasts()->count());

        $forecasts = $node->forecasts()->orderBy('id')->get();

        $this->assertCount(72, $forecasts);

        // Verify some properties of the generated forecasts
        foreach ($forecasts as $index => $forecast) {
            $this->assertEquals($node->id, $forecast->telemetry_node_id);
            $this->assertGreaterThanOrEqual(0, $forecast->predicted_water_level);
            $this->assertNotNull($forecast->forecasted_for);
            $this->assertNotNull($forecast->created_at);
            $this->assertNotNull($forecast->updated_at);
        }

        // Output elapsed time for benchmark comparison
        echo "\n[BENCHMARK] generate72HourForecast completed in " . round($elapsedTime, 2) . " ms.\n";

        // Performance expectation: 72 inserts sequentially usually takes > 100-200ms in SQLite.
        // Batch insertion should take less than 15ms. We can verify it is fast.
        $this->assertLessThan(100.0, $elapsedTime, "Forecast generation batch insertion took too long.");
    }
}
