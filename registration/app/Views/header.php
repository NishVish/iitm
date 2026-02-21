<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern CMS Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --nav-color: #a82324;
            --body-color: #f8fafc;
            --button-color: #a82324;
            --card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        * { box-sizing: border-box; }

        body { 
            font-family: 'Inter', sans-serif; 
            margin: 0; 
            background-color: var(--body-color);
            color: #1e293b;
            transition: background 0.3s ease;
        }

        /* --- NAVIGATION --- */
        nav { 
            position: sticky;
            top: 0;
            z-index: 1000;
            background: var(--nav-color);
            padding: 0 2rem;
            height: 60px;
            display: flex; 
            align-items: center; 
            /* This distributes space so the middle stays middle */
            justify-content: space-between; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        /* Create a placeholder to balance the right-side button */
        nav::before {
            content: "";
            flex: 1;
        }

        .nav-links {
            display: flex;
            justify-content: center;
            flex: 2; /* Takes up the middle space */
        }

        .nav-links a { 
            color: rgba(255,255,255,0.8); 
            margin: 0 1rem; 
            text-decoration: none; 
            font-weight: 500;
            font-size: 0.9rem;
            transition: 0.2s;
            white-space: nowrap;
        }

        .nav-links a:hover { color: white; }

        .nav-actions {
            flex: 1;
            display: flex;
            justify-content: flex-end;
        }

        #openTheme {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.2);
            color: white;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            backdrop-filter: blur(5px);
        }

        /* --- LAYOUT WRAPPER --- */
        .wrapper { display: flex; min-height: calc(100vh - 60px); }

        .sidebar {
            width: 260px;
            background: white;
            padding: 2rem 1rem;
            border-right: 1px solid #e2e8f0;
            flex-shrink: 0;
        }

        .sidebar h3 { font-size: 0.75rem; text-transform: uppercase; color: #94a3b8; letter-spacing: 0.05em; margin-bottom: 1rem; padding-left: 1rem; }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 12px 1rem;
            color: #475569;
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 4px;
            font-weight: 500;
            transition: 0.2s;
        }

        .sidebar a:hover { background: #f1f5f9; color: var(--nav-color); transform: translateX(4px); }

        .content { flex-grow: 1; padding: 2.5rem; }

        /* --- TABLE --- */
        .table-card {
            background: white;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        table { width: 100%; border-collapse: collapse; }
        th { background: #f8fafc; text-align: left; padding: 1rem; font-size: 0.75rem; text-transform: uppercase; color: #64748b; border-bottom: 1px solid #e2e8f0; }
        td { padding: 0; border-bottom: 1px solid #f1f5f9; vertical-align: top; }

        .desc-container { position: relative; width: 100%; height: 100%; }
        .desc-view { padding: 1rem; cursor: pointer; min-height: 80px; font-size: 0.9rem; color: #475569; line-height: 1.5; }
        .desc-edit { display: none; width: 100%; border: 2px solid var(--nav-color); padding: 1rem; font-family: inherit; font-size: 0.9rem; line-height: 1.5; resize: none; overflow: hidden; outline: none; background: #fff; }

        /* --- THEME POPUP --- */
        .theme-window {
            position: fixed; top: 70px; right: 20px; width: 280px;
            background: rgba(255,255,255,0.9); backdrop-filter: blur(10px);
            border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
            display: none; z-index: 2000; border: 1px solid rgba(255,255,255,0.5);
        }
        .theme-header { background: var(--nav-color); color: white; padding: 1rem; border-radius: 16px 16px 0 0; display: flex; justify-content: space-between; }
        .theme-body { padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem; }
        input[type="color"] { width: 100%; height: 40px; border: none; border-radius: 8px; cursor: pointer; }

        .btn-update {
            background: var(--nav-color); color: white; border: none;
            padding: 8px 16px; border-radius: 8px; cursor: pointer; font-weight: 600; margin: 10px;
        }
    </style>
</head>
<body>

<nav id="topNav">
    <div class="nav-links">
        <a href="#">🏠 Dashboard</a>
        <a href="#">Companies</a>
        <a href="#">Issues</a>
        <a href="#">Settings</a>
    </div>
    <div class="nav-actions">
        <button id="openTheme">⚙️ Theme</button>
    </div>
</nav>

<div class="wrapper">
    <aside class="sidebar">



    <h3>Main Menu</h3>
    <a href="#">
        <span class="icon">📊</span> Dashboard
    </a>
    <a href="#">
        <span class="icon">👥</span> User Management
    </a>
    <a href="#">
        <span class="icon">📜</span> System Logs
    </a>
    <a href="#">
        <span class="icon">🗄️</span> Database
    </a>
    <hr class="sidebar-divider">

        <h3>Data Actions</h3>
    <a href="#" class="action-link">
        <span class="icon">👁️</span> View Data
    </a>
    <a href="#" class="action-link">
        <span class="icon">📥</span> Export Data
    </a>


</aside>
    <main class="content">











       


<div id="themeWindow" class="theme-window">
    <div class="theme-header">
        <span>UI Customizer</span>
        <button id="closeTheme" style="background:none; border:none; color:white; cursor:pointer;">✕</button>
    </div>
    <div class="theme-body">
        <label style="font-size: 12px; font-weight: 600; color: #64748b;">ACCENT COLOR</label>
        <input type="color" id="navPicker" value="#a82324">
        
        <label style="font-size: 12px; font-weight: 600; color: #64748b;">BACKGROUND</label>
        <input type="color" id="bodyPicker" value="#f8fafc">
        
        <button id="resetTheme" style="padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0; background: white; cursor: pointer;">Reset to Default</button>
    </div>
</div>

<script>
    const themeWin = document.getElementById('themeWindow');
    const navPicker = document.getElementById('navPicker');
    const bodyPicker = document.getElementById('bodyPicker');

    document.getElementById('openTheme').onclick = () => themeWin.style.display = 'block';
    document.getElementById('closeTheme').onclick = () => themeWin.style.display = 'none';

    navPicker.oninput = (e) => {
        document.documentElement.style.setProperty('--nav-color', e.target.value);
    };
    bodyPicker.oninput = (e) => {
        document.documentElement.style.setProperty('--body-color', e.target.value);
    };

    function enableEdit(viewDiv) {
        const container = viewDiv.parentElement;
        const textarea = container.querySelector('.desc-edit');
        viewDiv.style.display = 'none';
        textarea.style.display = 'block';
        autoExpand(textarea);
        textarea.focus();
    }

    function disableEdit(textarea) {
        // Optional hide logic
    }

    function autoExpand(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    }
</script>
