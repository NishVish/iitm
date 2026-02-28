
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
// var_dump($server);
// // Print all session data in a readable way
// echo "<pre>";
// echo "Current Segment: $currentSegment\n";
// echo "User ID: $user_id\n";
// echo "Employee ID: $employee_id\n";
// echo "Name: $name\n";
// echo "Designation: $designation\n";
// echo "Phone: $phone\n";
// echo "Address: $address\n";
// echo "Email: $email\n";
// echo "Category: $category\n";
// echo "Department: $department\n";
// echo "Date of Joining: $doj\n";
// echo "UAN No: $uan_no\n";
// echo "Father's Name: $fathers_name\n";
// echo "Aadhaar Card: $aadhaar_card\n";
// echo "PAN Card: $pan_card\n";
// echo "Bank Account Number: $bank_account_number\n";
// echo "IFSC Code: $ifsc_code\n";
// echo "User Type: $user_type\n";
// echo "Journal: $journal\n";
// echo "Database Server: $server\n";
// echo "</pre>";

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
}
    /* 
    
    background-color: var(--nav-color); 
    background-color: var(--body-color); 
    background-color: var(--button-color); 
    
    
    
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
    color: black;
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


    </div>
    <!-- Search box -->
 <div>
    
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


        /* Search box styling */
        .search-box input[type="text"] { 
            padding: 6px 10px; 
            border-radius: 8px; 
            border: none; 
            outline: none;
            width: 70%;
            transition: all 0.3s ease;
        }

        .search-box input[type="text"]:focus {
            box-shadow: 0 0 8px rgba(168, 35, 36, 0.7); /* glow effect in red palette */
        }

        .search-box button { 
            padding: 6px 5%; 
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
</style>

<div class="wrapper">
    <!-- Sidebar -->

<style>
    .active {
    font-weight: bold;
    color: #007bff;
}

</style>

<!-- <div id="bottomBar">
    <div id="circle"></div>
</div> -->

<style>
:root {
    --nav-color: #1a1a1a;
    --button-color: #ffffff; /* Added default white */
}

#bottomBar {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 35px;
    background-color: var(--nav-color);
    z-index: 1000;
    overflow: hidden;
}

#circle {
    position: absolute;
    top: 50%;
    /* Remove default left: 50% to prevent jumping */
    background-color: var(--button-color);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    pointer-events: none;
    opacity: 0;
    
    /* Removed width/height transition for instant JS tracking */
    transition: opacity 0.3s ease; 
    
    filter: blur(12px); /* Increased blur for a smoother 90% look */
    
    animation: breathe 2s infinite ease-in-out;
}

@keyframes breathe {
    0%, 100% { transform: translate(-50%, -50%) scale(0.98); }
    50% { transform: translate(-50%, -50%) scale(1.02); }
}
</style>

<script>
const circle = document.getElementById('circle');
const bottomBar = document.getElementById('bottomBar');

document.addEventListener('mousemove', (e) => {
    const mouseX = e.clientX;
    const mouseY = e.clientY;
    const barRect = bottomBar.getBoundingClientRect();

    // Max distance changed to 600 to detect mouse from further up the page
    const maxDistance = 600; 
    const distanceFromBar = barRect.top - mouseY;

    // Detect if mouse is within vertical range (even if very far away)
    if (distanceFromBar < maxDistance && mouseY < barRect.bottom) {
        // Move circle instantly to mouse X
        circle.style.left = `${mouseX}px`;

        // Calculate proximity (0 to 1)
        // Ensure proximity stays 0 if distance is greater than maxDistance
        const proximity = Math.max(0, (maxDistance - Math.max(0, distanceFromBar)) / maxDistance);

        // Calculate size: 100px when far, 90vw when close
        const minSize = 100;
        const maxSize = window.innerWidth * 0.9;
        const currentSize = minSize + (proximity * (maxSize - minSize));

        circle.style.width = `${currentSize}px`;
        circle.style.height = `${currentSize}px`;

        // Fade in based on proximity
        // Only show if distance is positive (above the bar)
        circle.style.opacity = proximity > 0.01 ? (0.1 + (proximity * 0.9)) : 0;
        
    } else {
        // Instant hide when out of range
        circle.style.opacity = "0";
    }
});
</script>

