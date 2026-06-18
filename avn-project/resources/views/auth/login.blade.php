@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: center; align-items: center; min-height: 60vh;">
    <div class="glass-panel" style="width: 100%; max-width: 400px;">
        <h2 style="margin-top: 0;">Login</h2>
        <form method="POST" action="/login">
            @csrf
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" required autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn" style="width: 100%;">Sign In</button>
        </form>
        <p style="margin-top: 1.5rem; text-align: center; color: var(--secondary-text);">
            Don't have an account? <a href="/register" style="color: var(--accent-color);">Register</a>
        </p>
    </div>
</div>
@endsection
