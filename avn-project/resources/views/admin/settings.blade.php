@extends('layouts.app')

@section('content')
<div class="glass-panel">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2>Global Settings</h2>
        <button class="btn">Save All Changes</button>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <div class="glass-panel">
            <h3>System Thresholds</h3>
            <div class="form-group">
                <label>Global Water Level Warning (m)</label>
                <input type="number" value="4.5" step="0.1">
            </div>
            <div class="form-group">
                <label>Global Rainfall Warning (mm)</label>
                <input type="number" value="100">
            </div>
        </div>

        <div class="glass-panel">
            <h3>API Configurations</h3>
            <div class="form-group">
                <label>Node-RED Ingestion Token</label>
                <input type="password" value="avn_secret_token_2026">
            </div>
            <div class="form-group">
                <label>ML Service Endpoint</label>
                <input type="text" value="http://ml-forecasting-service:8080/predict">
            </div>
        </div>
    </div>
</div>
@endsection
