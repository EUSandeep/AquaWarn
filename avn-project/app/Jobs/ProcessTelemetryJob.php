<?php

namespace App\Jobs;

use App\Models\TelemetryNode;
use App\Models\TelemetryData;
use App\Models\Alert;
use App\Jobs\GenerateForecastJob;
use App\Events\TelemetryReceived;
use App\Events\AlertTriggered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Carbon\Carbon;

class ProcessTelemetryJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected TelemetryNode $node,
        protected array $data
    ) {}

    public function handle(): void
    {
        $telemetry = TelemetryData::create([
            'telemetry_node_id' => $this->node->id,
            'water_level' => $this->data['water_level'],
            'rainfall' => $this->data['rainfall'],
            'battery_voltage' => $this->data['battery_voltage'] ?? null,
            'recorded_at' => isset($this->data['timestamp']) ? Carbon::parse($this->data['timestamp']) : Carbon::now(),
        ]);

        // Check for alerts
        if ($telemetry->water_level >= $this->node->water_level_threshold) {
            $alert = Alert::create([
                'telemetry_node_id' => $this->node->id,
                'type' => 'water_level',
                'severity' => 'critical',
                'message' => "Critical water level detected at {$this->node->name}: {$telemetry->water_level}m",
                'triggered_at' => Carbon::now(),
            ]);
            AlertTriggered::dispatch($alert);
        }

        if ($telemetry->rainfall >= $this->node->rainfall_threshold) {
            $alert = Alert::create([
                'telemetry_node_id' => $this->node->id,
                'type' => 'rainfall',
                'severity' => 'warning',
                'message' => "High rainfall detected at {$this->node->name}: {$telemetry->rainfall}mm",
                'triggered_at' => Carbon::now(),
            ]);
            AlertTriggered::dispatch($alert);
        }

        // Trigger forecast generation
        GenerateForecastJob::dispatch($this->node);

        TelemetryReceived::dispatch($telemetry);
    }
}
