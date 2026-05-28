@php
    if (
        !session()->has('internal_admin') ||
        !session()->has('internal_name') ||
        !session()->has('internal_role')
    ) {
        header("Location: " . route('internal.login'));
        exit;
    }
@endphp
<style>
    body {
        padding: 0 !important;
        margin: 0 !important;
    }
</style>

<div class="internal-header">

    <style>
        .internal-header {
            width: 100%;
            height: 100px;
            /* padding: 20px 20px 20px 20px; */
            background: #111;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: Arial, sans-serif;
            gap: 20px;
        }

        .left,
        .center,
        .right {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .internal-user {
            font-size: 14px;
            font-weight: 600;
        }

        .internal-role {
            font-size: 11px;
            opacity: 0.7;
            text-transform: uppercase;
            margin-left: 6px;
        }

        .nav a {
            color: #fff;
            text-decoration: none;
            font-size: 12px;
            opacity: 0.8;
        }

        .nav a:hover {
            opacity: 1;
        }

        .pill {
            background: rgba(255, 255, 255, 0.1);
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 11px;
        }

        .logout-btn {
            background: #aa2324;
            color: #fff;
            border: none;
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 4px;
            text-decoration: none;
        }

        .logout-btn:hover {
            opacity: 0.9;
        }

        .badge {
            background: #2ecc71;
            color: #000;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 10px;
            margin-left: 4px;
        }
    </style>

    <!-- LEFT -->
    <div class="left">
        <div class="internal-user">
            {{ session('internal_name') }}
            <span class="internal-role">
                ({{ session('internal_role') }})
            </span>
        </div>
    </div>

    <!-- CENTER NAV (CORE SYSTEM) -->
    <div class="center nav">

        <a href="/internal">Dashboard</a>

        <a href="/internal/knowledge">
            Knowledge Base
        </a>

        <a href="/internal/leaves">
            Leaves <span class="badge">new</span>
        </a>

        <a href="/internal/suggestions">
            Suggestions
        </a>

        <a href="/internal/chat">
            Chat
        </a>

    </div>

    <!-- RIGHT -->
    <div class="right">

        <span class="pill">Internal Portal</span>

        <a href="{{ route('internal.logout') }}" class="logout-btn">
            Logout
        </a>

    </div>

</div>