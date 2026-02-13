<?php
// header.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Company Management System</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            background-color: #f8f4f4; /* light background for contrast */
        }

        /* Navigation bar */
        nav { 
            background: #a82324; /* your deep red palette */
            padding: 12px 20px; 
            color: white; 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        nav a { 
            color: white; 
            margin-right: 20px; 
            text-decoration: none; 
            font-weight: 500;
            transition: all 0.3s ease;
        }

        nav a:hover { 
            text-decoration: underline;
            color: #ffb3b3; /* light pink hover for contrast */
        }

        /* Search box styling */
        .search-box input[type="text"] { 
            padding: 6px 10px; 
            border-radius: 8px; 
            border: none; 
            outline: none;
            width: 180px;
            transition: all 0.3s ease;
        }

        .search-box input[type="text"]:focus {
            box-shadow: 0 0 8px rgba(168, 35, 36, 0.7); /* glow effect in red palette */
        }

        .search-box button { 
            padding: 6px 12px; 
            border: none; 
            border-radius: 8px; 
            background: #a82324; 
            color: #fff; 
            cursor: pointer; 
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .search-box button:hover { 
            background: #8b1d20; /* darker red hover */
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(0,0,0,0.2);
        }

        /* Content area */
        .content { 
            padding: 20px; 
        }

        /* Responsive nav */
        @media(max-width: 768px) {
            nav { 
                flex-direction: column; 
                align-items: flex-start; 
            }
            .nav-links { 
                margin-bottom: 10px; 
            }
            .nav-links a { 
                margin-right: 10px; 
                margin-bottom: 5px; 
            }
        }
    </style>
</head>
<body>

<!-- Navigation with search -->
<nav>
    <div class="nav-links">
        <a href="<?= base_url('') ?>">Home</a>
        <a href="<?= base_url('backend') ?>">Backend</a>
        <a href="<?= base_url('plan') ?>">Plan</a>
        <a href="<?= base_url('company') ?>">Companies</a>
        <a href="<?= base_url('events') ?>">Events</a>
        <a href="<?= base_url('layout-info') ?>">Layout</a>
        <a href="<?= base_url('company/add') ?>">Add Companies</a>
        <a href="<?= base_url('leads') ?>">Leads</a>
        <a href="<?= base_url('crossvalidation') ?>">Crossvalidation</a>
        <a href="<?= site_url('booking/exhibitor_booking') ?>">Exhibitor Booking</a>
        <a href="<?= site_url('booking/view') ?>">View Booking</a>
    </div>

    <!-- Search box -->
    <div class="search-box">
        <form action="<?= base_url('search') ?>" method="get">
            <input type="text" name="q" placeholder="Search..." required>
            <button type="submit">Search</button>
        </form>
    </div>
</nav>

<div class="content">
