<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Sphere Workspace</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <style>
        /* CSS Variables for easy color management */
        :root {
            --brand-yellow: #f7c41b;
            --dark-bg: #1A1A1A;
            --light-bg: #F8F9FA;
            --text-main: #2D3436;
        }

        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        
        body { 
            margin: 0; 
            font-family: 'Inter', sans-serif; 
            background-color: var(--light-bg); 
            color: var(--text-main);
            padding-bottom: 100px;
        }

        /* --- Global Header --- */
        header {
            background: #ffffff;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        }

        .logo-img { height: 32px; width: auto; }

        .logout-link {
            font-size: 13px;
            font-weight: 700;
            color: var(--dark-bg);
            text-decoration: none;
            background: var(--brand-yellow);
            padding: 8px 16px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* --- Welcome Section --- */
        .welcome-card {
            padding: 30px 20px;
            background: white;
            border-bottom: 1px solid #EDEDED;
        }

        .welcome-card h1 { 
            margin: 0; 
            font-size: 26px; 
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .welcome-card p { 
            margin: 6px 0 0 0; 
            color: #636e72; 
            font-size: 14px; 
        }

        /* --- Corporate Grid --- */
        .main-container { padding: 20px; }
        
        .section-label {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #B2BEC3;
            margin-bottom: 15px;
            display: block;
        }

        .action-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .action-item {
            background: white;
            padding: 24px 16px;
            border-radius: 24px;
            text-align: center;
            text-decoration: none;
            color: inherit;
            border: 1px solid #F1F2F6;
            transition: 0.2s ease;
        }

        .action-item:active {
            transform: scale(0.96);
            background: #FFFCEB; /* Subtle yellow tint on tap */
            border-color: var(--brand-yellow);
        }

        .icon-wrapper {
            width: 50px;
            height: 50px;
            background: #fdf8e6;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px auto;
        }

        .icon-wrapper span { color: var(--dark-bg); font-size: 28px; }

        .item-title { font-size: 15px; font-weight: 600; color: var(--dark-bg); }
        .item-sub { font-size: 11px; color: #B2BEC3; margin-top: 4px; display: block; }

        /* --- Bottom Navigation --- */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            width: 100%;
            background: var(--dark-bg);
            display: flex;
            padding: 15px 0 35px 0; /* Extra bottom padding for modern iPhones */
            border-top-left-radius: 28px;
            border-top-right-radius: 28px;
            box-shadow: 0 -10px 25px rgba(0,0,0,0.1);
        }

        .nav-link { 
            flex: 1; 
            text-align: center; 
            color: #636e72; 
            text-decoration: none; 
            transition: 0.3s;
        }

        .nav-link.active { color: var(--brand-yellow); }

        .nav-link span { 
            display: block; 
            font-size: 10px; 
            margin-top: 5px; 
            font-weight: 600; 
            text-transform: uppercase;
        }

        /* Subtle Pulse for the Dashboard */
        .pulse-dot {
            height: 8px;
            width: 8px;
            background: var(--brand-yellow);
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
            box-shadow: 0 0 8px var(--brand-yellow);
        }
    </style>
</head>
<body>

    <header>
        <img class="logo-img" src="https://spheretravelmedia.com/wp-content/uploads/2025/03/cropped-cropped-38x38inch-Sphere-Logo-Copy-min_prev_ui-300x100.png" alt="Logo">
        <a href="#" class="logout-link">
            <span class="material-icons-round" style="font-size: 18px;">power_settings_new</span>
            LOGOUT
        </a>
    </header>

    <div class="welcome-card">
        <p><span class="pulse-dot"></span> System Online</p>
        <h1>Hi, Nishant</h1>
        <p>Sphere Corporate Workspace</p>
    </div>

    <div class="main-container">
        <span class="section-label">Employee Services</span>
        
        <div class="action-grid">
            <a href="#" class="action-item">
                <div class="icon-wrapper"><span class="material-icons-round">fingerprint</span></div>
                <span class="item-title">Attendance</span>
                <span class="item-sub">Log work hours</span>
            </a>
            <a href="#" class="action-item">
                <div class="icon-wrapper"><span class="material-icons-round">event_available</span></div>
                <span class="item-title">Leaves</span>
                <span class="item-sub">Request time off</span>
            </a>
            <a href="#" class="action-item">
                <div class="icon-wrapper"><span class="material-icons-round">payments</span></div>
                <span class="item-title">Payroll</span>
                <span class="item-sub">Slips & Tax info</span>
            </a>
            <a href="#" class="action-item">
                <div class="icon-wrapper"><span class="material-icons-round">receipt_long</span></div>
                <span class="item-title">Claims</span>
                <span class="item-sub">Travel expenses</span>
            </a>
            <a href="#" class="action-item">
                <div class="icon-wrapper"><span class="material-icons-round">description</span></div>
                <span class="item-title">Policies</span>
                <span class="item-sub">Company handbook</span>
            </a>
            <a href="#" class="action-item">
                <div class="icon-wrapper"><span class="material-icons-round">support_agent</span></div>
                <span class="item-title">Support</span>
                <span class="item-sub">Contact IT/HR</span>
            </a>
        </div>
    </div>

    <nav class="bottom-nav">
        <a href="#" class="nav-link active">
            <i class="material-icons-round">grid_view</i>
            <span>Portal</span>
        </a>
        <a href="#" class="nav-link">
            <i class="material-icons-round">mail</i>
            <span>Inbox</span>
        </a>
        <a href="#" class="nav-link">
            <i class="material-icons-round">groups</i>
            <span>Teams</span>
        </a>
        <a href="#" class="nav-link">
            <i class="material-icons-round">settings</i>
            <span>Settings</span>
        </a>
    </nav>

</body>
</html>