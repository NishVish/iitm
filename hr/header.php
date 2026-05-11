<?php
session_start();

// Protection: Kick out unauthenticated users
if (!isset($_SESSION['logged_in']) && $_SESSION['user_type'] != "admin") {
    header("Location: login.php");
    exit;
}

include('connection.php');

// Simple Active Link Detection
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --iitm-red: #AA2D2C;
            --iitm-dark: #1a1a1a;
            --nav-height: 70px;
        }

        body {
            margin: 0;
            padding-top: var(--nav-height);
            /* Prevent content from hiding under fixed nav */
            font-family: 'Segoe UI', Roboto, sans-serif;
            background-color: #f8f9fa;
        }

        /* Modern Navigation Bar */
        .navbar {
            height: var(--nav-height);
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            box-sizing: border-box;
            border-bottom: 3px solid var(--iitm-red);
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-area img {
            height: 40px;
        }

        .logo-area span {
            font-weight: 800;
            color: var(--iitm-dark);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 1.1rem;
        }

        .nav-links {
            display: flex;
            gap: 5px;
            height: 100%;
        }

        .nav-links a {
            color: #555;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0 20px;
            display: flex;
            align-items: center;
            height: var(--nav-height);
            transition: all 0.3s ease;
            position: relative;
        }

        /* Hover & Active States */
        .nav-links a:hover {
            color: var(--iitm-red);
            background: rgba(170, 45, 44, 0.03);
        }

        .nav-links a.active {
            color: var(--iitm-red);
        }

        .nav-links a.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--iitm-red);
        }

        /* Logout Button - Distinct Style */
        .logout-btn {
            background: #f1f1f1;
            margin: 15px 0 15px 15px !important;
            height: 40px !important;
            border-radius: 6px;
            align-self: center;
        }

        .logout-btn:hover {
            background: #ffebee !important;
            color: var(--iitm-red) !important;
        }

        /* Breadcrumb/Segment Info (Optional UI element) */
        .uri-info {
            background: #fff;
            padding: 10px 40px;
            font-size: 0.8rem;
            color: #999;
            border-bottom: 1px solid #eee;
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <div class="logo-area">
            <img src="https://iitmindia.com/assets/iitm3.png" alt="Logo">
            <span>Admin Panel</span>
        </div>

        <div class="nav-links">
            <a href="home.php" class="<?= $current_page == 'home.php' ? 'active' : '' ?>">🏠 HOME</a>
            <a href="index.php"
                class="<?= ($current_page == 'index.php' || $current_page == 'info.php' || $current_page == 'create.php') ? 'active' : '' ?>">👤
                USERS</a>
            <a href="tables.php" class="<?= $current_page == 'tables.php' ? 'active' : '' ?>">📊 TABLES</a>
            <a href="logout.php" class="logout-btn">LOGOUT</a>
        </div>
    </nav>

    <div class="uri-info">
        Dashboard / <?= ucfirst(str_replace('.php', '', $current_page)) ?>
    </div>