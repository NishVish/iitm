<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard</title>

    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f7fb;
            color: #1f2937;
        }

        /* =========================================================
           HEADER
        ========================================================= */

        .header {
            height: 64px;
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 24px;

            position: fixed;
            top: 0;
            left: 0;
            right: 0;

            z-index: 1000;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo {
            font-size: 20px;
            font-weight: 700;
            color: #2563eb;
        }

        .menu-btn {
            display: none;

            width: 40px;
            height: 40px;

            border: 0;
            background: #f3f4f6;
            border-radius: 6px;

            font-size: 20px;
            cursor: pointer;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;

            border-radius: 50%;

            background: #2563eb;
            color: #ffffff;

            display: flex;
            align-items: center;
            justify-content: center;

            font-weight: 700;
        }


        /* =========================================================
           SIDEBAR
        ========================================================= */

        .sidebar {
            position: fixed;

            top: 64px;
            left: 0;
            bottom: 0;

            width: 240px;

            background: #111827;
            color: #ffffff;

            padding: 20px 12px;

            overflow-y: auto;

            z-index: 900;

            transition: transform 0.25s ease;
        }

        .nav-title {
            padding: 10px 12px;

            font-size: 11px;
            font-weight: 700;

            color: #9ca3af;

            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .nav {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .nav a {
            display: flex;
            align-items: center;
            gap: 12px;

            padding: 11px 12px;

            color: #d1d5db;
            text-decoration: none;

            border-radius: 6px;

            font-size: 14px;

            transition:
                background 0.2s,
                color 0.2s;
        }

        .nav a:hover {
            background: #1f2937;
            color: #ffffff;
        }

        .nav a.active {
            background: #2563eb;
            color: #ffffff;
        }

        .nav-icon {
            width: 20px;
            text-align: center;
        }


        /* =========================================================
           MAIN
        ========================================================= */

        .main {
            margin-left: 240px;

            padding-top: 64px;

            min-height: 100vh;
        }

        .main-content {
            padding: 30px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-bottom: 25px;
        }

        .page-header h1 {
            margin: 0;

            font-size: 24px;
            color: #111827;
        }

        .page-header p {
            margin: 5px 0 0;

            color: #6b7280;
            font-size: 14px;
        }


        /* =========================================================
           CONTENT CARD
        ========================================================= */

        .card {
            background: #ffffff;

            border: 1px solid #e5e7eb;
            border-radius: 10px;

            padding: 24px;
        }


        /* =========================================================
           MOBILE OVERLAY
        ========================================================= */

        .sidebar-overlay {
            display: none;

            position: fixed;

            top: 64px;
            left: 0;
            right: 0;
            bottom: 0;

            background: rgba(0, 0, 0, 0.4);

            z-index: 800;
        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 768px) {

            .header {
                padding: 0 15px;
            }

            .menu-btn {
                display: block;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-overlay.open {
                display: block;
            }

            .main {
                margin-left: 0;
            }

            .main-content {
                padding: 20px 15px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .user-name {
                display: none;
            }
        }
    </style>
</head>

<body>


    <!-- =========================================================
         HEADER
    ========================================================= -->

    <header class="header">

        <div class="header-left">

            <button type="button" class="menu-btn" id="menuBtn" aria-label="Toggle navigation">
                ☰
            </button>

            <div class="logo">
                My Dashboard
            </div>

        </div>


        <div class="header-right">

            <div class="user-info">

                <span class="user-name">
                    Admin
                </span>

                <div class="user-avatar">
                    A
                </div>

            </div>

        </div>

    </header>


    <!-- =========================================================
         SIDEBAR
    ========================================================= -->

    <aside class="sidebar" id="sidebar">

        <div class="nav-title">
            Main Menu
        </div>

        <nav class="nav">

            <a href="#" class="active">
                <span class="nav-icon">⌂</span>
                Dashboard
            </a>

            <a href="#">
                <span class="nav-icon">🏢</span>
                Companies
            </a>

            <a href="#">
                <span class="nav-icon">👥</span>
                Contacts
            </a>

            <!-- <a href="#">
                <span class="nav-icon">📋</span>
                Leads
            </a>

            <a href="#">
                <span class="nav-icon">📊</span>
                Reports
            </a> -->

        </nav>


        <div class="nav-title">
            Settings
        </div>

        <nav class="nav">

            <a href="#">
                <span class="nav-icon">⚙</span>
                Settings
            </a>

            <a href="#">
                <span class="nav-icon">↪</span>
                Logout
            </a>

        </nav>

    </aside>


    <!-- =========================================================
         MOBILE OVERLAY
    ========================================================= -->

    <div class="sidebar-overlay" id="sidebarOverlay"></div>


    <!-- =========================================================
         MAIN CONTENT
    ========================================================= -->

    <main class="main">

        <div class="main-content">