<?php
$session = session();

$user_id     = $session->get('user_id');
$name        = ucfirst(strtolower($session->get('name')));
$department  = $session->get('department');
?>
<div id="ticketModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><span class="header-icon">+</span> Create New Ticket</h3>
            <span class="close-btn" onclick="closeModal()">&times;</span>
        </div>

        <form method="post" action="<?= base_url('ticket/store') ?>" class="ticket-form" id="form">
            <?= csrf_field() ?>

            <div class="form-row full">
                <label>Parent Ticket (Search ID or Title)</label>
                <input type="text" list="ticket-list" id="parent_search" placeholder="Search ID or Title..." value="<?=$currentSegment?>" autocomplete="off">
                <input type="hidden" name="parent_id" id="parent_id_hidden" value="0">
                <datalist id="ticket-list">
                    <option data-id="0" data-level="0" value="None (Main Ticket)"></option>
                    <?php if(isset($tickets) && is_array($tickets)): ?>
                        <?php foreach($tickets as $ticket): ?>
                            <option data-id="<?= $ticket['id'] ?>" data-level="<?= $ticket['task_level'] ?>" value="#<?= $ticket['id'] ?> - <?= esc($ticket['title']) ?>"></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </datalist>
            </div>

            <div class="form-grid">
                <div class="form-row">
                    <label>Assign To User *</label>
                    <select name="user_id" required>
                        <option value="<?= $user_id ?>" selected><?= esc($name) ?> (self)</option>
                        <?php if(isset($users)): foreach($users as $user): if($user['id'] != $user_id): ?>
                            <option value="<?= $user['id'] ?>"><?= esc($user['name']) ?></option>
                        <?php endif; endforeach; endif; ?>
                    </select>
                </div>

                <div class="form-row">
                    <label>Task Level</label>
                    <select name="task_level" id="task_level_select">
                        <option value="0" selected>Head</option>
                        <option value="1">Level 2</option>
                        <option value="2">Level 3</option>
                        <option value="3">Level 4</option>
                        <option value="4">Level 5</option>
                    </select>
                </div>

                <div class="form-row">
                    <label>Type</label>
                    <select name="ticket_type">
                        <option value="Task">Task</option>
                        <option value="Issue">Issue</option>
                        <option value="Update">Update</option>
                    </select>
                </div>

                <div class="form-row">
                    <label>Department</label>
                    <input type="text" name="department" placeholder="e.g. Sales">
                </div>

                <div class="form-row">
                    <label>Priority</label>
                    <select name="priority">
                        <option value="Low">Low</option>
                        <option value="Medium" selected>Medium</option>
                        <option value="High">High</option>
                        <option value="Urgent">Urgent</option>
                    </select>
                </div>

                <div class="form-row">
                    <label>Status</label>
                    <select name="status">
                        <option value="Open" selected>Open</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Resolved">Resolved</option>
                    </select>
                </div>
            </div>

            <div class="form-row full">
                <label>Description *</label>
                <textarea name="description" rows="3" required placeholder="Details about this ticket..."></textarea>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn-submit">Create Ticket</button>
            </div>
        </form>
    </div>
</div>

<style>
/* Variables Integrated */
:root {
    --modal-primary: var(--nav-color, #007bff);
    --modal-bg: #ffffff;
    --modal-border: #e2e8f0;
}

/* Modal Overlay */
.modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0; top: 0;
    width: 100%; height: 100%;
    background-color: rgba(15, 23, 42, 0.6); /* Slightly darker slate overlay */
    backdrop-filter: blur(4px);
}

