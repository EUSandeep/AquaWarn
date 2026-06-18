<?php

namespace App\Events;

use App\Models\TelemetryData;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TelemetryReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public TelemetryData $telemetry) {}

    public function broadcastOn(): array
    {
        return [
            new Channel('telemetry'),
        ];
    }
}
