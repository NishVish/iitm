<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IITM | Backend Administration</title>

    <style>
        :root {
            --iitm-maroon: #800000;
            /* Traditional IITM Maroon */
            --iitm-gold: #c5a059;
            /* Accent Gold */
            --iitm-dark: #2d2d2d;
            --iitm-light: #f4f4f4;
        }

        body {
            margin: 0;
            font-family: 'Times New Roman', serif;
            /* More academic feel */
            background-color: var(--iitm-light);
            color: var(--iitm-dark);
        }

        /* --- Header / Navbar --- */
        .navbar {
            background: var(--iitm-maroon);
            padding: 0 20px;
            display: flex;
            align-items: center;
            height: 70px;
            border-bottom: 4px solid var(--iitm-gold);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .brand {
            font-weight: bold;
            color: white;
            font-size: 1.5rem;
            margin-right: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-right: 1px solid rgba(255, 255, 255, 0.3);
            padding-right: 20px;
        }

        .nav-links {
            display: flex;
            gap: 10px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            font-size: 0.95rem;
            font-family: Arial, sans-serif;
            transition: 0.3s;
        }

        .navbar a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: var(--iitm-gold);
        }

        /* --- Search Bar --- */
        .search-box {
            margin-left: auto;
            display: flex;
        }

        .search-box input {
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 4px 0 0 4px;
            outline: none;
            width: 200px;
        }

        .search-box button {
            padding: 8px 15px;
            border: none;
            background: var(--iitm-gold);
            color: white;
            font-weight: bold;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
        }

        .search-box button:hover {
            background: #b08d4a;
        }

        /* --- Main Content --- */
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        }

        h2 {
            color: var(--iitm-maroon);
            border-bottom: 2px solid var(--iitm-maroon);
            padding-bottom: 10px;
            font-size: 1.8rem;
        }

        .box {
            background: #fffdf9;
            /* Slight parchment feel */
            padding: 20px;
            margin-top: 25px;
            border-left: 5px solid var(--iitm-maroon);
            border-right: 1px solid #ddd;
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
        }

        .session-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: bold;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-error {
            background: #fee2e2;
            color: #991b1b;
        }

        pre {
            background: #2d2d2d;
            color: #51ff00;
            /* Terminal look for data */
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>

    <div class="navbar">
        <div class="brand">IITM</div>

        <div class="nav-links">
            <a href="{{ url('/backend/home') }}">HOME</a>
            <a href="{{ url('/backend/leads') }}">LEADS</a>
            <a href="{{ url('/backend/search') }}">SEARCH</a>
            <a href="{{ url('/backend/exhibitors') }}">EXHIBITORS</a>
            <a href="{{ url('/backend/activity') }}">ACTIVITY</a>
        </div>
        <div style="margin-left:auto; display:flex; align-items:center; gap:10px;">

            <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <button type="submit" class="logout-btn">LOGOUT</button>
            </form>
        </div>
    </div>