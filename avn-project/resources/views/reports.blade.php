@extends('layouts.app')

@section('content')
<div class="glass-panel">
    <h2>Data Reports & Export</h2>
    <p style="color: var(--secondary-text);">Generate and download historical telemetry data for academic analysis.</p>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-top: 2rem;">
        <div class="glass-panel" style="text-align: center;">
            <h4>Historical Telemetry (CSV)</h4>
            <p style="font-size: 0.9rem; margin-bottom: 1.5rem;">All sensor readings for the last 30 days.</p>
            <button class="btn">Generate CSV</button>
        </div>
        <div class="glass-panel" style="text-align: center;">
            <h4>Alert Log (PDF)</h4>
            <p style="font-size: 0.9rem; margin-bottom: 1.5rem;">Summary of all critical flood events.</p>
            <button class="btn">Generate PDF</button>
        </div>
    </div>
</div>
@endsection
