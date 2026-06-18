<?php

namespace App\Jobs;

use App\Models\TelemetryNode;
use App\Services\MockForecastingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateForecastJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected TelemetryNode $node
    ) {}

    public function handle(MockForecastingService $forecastingService): void
    {
        $forecastingService->generate72HourForecast($this->node);
    }
}
