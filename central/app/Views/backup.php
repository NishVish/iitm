
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
    <title>Company Management System</title>
    <style>

        :root {
    --nav-color: #a82324;
    --body-color: #f8f4f4;
    --button-color: #a82324;
    --text-color: #a82324;
}
    /* 
    
    background-color: var(--nav-color); 
    background-color: var(--body-color); 
    background-color: var(--button-color); 
    background-color: var(--text-color); 
    
    
    
    */

.content {
    max-width: 150vh;;
    margin: 0 auto;
    padding: 20px;
    box-sizing: border-box;
}

#spreadsheet,#Spreadsheet,.Spreadsheet {
        /* Set width to 150% of the viewport height */
        width: 150vh; 
        max-width: 100%; /* Prevents it from breaking mobile layouts if 150vh is too wide */
        overflow-x: auto; /* Enables horizontal scrolling */
        overflow-y: auto;
        border: 1px solid #ccc;
        background: #fff;
        margin-bottom: 10px;
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
            color: var(--text-color); ; 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        nav a { 
            color: var(--text-color); ; 
            margin-right: 20px; 
            text-decoration: none; 
            font-weight: 500;
            transition: all 0.3s ease;
        }

        nav a:hover { 
            text-decoration: underline;
            color: #ffb3b3; /* light pink hover for contrast */
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
        color: black;            /* text color */

}

.theme-header {
    background: #a82324;
    color: var(--text-color); ;
    padding: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-radius: 10px 10px 0 0;
}

.theme-header button {
    background: none;
    border: none;
    color: var(--text-color); ;
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
    color: var(--text-color); ;
    cursor: pointer;
    transition: 0.3s;
}

.reset-btn:hover {
    background: #222;
}

.theme-window .quick-content {
    color: black;            /* text color */
    display: flex;           /* enable flex layout */
    flex-direction: column;  /* stack items vertically */
    gap: 8px;                /* space between links */
    padding: 10px 15px;      /* some padding for breathing room */
}

.theme-window .quick-content a {
    color: black;            /* ensure links are black */
    text-decoration: none;   /* remove underline */
    font-weight: 500;        /* optional: make links slightly bold */
}

.theme-window .quick-content a:hover {
    text-decoration: underline;  /* subtle hover effect */
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

    </style>


<!-- Excel Module -->

<script>
<?= view('excelmodule/js/main') ?>  

</script>

<style>
<?= view('excelmodule/style/main') ?>  


</style>


    
</head>
<body>

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
<nav>
    <div class="nav-links">
        <!-- <a href="<?= base_url('') ?>">Login</a> -->
        <a href="<?= base_url('home') ?>">Home</a>

        <!-- Backend dropdown -->
            <a href="<?= base_url('backend') ?>" class="dropbtn">Backend</a>
            

        <!-- Companies dropdown -->
            <a href="<?= base_url('company') ?>">Database</a>
            

        <a href="<?= base_url('events') ?>">Events</a>
        <a href="<?= base_url('layout-info') ?>">Layout</a>
        <a href="<?= base_url('leads') ?>">Leads</a>
        <a href="<?= base_url('crossvalidation') ?>">Crossvalidation</a>
        <!-- <a href="<?= site_url('booking/exhibitor_booking') ?>">Exhibitor Booking</a> -->
        <!-- <a href="<?= site_url('booking/view') ?>">View Booking</a> -->
        <a href="<?= site_url('ticket') ?>">Ticket</a>
        <a href="<?= site_url('registration') ?>">Registration</a>
        <a href="http://localhost/phpmyadmin/index.php">MyPhpAdmin</a>
    
<a href="#"><?= esc($server) ?></a>


</div>


    <button id="openTheme" style="margin-left:15px;padding:6px 10px;border:none;border-radius:6px;cursor:pointer;">

<?php if ($session->get('authenticated')): ?>
        <?= htmlspecialchars($session->get('name')) ?>!
    <?php else: ?>
        
<script>
        window.location.href = "<?= base_url('/') ?>";
    </script>
    <?php endif; ?>
    
    ⚙️</button>
       

 </div>



<div id="themeWindow" class="theme-window">

    <div class="theme-header">
        <span>Settings</span>
        <button id="closeTheme">✖</button>
    </div>

    <div class="quick-content">
        <a href="<?= site_url('logout') ?>">Logout</a>
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
</nav>
<!-- Theme Popup -->



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

<div class="wrapper">
    <!-- Sidebar -->
<?= view('sidemenu')?>
