@extends('layouts.app')

@section('content')
<div class="glass-panel">
    <h2>Admin Command Center</h2>
    <p>System health and administrative overview.</p>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-top: 2rem;">
        <div class="glass-panel" style="background: rgba(16, 185, 129, 0.1);">
            <h4>Database Connection</h4>
            <div style="font-size: 1.2rem; color: #10b981;">● Healthy (SQLite)</div>
        </div>
        <div class="glass-panel" style="background: rgba(56, 189, 248, 0.1);">
            <h4>Broadcasting Server</h4>
            <div style="font-size: 1.2rem; color: #38bdf8;">● Reverb Active</div>
        </div>
        <div class="glass-panel" style="background: rgba(245, 158, 11, 0.1);">
            <h4>Total Registered Users</h4>
            <div style="font-size: 2rem; font-weight: bold;">{{ \App\Models\User::count() }}</div>
        </div>
    </div>

    <div style="margin-top: 3rem;">
        <h3>System Logs (Recent)</h3>
        <div class="glass-panel" style="font-family: monospace; font-size: 0.9rem; color: #94a3b8; max-height: 200px; overflow-y: auto;">
            [2026-06-16 18:25:00] INFO: Node-RED ingestion pipeline connected.<br>
            [2026-06-16 18:27:00] INFO: Mock LSTM forecast job completed for NODE001.<br>
            [2026-06-16 18:30:00] WARN: High rainfall threshold exceeded at KADUWELA_01.
        </div>
    </div>
</div>
@endsection
