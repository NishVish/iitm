<?php
// header.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Company Management System</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; }
        nav { background-color: #2c3e50; padding: 10px; color: white; display: flex; align-items: center; justify-content: space-between; }
        nav a { color: white; margin-right: 15px; text-decoration: none; }
        nav a:hover { text-decoration: underline; }
        .content { padding: 20px; }
        .search-box input[type="text"] { padding: 5px; border-radius: 3px; border: none; }
        .search-box button { padding: 5px 10px; border: none; border-radius: 3px; background-color: #3498db; color: white; cursor: pointer; }
        .search-box button:hover { background-color: #2980b9; }
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
        <a href="<?= base_url('dashboard') ?>">Dashboard</a>
        <a href="<?= base_url('events') ?>">Events</a>
        <a href="<?= base_url('layout-info') ?>">Layout</a>
        <a href="<?= base_url('company/add') ?>">Add Companies</a>

        <a href="<?= base_url('leads') ?>">Leads</a>
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
