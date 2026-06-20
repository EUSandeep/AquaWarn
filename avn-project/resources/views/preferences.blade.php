@extends('layouts.app')

@section('content')
<div class="glass-panel" style="max-width: 600px; margin: 0 auto;">
    <h2>Notification Preferences</h2>
    <p style="color: var(--secondary-text);">Manage how you receive flood and rainfall alerts.</p>

    <div style="margin-top: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; padding: 1rem; background: rgba(255,255,255,0.02); border-radius: 8px;">
            <div>
                <strong>Email Alerts</strong>
                <div style="font-size: 0.9rem; color: var(--secondary-text);">Receive critical warnings via email.</div>
            </div>
            <input type="checkbox" checked>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; padding: 1rem; background: rgba(255,255,255,0.02); border-radius: 8px;">
            <div>
                <strong>SMS Notifications</strong>
                <div style="font-size: 0.9rem; color: var(--secondary-text);">Immediate SMS for flood risk levels.</div>
            </div>
            <input type="checkbox">
        </div>

        <button class="btn" style="width: 100%;">Save Preferences</button>
    </div>
</div>
@endsection
