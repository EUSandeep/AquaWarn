<?php

namespace App\Http\Controllers;

use App\Models\TelemetryNode;
use App\Models\TelemetryData;
use App\Models\Alert;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'nodesCount' => TelemetryNode::count(),
            'alertsCount' => Alert::count(),
            'avgWaterLevel' => round(TelemetryData::avg('water_level') ?? 0, 2),
            'nodes' => TelemetryNode::all(),
            // Optimization: Explicitly query by indexed 'recorded_at' column instead of default 'created_at'
            'recentTelemetry' => TelemetryData::with('telemetryNode')->latest('recorded_at')->take(10)->get(),
        ]);
    }
}