/* Modal Content Box */
.modal-content {
    background: var(--modal-bg);
    width: 650px;
    max-width: 95%;
    margin: 40px auto;
    border-radius: 12px;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    overflow: hidden;
    animation: slideIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

/* Header Styling */
.modal-header {
    padding: 16px 24px;
    background: #f8fafc;
    border-bottom: 1px solid var(--modal-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h3 { margin: 0; font-size: 1.15rem; color: #1e293b; font-weight: 600; }
.header-icon { color: var(--modal-primary); margin-right: 8px; font-weight: bold; }

.close-btn { 
    font-size: 24px; color: #94a3b8; cursor: pointer; transition: 0.2s; 
}
.close-btn:hover { color: #1e293b; }

/* Form Elements */
.ticket-form { padding: 24px; }

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
    margin-bottom: 16px;
}

.form-row { display: flex; flex-direction: column; margin-bottom: 16px; }
.form-row.full { grid-column: span 2; }

.form-row label {
    font-size: 0.85rem;
    font-weight: 600;
    color: #475569;
    margin-bottom: 6px;
}

.form-row input, .form-row select, .form-row textarea {
    padding: 10px 12px;
    border: 1px solid var(--modal-border);
    border-radius: 6px;
    font-size: 0.95rem;
    color: #1e293b;
    transition: all 0.2s;
}

.form-row input:focus, .form-row select:focus, .form-row textarea:focus {
    border-color: var(--modal-primary);
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    outline: none;
}

/* Footer & Buttons */
.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 10px;
}

.btn-submit {
    background: var(--modal-primary);
    color: #ffffff;
    border: none;
    padding: 12px 24px;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    transition: filter 0.2s;
}

.btn-cancel {
    background: #f1f5f9;
    color: #475569;
    border: none;
    padding: 12px 24px;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
}

.btn-submit:hover { filter: brightness(90%); }
.btn-cancel:hover { background: #e2e8f0; }

/* Animations */
@keyframes slideIn {
    from { transform: translateY(-20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
</style>

<script>
function openModal() {
    document.getElementById("ticketModal").style.display = "block";
}

function closeModal() {
    document.getElementById("ticketModal").style.display = "none";
}

// Close when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById("ticketModal");
    if (event.target === modal) {
        modal.style.display = "none";
    }
}
</script>




<div class="sidebar">


<div class="search-box">
    <form action="<?= base_url('search') ?>" method="get">
        <input type="text" name="q" placeholder="Search..." required>
        <button type="submit">🔍</button>
    </form>
</div>
<div class="ticket-container">
    <button type="button" class="btn-compact" onclick="openModal()">
        <span class="plus-icon">+</span> Ticket
    </button>

    <a href="<?= site_url('tools') ?>" class="btn-compact">
        Tools
    </a>
</div>

<style>
    .ticket-container {
        width: 100%;
        padding-top: 15px;
        display: flex;
        gap: 8px;
        /* Ensures both children stretch to the same height */
        align-items: stretch; 
    }

    .btn-compact {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        
        /* Fixed sizing for perfect symmetry */
        height: 34px; /* Explicit height for identical look */
        padding: 0 5px; /* Horizontal padding only */
        box-sizing: border-box; /* Includes border/padding in height calculation */
        
        /* Aesthetic */
        background-color: var(--button-color); 
        color: #ffffff !important;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        
        /* Shape */
        border: none;
        border-radius: 4px;
        cursor: pointer;
        white-space: nowrap;
        
        /* Interactions */
        transition: opacity 0.2s ease, transform 0.1s ease;
    }

    .btn-tools {
        background-color: #6c757d;
    }

    .btn-compact:hover {
        opacity: 0.9; 
    }

    .btn-compact:active {
        transform: scale(0.96);
    }

    .plus-icon {
        font-size: 1rem;
        /* Helps center the icon vertically with text */
        display: inline-flex;
        align-items: center;
        height: 100%;
    }
</style>

<style>
    .submenu{
        text-align:center;
        padding-top:20px;
    }
</style>
