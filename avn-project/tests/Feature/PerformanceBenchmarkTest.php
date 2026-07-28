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

    public function test_forecast_generation_performance_and_correctness(): void
    {
        $node = TelemetryNode::create([
            'name' => 'Kelani River - Colombo',
            'location_name' => 'Colombo',
            'latitude' => 6.9271,
            'longitude' => 79.8612,
            'status' => 'active',
            'water_level_threshold' => 5.0,
            'rainfall_threshold' => 100.0,
        ]);

        $service = new MockForecastingService();

        $start = microtime(true);
        $service->generate72HourForecast($node);
        $duration = microtime(true) - $start;

        $this->assertEquals(72, $node->forecasts()->count());
        $this->assertLessThan(0.1, $duration, "Forecast generation took too long: {$duration}s");
    }
}
