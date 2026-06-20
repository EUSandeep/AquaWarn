<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AVN - Automated Visual Network</title>
    <style>
        :root {
            --bg-color: #0f172a;
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
            --accent-color: #38bdf8;
            --text-color: #f8fafc;
            --secondary-text: #94a3b8;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .glass-panel {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }

        nav {
            padding: 1.5rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--glass-border);
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--accent-color);
            text-decoration: none;
        }

        .nav-links a {
            color: var(--text-color);
            text-decoration: none;
            margin-left: 2rem;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--accent-color);
        }

        main {
            flex: 1;
            padding: 2rem 5%;
        }

        footer {
            padding: 2rem;
            text-align: center;
            color: var(--secondary-text);
            font-size: 0.9rem;
            border-top: 1px solid var(--glass-border);
        }

        .btn {
            background: var(--accent-color);
            color: var(--bg-color);
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.2s, opacity 0.2s;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--secondary-text);
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem;
            background: rgba(0,0,0,0.2);
            border: 1px solid var(--glass-border);
            border-radius: 8px;
            color: white;
            box-sizing: border-box;
        }
    </style>
    @yield('styles')
    @vite(['resources/js/app.js'])
</head>
<body>
    <nav>
        <a href="/" class="logo">AVN Project</a>
        <div class="nav-links">
            <a href="/">Home</a>
            @auth
                @if(Auth::user()->isAdmin())
                    <a href="/admin/dashboard" style="color: #f59e0b;">Admin Dashboard</a>
                    <a href="/admin/nodes/manage">Manage Nodes</a>
                    <a href="/admin/users">Users</a>
                    <a href="/admin/settings">Settings</a>
                @endif
                <a href="/dashboard">Dashboard</a>
                <a href="/nodes">Nodes</a>
                <a href="/alerts">Alerts</a>
                <a href="/reports">Reports</a>
                <a href="/profile">Profile</a>
                <form action="/logout" method="POST" style="display:inline">
                    @csrf
                    <button type="submit" style="background:none; border:none; color:white; cursor:pointer; margin-left:20px;">Logout</button>
                </form>
            @else
                <a href="/login">Login</a>
                <a href="/register">Register</a>
            @endauth
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer>
        &copy; 2026 Automated Visual Network (AVN). Academic Scope: CIS6035 - Kelani Basin Flood Mitigation.
    </footer>

    @yield('scripts')
</body>
</html>
