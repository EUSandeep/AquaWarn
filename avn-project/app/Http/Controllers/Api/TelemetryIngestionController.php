<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TelemetryNode;
use App\Jobs\ProcessTelemetryJob;
use Illuminate\Http\Request;

class TelemetryIngestionController extends Controller
{
    public function store(Request $request)
    {
        if ($request->header('X-AVN-Token') !== config('app.telemetry_token')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'node_id' => 'required|string',
            'water_level' => 'required|numeric',
            'rainfall' => 'required|numeric',
            'battery_voltage' => 'nullable|numeric',
            'timestamp' => 'nullable|date',
        ]);

        $node = TelemetryNode::firstOrCreate(
            ['name' => $validated['node_id']],
            [
                'location_name' => 'Kelani Basin - ' . $validated['node_id'],
                'latitude' => 6.9271 + (rand(-100, 100) / 1000),
                'longitude' => 79.8612 + (rand(-100, 100) / 1000),
            ]
        );

        ProcessTelemetryJob::dispatch($node, $validated);

        return response()->json(['status' => 'Telemetry received and processing queued'], 202);
    }
}
