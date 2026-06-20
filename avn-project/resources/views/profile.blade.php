@extends('layouts.app')

@section('content')
<div class="glass-panel" style="max-width: 600px; margin: 0 auto;">
    <h2>User Profile</h2>
    <div class="form-group">
        <label>Full Name</label>
        <input type="text" value="{{ $user->name }}" readonly>
    </div>
    <div class="form-group">
        <label>Email Address</label>
        <input type="email" value="{{ $user->email }}" readonly>
    </div>
    <div class="form-group">
        <label>Role</label>
        <input type="text" value="{{ strtoupper($user->role) }}" readonly>
    </div>
    <div class="form-group">
        <label>Academic Credentials</label>
        <textarea style="width:100%; background:rgba(0,0,0,0.2); border:1px solid var(--glass-border); border-radius:8px; color:white; padding:10px;" readonly>Researcher / Municipal Officer (Verified)</textarea>
    </div>
</div>
@endsection
