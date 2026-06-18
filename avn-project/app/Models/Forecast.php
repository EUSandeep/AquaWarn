<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forecast extends Model
{
    use HasFactory;

    protected $fillable = [
        'telemetry_node_id', 'predicted_water_level', 'forecasted_for'
    ];

    public function telemetryNode()
    {
        return $this->belongsTo(TelemetryNode::class);
    }
}
