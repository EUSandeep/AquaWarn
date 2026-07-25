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
        $node = TelemetryNode::create([
            'name' => 'Node-1',
            'location_name' => 'Kelani River Basin - Node-1',
            'latitude' => 6.9271,
            'longitude' => 79.8612,
            'water_level_threshold' => 3.5,
            'rainfall_threshold' => 50.0,
        ]);

        $service = new MockForecastingService();

        $start = microtime(true);
        $service->generate72HourForecast($node);
        $duration = microtime(true) - $start;

        $this->assertEquals(72, Forecast::where('telemetry_node_id', $node->id)->count());
        $this->assertLessThan(0.1, $duration, "Forecast generation took too long: {$duration}s");
    }
}
