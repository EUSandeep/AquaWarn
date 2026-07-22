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

    protected function tearDown(): void
    {
        Carbon::setTestNow(); // Reset Mocked Time
        parent::tearDown();
    }

    public function test_forecast_generation_correctness_and_performance(): void
    {
        // Pin the current time using Carbon::setTestNow to avoid timing race conditions
        $now = Carbon::parse('2026-07-22 12:00:00');
        Carbon::setTestNow($now);

        // 1. Setup a Telemetry Node
        $node = TelemetryNode::create([
            'name' => 'Kelani River - Hanwella',
            'location_name' => 'Hanwella Bridge',
            'latitude' => 6.9022,
            'longitude' => 80.0814,
            'status' => 'online',
            'water_level_threshold' => 5.0,
            'rainfall_threshold' => 100.0,
        ]);

        // Create some initial telemetry data
        $node->telemetryData()->create([
            'water_level' => 3.25,
            'rainfall' => 20.5,
            'battery_voltage' => 4.15,
            'recorded_at' => $now->copy()->subMinutes(10)->toDateTimeString(),
        ]);

        $service = new MockForecastingService();

        // 2. Measure execution time
        $startTime = microtime(true);
        $service->generate72HourForecast($node);
        $endTime = microtime(true);
        $durationMs = ($endTime - $startTime) * 1000;

        // Output performance metrics
        echo "\n⚡ Bolt Benchmark: 72-hour forecast bulk insert execution time: " . round($durationMs, 2) . " ms\n";

        // 3. Verify correctness
        $forecastCount = Forecast::where('telemetry_node_id', $node->id)->count();
        $this->assertEquals(72, $forecastCount, "Exactly 72 forecasts should be generated.");

        // Retrieve the first and last forecast to check fields
        $firstForecast = Forecast::where('telemetry_node_id', $node->id)
            ->orderBy('forecasted_for', 'asc')
            ->first();

        $this->assertNotNull($firstForecast, "First forecast should exist.");
        $this->assertGreaterThan(0, $firstForecast->predicted_water_level);
        $this->assertNotNull($firstForecast->created_at, "created_at timestamp must be manually included during bulk insert.");
        $this->assertNotNull($firstForecast->updated_at, "updated_at timestamp must be manually included during bulk insert.");

        // Clean verification of forecasted_for timestamp ordering
        $allForecasts = Forecast::where('telemetry_node_id', $node->id)
            ->orderBy('forecasted_for', 'asc')
            ->get();

        $this->assertCount(72, $allForecasts);
        for ($i = 0; $i < 72; $i++) {
            $expectedTime = $now->copy()->addHours($i + 1)->toDateTimeString();
            $actualTime = Carbon::parse($allForecasts[$i]->forecasted_for)->toDateTimeString();
            $this->assertEquals($expectedTime, $actualTime, "Forecast entry #" . ($i + 1) . " is not correctly scheduled.");
        }
    }
}
