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
        $node = TelemetryNode::create([
            'name' => 'NODE_TEST',
            'location_name' => 'Kelani Basin - Test Node',
            'latitude' => 6.9271,
            'longitude' => 79.8612,
            'water_level_threshold' => 3.5,
            'rainfall_threshold' => 50.0,
        ]);

        $service = new MockForecastingService();

        $start = microtime(true);
        $service->generate72HourForecast($node);
        $duration = microtime(true) - $start;

        // Verify that 72 forecasts were created
        $this->assertEquals(72, Forecast::where('telemetry_node_id', $node->id)->count());

        // Verify timestamps exist and are populated
        $firstForecast = Forecast::where('telemetry_node_id', $node->id)->first();
        $this->assertNotNull($firstForecast->created_at);
        $this->assertNotNull($firstForecast->updated_at);
        $this->assertNotNull($firstForecast->forecasted_for);

        // Print benchmark info
        echo "\n[BENCHMARK] 72-hour forecast batch insert completed in: " . round($duration * 1000, 2) . "ms\n";
    }
}
