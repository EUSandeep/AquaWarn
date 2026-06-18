<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;

    protected $fillable = [
        'telemetry_node_id', 'type', 'severity', 'message', 'triggered_at'
    ];

    public function telemetryNode()
    {
        return $this->belongsTo(TelemetryNode::class);
    }
}
