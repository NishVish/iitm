<?php
$uri = service('uri');
$currentSegment = $uri->getSegment(1); // Gets the first segment

$session = session();

$user_id = $session->get('user_id');
$employee_id = $session->get('employee_id');
$name = ucfirst(strtolower($session->get('name')));
$designation = $session->get('designation');
$phone = $session->get('phone');
$address = $session->get('address');
$email = $session->get('email');
$category = $session->get('category');
$department = $session->get('department');
$doj = $session->get('doj');
$uan_no = $session->get('uan_no');
$fathers_name = $session->get('fathers_name');
$aadhaar_card = $session->get('aadhaar_card');
$pan_card = $session->get('pan_card');
$bank_account_number = $session->get('bank_account_number');
$ifsc_code = $session->get('ifsc_code');
$user_type = $session->get('user_type');
$journal = $session->get('journal') ?? '';
$server = $session->get('server') ?? '';


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
            /* Main colors */
            --nav-color: #a82324;
            --nav-color-dim: #c45a5b;

            --body-color: #f8f4f4;
            --body-color-dim: #fbf9f9;

            --button-color: #a82324;
            --button-color-dim: #c45a5b;

            --text-color: #ffffff;
            --text-color-dim: #dcdcdc;
        }

        /* var(--body-color)
  var(--body-color)
   var(--body-color)
    var(--body-color) */

        /* General content */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: var(--body-color);
        }

        .content {
            max-width: 150vh;
            margin: 0 auto;
            padding: 20px;
            box-sizing: border-box;
        }

        /* Spreadsheet container */
        #spreadsheet,
        #Spreadsheet,
        .Spreadsheet {
            width: 150vh;
            max-width: 100%;
            overflow-x: auto;
            overflow-y: auto;
            border: 1px solid var(--body-color-dim);
            /* fixed from --border-dim */
            background: var(--text-color);
            margin-bottom: 10px;
        }

        /* Navigation */
        nav {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: var(--nav-color);
            padding: 12px 20px;
            color: var(--text-dim);
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        nav a {
            color: var(--text-color);
            margin-right: 20px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        nav a:hover {
            color: var(--body-color);
            /* replaced non-existing --text-nav-dim */
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

        /* Theme popup */
        .theme-window {
            position: fixed;
            top: 80px;
            right: 20px;
            width: 260px;
            background: var(--nav-color);
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            display: none;
            z-index: 999;
            animation: fadeIn 0.3s ease;
            color: var(--text-color);
        }

        .theme-header {
            background: var(--nav-color-dim);
            color: var(--text-color);
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 10px 10px 0 0;
        }

        .theme-header button {
            background: none;
            border: none;
            color: var(--text-color-dim);
            /* fixed from --text-dim */
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

        /* Reset button */
        .reset-btn {
            margin-top: 10px;
            padding: 8px;
            border: none;
            border-radius: 6px;
            background: var(--button-color);
            color: var(--text-color);
            cursor: pointer;
            transition: 0.3s;
        }

        .reset-btn:hover {
            background: var(--button-color-dim);
        }

        /* Quick links inside theme popup */
        .theme-window .quick-content {
            color: var(--text-color);
            display: flex;
            flex-direction: column;
            gap: 8px;
            padding: 10px 15px;
        }

        .theme-window .quick-content a {
            color: var(--text-color);
            text-decoration: none;
            font-weight: 500;
        }

        .theme-window .quick-content a:hover {
            color: var(--text-color);
            text-decoration: underline;
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        < !-- Excel Module --><script>
        <?= view('excelmodule/js/main') ?>

        </script><style>
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
            color: white;
            /* match navbar text */
            transition: all 0.3s ease;
        }

        /* Dropdown content (hidden by default) */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: var(--nav-color);
            /* match navbar */
            border-radius: 6px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            z-index: 1;
            width: 150%;


        }

        /* Links inside dropdown */
        .dropdown-content a {
            display: block;
            width: 100%;

            color: white;
            /* white text for contrast */
            text-decoration: none;
            transition: background 0.3s ease;
        }

        /* Hover effect for dropdown links */
        .dropdown-content a:hover {
            background-color: #8f8686;
            /* darker shade of nav color */
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
            <a href="http://localhost/iitm/lara/backend">Home</a>

            <!-- Backend dropdown -->
            <a href="<?= base_url('backend') ?>">Backend</a>


            <!-- Companies dropdown -->
            <a href="<?= base_url('company/main/overview/state') ?>">Database</a>


            <a href="<?= base_url('events') ?>">Events</a>
            <a href="<?= base_url('layout-info') ?>">Layout</a>
            <a href="<?= base_url('leads') ?>">Leads</a>
            <a href="<?= base_url('crossvalidation') ?>">Crossvalidation</a>
            <!-- <a href="<?= site_url('booking/exhibitor_booking') ?>">Exhibitor Booking</a> -->
            <!-- <a href="<?= site_url('booking/view') ?>">View Booking</a> -->
            <a href="<?= site_url('ticket') ?>">Ticket</a>
            <a href="<?= site_url('registration') ?>">Registration</a>
            <a href="http://localhost/phpmyadmin/index.php">MyPhpAdmin</a>
            <a href="<?= site_url('app') ?>">Download App</a>
            <a href="http://localhost/iitm/app">App</a>
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

            ⚙️
        </button>


        </div>


        <div id="themeWindow" class="theme-window">

            <div class="theme-header">
                <span>Theme Settings</span>
                <button id="closeTheme">✖</button>
            </div>

            <div class="quick-content">
                <table>
                    <tr>
                        <td style="border: 1px solid white;">
                            <a href="<?= site_url('logout') ?>">Logout</a>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="theme-body">

                <label>Navbar Color</label>
                <input type="color" id="navColor" value="#a82324">

                <label>Navbar Dim</label>
                <input type="color" id="navDim" value="#c45a5b">

                <label>Body Background</label>
                <input type="color" id="bodyColor" value="#f8f4f4">

                <label>Button Color</label>
                <input type="color" id="buttonColor" value="#a82324">

                <label>Button Dim</label>
                <input type="color" id="buttonDim" value="#c45a5b">

                <label>Text Color</label>
                <input type="color" id="textColor" value="#ffffff">

                <label>Text Dim</label>
                <input type="color" id="textDim" value="#d6d6d6">

                <button id="resetTheme" class="reset-btn">Reset to Default</button>

            </div>

        </div>
    </nav>
    <!-- Theme Popup -->



    <script>
        document.addEventListener("DOMContentLoaded", function () {

            // Pickers
            const navPicker = document.getElementById("navColor");
            const navDimPicker = document.getElementById("navDim");
            const bodyPicker = document.getElementById("bodyColor");
            const bodyDimPicker = document.getElementById("bodyDim");
            const buttonPicker = document.getElementById("buttonColor");
            const buttonDimPicker = document.getElementById("buttonDim");
            const textColorPicker = document.getElementById("textColor");
            const textDimPicker = document.getElementById("textDim");

            const themeWindow = document.getElementById("themeWindow");
            const openBtn = document.getElementById("openTheme");
            const closeBtn = document.getElementById("closeTheme");
            const resetBtn = document.getElementById("resetTheme");

            // Default colors
            const defaultColors = {
                nav: "#a82324",
                navDim: "#c45a5b",
                body: "#f8f4f4",
                bodyDim: "#fbf9f9",
                button: "#a82324",
                buttonDim: "#c45a5b",
                text: "#ffffff",
                textDim: "#dcdcdc"
            };

            // Function to create lighter DIM color
            function makeDim(hex, percent = 40) {
                let num = parseInt(hex.replace("#", ""), 16),
                    r = (num >> 16) + percent,
                    g = (num >> 8 & 0x00FF) + percent,
                    b = (num & 0x0000FF) + percent;

                r = r < 255 ? r : 255;
                g = g < 255 ? g : 255;
                b = b < 255 ? b : 255;

                // Convert back to hex, pad with zeros
                return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
            }

            // Open / Close Theme Window
            openBtn.onclick = () => themeWindow.style.display = "block";
            closeBtn.onclick = () => themeWindow.style.display = "none";

            // Load saved colors from localStorage
            function loadColor(key, picker, cssVar, dimVar = null) {
                const saved = localStorage.getItem(key);
                if (saved) {
                    document.documentElement.style.setProperty(cssVar, saved);
                    picker.value = saved;
                    if (dimVar) {
                        document.documentElement.style.setProperty(dimVar, makeDim(saved));
                    }
                }
            }

            loadColor("navColor", navPicker, "--nav-color", "--nav-color-dim");
            loadColor("bodyColor", bodyPicker, "--body-color", "--body-color-dim");
            loadColor("buttonColor", buttonPicker, "--button-color", "--button-color-dim");
            loadColor("textColor", textColorPicker, "--text-color");
            loadColor("textDim", textDimPicker, "--text-color-dim");

            function setupPicker(picker, cssVar, storageKey, dimVar = null, dimPicker = null) {
                picker.addEventListener("input", function () {
                    document.documentElement.style.setProperty(cssVar, this.value);
                    localStorage.setItem(storageKey, this.value);

                    if (dimVar) {
                        const dimValue = makeDim(this.value);
                        document.documentElement.style.setProperty(dimVar, dimValue);

                        if (dimPicker) {
                            dimPicker.value = dimValue; // update the dim input
                        }
                    }
                });
            }

            // Example usage:
            setupPicker(navPicker, "--nav-color", "navColor", "--nav-color-dim", navDimPicker);
            setupPicker(buttonPicker, "--button-color", "buttonColor", "--button-color-dim", buttonDimPicker);
            setupPicker(bodyPicker, "--body-color", "bodyColor", "--body-color-dim");
            setupPicker(textColorPicker, "--text-color", "textColor");
            setupPicker(textDimPicker, "--text-color-dim", "textDim");
            // Reset button
            resetBtn.addEventListener("click", function () {
                document.documentElement.style.setProperty('--nav-color', defaultColors.nav);
                document.documentElement.style.setProperty('--nav-color-dim', defaultColors.navDim);
                document.documentElement.style.setProperty('--body-color', defaultColors.body);
                document.documentElement.style.setProperty('--body-color-dim', defaultColors.bodyDim);
                document.documentElement.style.setProperty('--button-color', defaultColors.button);
                document.documentElement.style.setProperty('--button-color-dim', defaultColors.buttonDim);
                document.documentElement.style.setProperty('--text-color', defaultColors.text);
                document.documentElement.style.setProperty('--text-color-dim', defaultColors.textDim);

                navPicker.value = defaultColors.nav;
                bodyPicker.value = defaultColors.body;
                buttonPicker.value = defaultColors.button;
                textColorPicker.value = defaultColors.text;
                textDimPicker.value = defaultColors.textDim;

                // Remove from localStorage
                localStorage.removeItem("navColor");
                localStorage.removeItem("bodyColor");
                localStorage.removeItem("buttonColor");
                localStorage.removeItem("textColor");
                localStorage.removeItem("textDim");

                themeWindow.style.display = "none";
            });

        });
    </script>


    <div class="wrapper">

        <?= view('sidemenu') ?>