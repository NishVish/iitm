<!-- Navigation with search -->


<style>
/* Dropdown container */
.dropdown {
    position: relative;
    display: inline-block;
}

/* Dropdown button */
.dropbtn {
    text-decoration: none;
    color: white; /* match navbar text */
    transition: all 0.3s ease;
}

/* Dropdown content (hidden by default) */
.dropdown-content {
    display: none;
    position: absolute;
    background-color: var(--nav-color); /* match navbar */
    border-radius: 6px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    z-index: 1;
        width: 150%;

    
}

/* Links inside dropdown */
.dropdown-content a {
    display: block;
        width: 100%;

    color: white; /* white text for contrast */
    text-decoration: none;
    transition: background 0.3s ease;
}

/* Hover effect for dropdown links */
.dropdown-content a:hover {
    background-color: #8f8686; /* darker shade of nav color */
}

/* Show dropdown on hover */
.dropdown:hover .dropdown-content {
    display: block;
}
</style>
<!-- Navigation with search -->
 
<script>
document.addEventListener("DOMContentLoaded", function () {

    const navPicker = document.getElementById("navColor");
    const bodyPicker = document.getElementById("bodyColor");
    const buttonPicker = document.getElementById("buttonColor");

    const themeWindow = document.getElementById("themeWindow");
    const openBtn = document.getElementById("openTheme");
    const closeBtn = document.getElementById("closeTheme");
    const resetBtn = document.getElementById("resetTheme");

    const defaultNav = "#a82324";
    const defaultBody = "#f8f4f4";
    const defaultButton = "#a82324";

    // Open / Close
    openBtn.onclick = () => themeWindow.style.display = "block";
    closeBtn.onclick = () => themeWindow.style.display = "none";

    // Load saved colors
    const savedNav = localStorage.getItem("navColor");
    const savedBody = localStorage.getItem("bodyColor");
    const savedButton = localStorage.getItem("buttonColor");

    if (savedNav) {
        document.documentElement.style.setProperty('--nav-color', savedNav);
        navPicker.value = savedNav;
    }

    if (savedBody) {
        document.documentElement.style.setProperty('--body-color', savedBody);
        bodyPicker.value = savedBody;
    }

    if (savedButton) {
        document.documentElement.style.setProperty('--button-color', savedButton);
        buttonPicker.value = savedButton;
    }

    // Change events
    navPicker.addEventListener("input", function () {
        document.documentElement.style.setProperty('--nav-color', this.value);
        localStorage.setItem("navColor", this.value);
    });

    bodyPicker.addEventListener("input", function () {
        document.documentElement.style.setProperty('--body-color', this.value);
        localStorage.setItem("bodyColor", this.value);
    });

    buttonPicker.addEventListener("input", function () {
        document.documentElement.style.setProperty('--button-color', this.value);
        localStorage.setItem("buttonColor", this.value);
    });

    // Reset button
    resetBtn.addEventListener("click", function () {

        document.documentElement.style.setProperty('--nav-color', defaultNav);
        document.documentElement.style.setProperty('--body-color', defaultBody);
        document.documentElement.style.setProperty('--button-color', defaultButton);

        localStorage.removeItem("navColor");
        localStorage.removeItem("bodyColor");
        localStorage.removeItem("buttonColor");

        navPicker.value = defaultNav;
        bodyPicker.value = defaultBody;
        buttonPicker.value = defaultButton;

        themeWindow.style.display = "none";
    });

});
</script>

<style>
/* Flex container for sidebar + main content */
.wrapper {
    display: flex;
    min-height: 100vh; /* full viewport height */
}

/* Left sidebar styling */
.sidebar {
    width: 220px;
    background-color: var(--nav-color);
    color: #fff;
    padding: 20px;
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
    flex-shrink: 0;
}

.sidebar h3 {
    margin-top: 0;
    font-size: 18px;
    margin-bottom: 15px;
}

.sidebar a {
    display: block;
    color: white;
    text-decoration: none;
    margin-bottom: 10px;
    padding: 8px 12px;
    border-radius: 6px;
    transition: 0.3s;
}

.sidebar a:hover {
    background-color: #8b1d20;
}

/* Main content area */
.content {
    flex-grow: 1;
    padding: 20px;
    background-color: var(--body-color);
}
.sidebar {
    position: sticky;
    top: 50px; /* leave space for the nav */
    height: calc(100vh - 60px); /* full viewport height minus nav */
    overflow-y: auto; /* scroll if content exceeds height */
}

/* Responsive: collapse sidebar on small screens */
@media(max-width: 768px){
    .wrapper {
        flex-direction: column;
    }
    .sidebar {
        width: 100%;
    }
}
</style>
<style>

        :root {
    --nav-color: #a82324;
    --body-color: #f8f4f4;
    --button-color: #a82324;
}



        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
    background-color: var(--body-color);
    
        }
