@extends('layouts.app')

@section('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    .chart-container { position: relative; height: 400px; width: 100%; margin-bottom: 2rem; }
</style>
@endsection

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2>Node Detail: {{ $node->name }}</h2>
    <span style="background: {{ $node->status === 'online' ? '#059669' : '#b91c1c' }}; padding: 0.5rem 1rem; border-radius: 8px;">
        {{ strtoupper($node->status) }}
    </span>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
    <div class="glass-panel">
        <h3>Current Status</h3>
        <p><strong>Location:</strong> {{ $node->location_name }}</p>
        <p><strong>Coordinates:</strong> {{ $node->latitude }}, {{ $node->longitude }}</p>
        <p><strong>W.Level Threshold:</strong> {{ $node->water_level_threshold }}m</p>
        <p><strong>Rainfall Threshold:</strong> {{ $node->rainfall_threshold }}mm</p>
    </div>
    <div class="glass-panel">
        <h3>Latest Reading</h3>
        @if($latest)
            <div style="font-size: 2.5rem; color: var(--accent-color); font-weight: bold;">{{ $latest->water_level }}m</div>
            <div style="color: var(--secondary-text);">Recorded {{ $latest->recorded_at->diffForHumans() }}</div>
            <div style="margin-top: 1rem;">Rainfall: {{ $latest->rainfall }}mm</div>
        @else
            <p>No telemetry data available.</p>
        @endif
    </div>
</div>

<div class="glass-panel">
    <h3>72-Hour Forecast vs Historical Trend</h3>
    <div class="chart-container">
        <canvas id="telemetryChart"></canvas>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const ctx = document.getElementById('telemetryChart').getContext('2d');
    const historicalData = @json($historical);
    const forecastData = @json($forecast);

    const labels = [
        ...historicalData.map(d => new Date(d.recorded_at).toLocaleTimeString()),
        ...forecastData.map(f => new Date(f.forecasted_for).toLocaleTimeString())
    ];

    window.currentNodeId = {{ $node->id }};
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Historical Water Level (m)',
                    data: [...historicalData.map(d => d.water_level), ...new Array(forecastData.length).fill(null)],
                    borderColor: '#38bdf8',
                    tension: 0.4,
                    fill: false
                },
                {
                    label: '72h Forecast (LSTM)',
                    data: [...new Array(historicalData.length).fill(null), ...forecastData.map(f => f.predicted_water_level)],
                    borderColor: '#a855f7',
                    borderDash: [5, 5],
                    tension: 0.4,
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: false, grid: { color: 'rgba(255,255,255,0.1)' } },
                x: { grid: { display: false } }
            },
            plugins: {
                legend: { labels: { color: 'white' } }
            }
        }
    });
    window.nodeChart = chart;
</script>
@endsection
