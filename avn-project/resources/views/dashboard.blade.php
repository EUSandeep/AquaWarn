@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    #map { height: 500px; border-radius: 16px; margin-bottom: 2rem; }
    .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
    .stat-card { padding: 1.5rem; text-align: center; }
    .stat-value { font-size: 2rem; font-weight: bold; color: var(--accent-color); }
</style>
@endsection

@section('content')
<div class="stat-grid">
    <div class="glass-panel stat-card">
        <div class="stat-value">{{ $nodesCount }}</div>
        <div style="color: var(--secondary-text);">Active Nodes</div>
    </div>
    <div class="glass-panel stat-card">
        <div class="stat-value">{{ $alertsCount }}</div>
        <div style="color: #ef4444;">Active Alerts</div>
    </div>
    <div class="glass-panel stat-card">
        <div class="stat-value">{{ $avgWaterLevel }}m</div>
        <div style="color: var(--secondary-text);">Avg Water Level</div>
    </div>
</div>

<div id="map" class="glass-panel"></div>

<div class="glass-panel">
    <h3>Recent Telemetry</h3>
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: left; color: var(--secondary-text); border-bottom: 1px solid var(--glass-border);">
                <th style="padding: 1rem;">Node</th>
                <th style="padding: 1rem;">Water Level</th>
                <th style="padding: 1rem;">Rainfall</th>
                <th style="padding: 1rem;">Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentTelemetry as $data)
            <tr style="border-bottom: 1px solid var(--glass-border);">
                <td style="padding: 1rem;">{{ $data->telemetryNode->name }}</td>
                <td style="padding: 1rem;">{{ $data->water_level }}m</td>
                <td style="padding: 1rem;">{{ $data->rainfall }}mm</td>
                <td style="padding: 1rem;">{{ $data->recorded_at->diffForHumans() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    var map = L.map('map').setView([6.9271, 79.8612], 10);
    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
    }).addTo(map);

    var nodes = @json($nodes);
    nodes.forEach(function(node) {
        var color = node.status === 'online' ? '#38bdf8' : '#ef4444';
        L.circleMarker([node.latitude, node.longitude], {
            color: color,
            fillColor: color,
            fillOpacity: 0.5,
            radius: 10
        }).addTo(map).bindPopup("<b>" + node.name + "</b><br>" + node.location_name);
    });
</script>
@endsection