nav {
    position: sticky; /* or 'fixed' */
    top: 0;
    z-index: 1000; /* stay above content */
}

        /* Navigation bar */
        nav { 
            
    background: var(--nav-color);
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
    background: var(--button-color);
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
        .color-controls {
    padding: 15px;
    background: #fff;
    display: flex;
    gap: 15px;
    align-items: center;
    flex-wrap: wrap;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.color-controls label {
    font-size: 14px;
}
/* Theme Popup Window */
.theme-window {
    position: fixed;
    top: 80px;
    right: 20px;
    width: 260px;
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    display: none;
    z-index: 999;
    animation: fadeIn 0.3s ease;
}

.theme-header {
    background: #a82324;
    color: #fff;
    padding: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-radius: 10px 10px 0 0;
}

.theme-header button {
    background: none;
    border: none;
    color: white;
    cursor: pointer;
    font-size: 14px;
}

.theme-body {
    padding: 15px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.theme-body input[type="color"] {
    width: 100%;
    height: 35px;
    border: none;
    cursor: pointer;
}

.reset-btn {
    margin-top: 10px;
    padding: 8px;
    border: none;
    border-radius: 6px;
    background: #444;
    color: white;
    cursor: pointer;
    transition: 0.3s;
}

.reset-btn:hover {
    background: #222;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

    </style>
<nav>
    <div class="nav-links">
        <a href="<?= base_url('') ?>">Login</a>
        <a href="<?= base_url('index.php/login') ?>">Home</a>

        <!-- Backend dropdown -->
        <div class="dropdown">
            <a href="<?= base_url('backend') ?>" class="dropbtn">Backend</a>
            <div class="dropdown-content">
                <a href="<?= base_url('plan') ?>">Plan  </a>
                        <a href="<?= base_url('games') ?>">Play Games</a>
                        <a href="<?= base_url('tv') ?>"> TV</a>

                <!-- You can add more backend links here -->
            </div>
        </div>

        <!-- Companies dropdown -->
        <div class="dropdown">
            <a href="<?= base_url('company') ?>">Companies</a>
            <div class="dropdown-content">
                <a href="<?= base_url('company') ?>">View Companies</a>
                <a href="<?= base_url('company/add') ?>">Add Companies</a>
            </div>
        </div>

        <a href="<?= base_url('events') ?>">Events</a>
        <a href="<?= base_url('layout-info') ?>">Layout</a>
        <a href="<?= base_url('leads') ?>">Leads</a>
        <a href="<?= base_url('crossvalidation') ?>">Crossvalidation</a>
        <a href="<?= site_url('booking/exhibitor_booking') ?>">Exhibitor Booking</a>
        <a href="<?= site_url('booking/view') ?>">View Booking</a>
        <a href="http://localhost/phpmyadmin/index.php">MyPhpAdmin</a>
    </div>


    </div>
    <!-- Search box -->
    <div class="search-box">
        <form action="<?= base_url('search') ?>" method="get">
            <input type="text" name="q" placeholder="Search..." required>
            <button type="submit">Search</button>
        </form>
    </div>
    <button id="openTheme" style="margin-left:15px;padding:6px 10px;border:none;border-radius:6px;cursor:pointer;">
⚙️</button>

</nav>
<!-- Theme Popup -->
<div id="themeWindow" class="theme-window">
    <div class="theme-header">
        <span>Theme Settings</span>
        <button id="closeTheme">✖</button>
    </div>

    <div class="theme-body">
        <label>Navbar Color</label>
        <input type="color" id="navColor" value="#a82324">

        <label>Body Background</label>
        <input type="color" id="bodyColor" value="#f8f4f4">

        <label>Button Color</label>
        <input type="color" id="buttonColor" value="#a82324">

        <button id="resetTheme" class="reset-btn">Reset to Default</button>
    </div>
</div>
<!-- Theme Popup -->
<div id="themeWindow" class="theme-window">
    <div class="theme-header">
        <span>Theme Settings</span>
        <button id="closeTheme">✖</button>
    </div>

    <div class="theme-body">
        <label>Navbar Color</label>
        <input type="color" id="navColor" value="#a82324">

        <label>Body Background</label>
        <input type="color" id="bodyColor" value="#f8f4f4">

        <label>Button Color</label>
        <input type="color" id="buttonColor" value="#a82324">

        <button id="resetTheme" class="reset-btn">Reset to Default</button>
    </div>
</div>


<div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="<?= base_url('') ?>">Login</a>
        <a href="<?= base_url('index.php/login') ?>">Home</a>
        <a href="<?= base_url('company') ?>">Companies</a>
        <a href="<?= base_url('company/add') ?>">Add Company</a>
        <a href="<?= base_url('events') ?>">Events</a>
        <a href="<?= base_url('leads') ?>">Leads</a>
        <a href="<?= base_url('crossvalidation') ?>">Crossvalidation</a>
        <a href="<?= site_url('booking/exhibitor_booking') ?>">Exhibitor Booking</a>
        <a href="<?= site_url('booking/view') ?>">View Booking</a>
</div>