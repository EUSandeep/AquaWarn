@extends('layouts.app')

@section('content')
<div style="text-align: center; padding: 4rem 0;">
    <h1 style="font-size: 3.5rem; margin-bottom: 1rem;">Automated Visual Network</h1>
    <p style="font-size: 1.25rem; color: var(--secondary-text); max-width: 800px; margin: 0 auto 2rem;">
        Real-time hydrometeorological telemetry and flood forecasting for the Kelani River Basin.
        Leveraging LSTM models and IoT technology to protect communities.
    </p>
    <div style="display: flex; justify-content: center; gap: 1rem;">
        <a href="/register" class="btn">Get Started</a>
        <a href="/login" style="color: white; padding: 0.75rem 1.5rem; text-decoration: none;">View Public Data</a>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-top: 4rem;">
    <div class="glass-panel">
        <h3 style="color: var(--accent-color);">Real-time Monitoring</h3>
        <p>Live sensor data from across the Kelani Basin with instant WebSocket updates.</p>
    </div>
    <div class="glass-panel">
        <h3 style="color: var(--accent-color);">ML Forecasting</h3>
        <p>72-hour water level predictions powered by advanced LSTM neural networks.</p>
    </div>
    <div class="glass-panel">
        <h3 style="color: var(--accent-color);">Smart Alerts</h3>
        <p>Automated warning system for researchers and municipal officers.</p>
    </div>
</div>
@endsection
