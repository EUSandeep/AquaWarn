@extends('layouts.app')

@section('content')
<div class="glass-panel">
    <h2>Node Management</h2>
    <p>Manage physical telemetry nodes deployed in the Kelani River Basin.</p>

    <table style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
        <thead>
            <tr style="text-align: left; color: var(--secondary-text); border-bottom: 1px solid var(--glass-border);">
                <th style="padding: 1rem;">Node ID</th>
                <th style="padding: 1rem;">Location</th>
                <th style="padding: 1rem;">Thresholds (W/R)</th>
                <th style="padding: 1rem;">Status</th>
                <th style="padding: 1rem;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($nodes as $node)
            <tr style="border-bottom: 1px solid var(--glass-border);">
                <td style="padding: 1rem;">{{ $node->name }}</td>
                <td style="padding: 1rem;">{{ $node->location_name }}</td>
                <td style="padding: 1rem;">{{ $node->water_level_threshold }}m / {{ $node->rainfall_threshold }}mm</td>
                <td style="padding: 1rem;">
                    <span style="background: {{ $node->status === 'online' ? '#059669' : '#b91c1c' }}; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem;">
                        {{ strtoupper($node->status) }}
                    </span>
                </td>
                <td style="padding: 1rem;">
                    <a href="/nodes/{{ $node->id }}" style="color: var(--accent-color);">View Details</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
