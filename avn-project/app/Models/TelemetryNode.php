<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelemetryNode extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'location_name', 'latitude', 'longitude', 'status',
        'water_level_threshold', 'rainfall_threshold'
    ];

    public function telemetryData()
    {
        return $this->hasMany(TelemetryData::class);
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }

    public function forecasts()
    {
        return $this->hasMany(Forecast::class);
    }
}
