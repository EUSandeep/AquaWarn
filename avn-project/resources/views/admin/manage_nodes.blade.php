@extends('layouts.app')

@section('content')
<div class="glass-panel">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2>Node Management</h2>
        <button class="btn">+ Deploy New Node</button>
    </div>

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: left; color: var(--secondary-text); border-bottom: 1px solid var(--glass-border);">
                <th style="padding: 1rem;">Node ID</th>
                <th style="padding: 1rem;">Location</th>
                <th style="padding: 1rem;">Coordinates</th>
                <th style="padding: 1rem;">Status</th>
                <th style="padding: 1rem;">Last Calibration</th>
                <th style="padding: 1rem;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($nodes as $node)
            <tr style="border-bottom: 1px solid var(--glass-border);">
                <td style="padding: 1rem;">{{ $node->name }}</td>
                <td style="padding: 1rem;">{{ $node->location_name }}</td>
                <td style="padding: 1rem;">{{ $node->latitude }}, {{ $node->longitude }}</td>
                <td style="padding: 1rem;">{{ strtoupper($node->status) }}</td>
                <td style="padding: 1rem;">2026-06-01</td>
                <td style="padding: 1rem;">
                    <button style="color: var(--accent-color); background: none; border: none; cursor: pointer;">Calibrate</button> |
                    <button style="color: #ef4444; background: none; border: none; cursor: pointer;">Decommission</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
