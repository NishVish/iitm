
<?php
$uri = service('uri');
$currentSegment = $uri->getSegment(1); // Gets the first segment

$session = session();

$user_id             = $session->get('user_id');
$employee_id         = $session->get('employee_id');
$name                = ucfirst(strtolower($session->get('name')));
$designation         = $session->get('designation');
$phone               = $session->get('phone');
$address             = $session->get('address');
$email               = $session->get('email');
$category            = $session->get('category');
$department          = $session->get('department');
$doj                 = $session->get('doj');
$uan_no              = $session->get('uan_no');
$fathers_name        = $session->get('fathers_name');
$aadhaar_card        = $session->get('aadhaar_card');
$pan_card            = $session->get('pan_card');
$bank_account_number = $session->get('bank_account_number');
$ifsc_code           = $session->get('ifsc_code');
$user_type           = $session->get('user_type');
$journal             = $session->get('journal') ?? '';
$server             = $session->get('server') ?? '';


// $user_id     = $session->get('user_id');
// $name        = ucfirst(strtolower($session->get('name')));
// $department  = $session->get('department');



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Management | Dashboard</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #a82324;
            --primary-light: #fef2f2;
            --bg-body: #f8fafc;
            --sidebar-width: 260px;
            --topbar-height: 70px;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --white: #ffffff;
            --border: #e2e8f0;
            --radius: 12px;
        }

        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            margin: 0;
            overflow-x: hidden;
        }

        /* Dashboard Layout Structure */
        .app-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Redesign */
        .main-sidebar {
            width: var(--sidebar-width);
            background: var(--primary);
            color: white;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            transition: all 0.3s ease;
            z-index: 1001;
        }

        .sidebar-brand {
            padding: 25px;
            font-size: 1.2rem;
            font-weight: 700;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }

        .nav-menu {
            padding: 20px 15px;
            flex-grow: 1;
            overflow-y: auto;
        }

        .nav-menu a {
            display: flex;
            align-items: center;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            padding: 12px 15px;
            margin-bottom: 5px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.95rem;
            transition: 0.2s;
        }

        .nav-menu a:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .nav-menu a.active {
            background: white;
            color: var(--primary);
        }

        /* Top Header */
        .main-content {
            flex-grow: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
        }

        header {
            height: var(--topbar-height);
            background: var(--white);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-title h2 {
            margin: 0;
            font-size: 1.1rem;
            color: var(--text-muted);
        }

        .user-controls {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .btn-settings {
            background: var(--primary-light);
            color: var(--primary);
            border: none;
            padding: 8px 16px;
            border-radius: 50px;
            cursor: pointer;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Spreadsheet Card Wrapper */
        .page-content {
            padding: 30px;
        }

        .data-card {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 20px;
            overflow: hidden;
        }

        #spreadsheet {
            width: 100% !important;
            border: 1px solid var(--border) !important;
            border-radius: 8px;
        }

        /* Settings Popup */
        .theme-panel {
            position: fixed;
            top: 80px;
            right: 20px;
            width: 300px;
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border: 1px solid var(--border);
            display: none;
            z-index: 2000;
        }

        .panel-header {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 700;
        }

        .panel-body {
            padding: 20px;
        }

        .color-group {
            margin-bottom: 15px;
        }

        .color-group label {
            display: block;
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .color-group input {
            width: 100%;
            height: 40px;
            border-radius: 6px;
            border: 1px solid var(--border);
            cursor: pointer;
        }

        /* Responsive Mobile */
        @media (max-width: 992px) {
            .main-sidebar {
                transform: translateX(-100%);
            }
            .main-content {
                margin-left: 0;
            }
            .sidebar-open .main-sidebar {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body>

<div class="app-container">
    <aside class="main-sidebar">
        <div class="sidebar-brand">IITM CMS</div>
        <nav class="nav-menu">
            <a href="<?= base_url('home') ?>">🏠 Home</a>
            <a href="<?= base_url('backend') ?>">⚙️ Backend</a>
            <a href="<?= base_url('company') ?>" class="active">📊 Database</a>
            <a href="<?= base_url('events') ?>">📅 Events</a>
            <a href="<?= base_url('leads') ?>">🎯 Leads</a>
            <a href="<?= site_url('ticket') ?>">🎟️ Ticket</a>
            <a href="<?= site_url('registration') ?>">📝 Registration</a>
            <hr style="border: none; border-top: 1px solid rgba(255,255,255,0.1); margin: 20px 0;">
            <a href="http://localhost/phpmyadmin/index.php" target="_blank">🗄️ PHPMyAdmin</a>
            <a href="<?= site_url('logout') ?>" style="color: #ffb3b3;">🚪 Logout</a>
        </nav>
    </aside>

    <div class="main-content">
        <header>
            <div class="header-title">
                <h2>Welcome, <?= htmlspecialchars($session->get('name') ?? 'Admin') ?></h2>
            </div>
            <div class="user-controls">
                <span style="font-size: 12px; color: var(--text-muted);"><?= esc($server) ?></span>
                <button class="btn-settings" id="openTheme">
                    Customize ⚙️
                </button>
            </div>
        </header>


    <div id="themeWindow" class="theme-panel">
        <div class="panel-header">
            Theme Settings
            <button id="closeTheme" style="background:none; border:none; cursor:pointer; font-size:18px;">&times;</button>
        </div>
        <div class="panel-body">
            <div class="color-group">
                <label>Navbar Color</label>
                <input type="color" id="navColor" value="#a82324">
            </div>
            <div class="color-group">
                <label>Body Background</label>
                <input type="color" id="bodyColor" value="#f8fafc">
            </div>
            <div class="color-group">
                <label>Button/Brand Color</label>
                <input type="color" id="buttonColor" value="#a82324">
            </div>
            <button id="resetTheme" style="width:100%; padding:10px; border-radius:6px; border:none; background:#eee; cursor:pointer;">Reset Defaults</button>
        </div>
    </div>
<script>
    // Theme Logic remains similar but targets root vars better
    document.addEventListener("DOMContentLoaded", function () {
        const themeWindow = document.getElementById("themeWindow");
        const openBtn = document.getElementById("openTheme");
        const closeBtn = document.getElementById("closeTheme");
        
        openBtn.onclick = () => themeWindow.style.display = "block";
        closeBtn.onclick = () => themeWindow.style.display = "none";

        // Logic for input/localstorage here is the same as your previous script
        // just make sure to set the correct variables like '--primary' or '--bg-body'
    });
</script>

<div>
