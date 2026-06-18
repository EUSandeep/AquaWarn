<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelemetryData extends Model
{
    use HasFactory;

    protected $fillable = [
        'telemetry_node_id', 'water_level', 'rainfall', 'battery_voltage', 'recorded_at'
    ];

    public function telemetryNode()
    {
        return $this->belongsTo(TelemetryNode::class);
    }
}
