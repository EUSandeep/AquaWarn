@extends('layouts.app')

@section('content')
<div class="glass-panel">
    <h2>User Management</h2>
    <p>Manage roles and access for AVN platform users.</p>

    <table style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
        <thead>
            <tr style="text-align: left; color: var(--secondary-text); border-bottom: 1px solid var(--glass-border);">
                <th style="padding: 1rem;">Name</th>
                <th style="padding: 1rem;">Email</th>
                <th style="padding: 1rem;">Role</th>
                <th style="padding: 1rem;">Joined</th>
                <th style="padding: 1rem;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr style="border-bottom: 1px solid var(--glass-border);">
                <td style="padding: 1rem;">{{ $user->name }}</td>
                <td style="padding: 1rem;">{{ $user->email }}</td>
                <td style="padding: 1rem;">
                    <span style="border: 1px solid var(--accent-color); padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.8rem;">
                        {{ strtoupper($user->role) }}
                    </span>
                </td>
                <td style="padding: 1rem;">{{ $user->created_at->format('Y-m-d') }}</td>
                <td style="padding: 1rem;">
                    <a href="#" style="color: var(--accent-color);">Manage</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
