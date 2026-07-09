<?php

namespace Tests\Feature;

use App\Models\TelemetryNode;
use App\Services\MockForecastingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PerformanceBenchmarkTest extends TestCase
{
    use RefreshDatabase;

    public function test_forecast_generation_performance(): void
    {
        $node = TelemetryNode::create([
            'name' => 'NODE-001',
            'location_name' => 'Test Location',
            'latitude' => 6.9271,
            'longitude' => 79.8612,
        ]);

        $service = new MockForecastingService();

        $iterations = 100;
        $start = microtime(true);

        for ($i = 0; $i < $iterations; $i++) {
            $service->generate72HourForecast($node);
        }

        $end = microtime(true);
        $totalTime = ($end - $start) * 1000; // in ms
        $avgTime = $totalTime / $iterations;

        echo "\nAverage time for generate72HourForecast (over $iterations iterations): " . round($avgTime, 2) . "ms\n";

        $this->assertTrue(true);
    }
}
