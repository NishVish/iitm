<?php
// $conn = new mysqli("localhost", "root", "", "tempdatabase");
$host = "sql305.yzz.me";
$username = "yzzme_41441837";
$password = "D5i1NHsZ97CF"; 
$database = "yzzme_41441837_tempdatabase";

// var_dump($host);
// var_dump($username);
// var_dump($password);
// var_dump($database);
// exit;
// Create connection
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) die("Connection failed");

$resultData = ['name' => '', 'companyname' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = $_POST['search'] ?? '';
    $stmt = $conn->prepare("SELECT name, companyname FROM registrations WHERE mobilenumber = ? OR name LIKE ? LIMIT 1");
    $likeSearch = "%" . $search . "%";
    $stmt->bind_param("ss", $search, $likeSearch);
    $stmt->execute();
    $result = $stmt->get_result();
    $resultData = $result->fetch_assoc() ?: ['name' => '', 'companyname' => ''];
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>A4 Badge Sync - Final</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #e9ecef; text-align: center; }

        .no-print {
            background: white; padding: 20px; border-bottom: 3px solid #007bff;
            position: sticky; top: 0; z-index: 1000; box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        /* A4 PAGE CONTAINER */
        .a4-page {
            width: 21cm;
            height: 29.7cm;
            margin: 20px auto;
            background: white;
            position: relative;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            overflow: hidden;
        }

        /* TEMPORARY REFERENCE IMAGE (Visible only on screen) */
        .reference-img {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%); 
            width: 9cm; /* Your badge width */
            opacity: 0.4; 
            pointer-events: none; 
        }

        /* TEXT BLOCK - Centered horizontally by default */
        #badge-overlay {
            position: absolute;
            width: 100%;
            left: 0;
            top: 100px;
            text-align: center;
            z-index: 10;
        }

        .name { font-weight: bold; text-transform: uppercase; margin-bottom: 5px; width: 100%; }
        .company { text-transform: uppercase; color: #444; width: 100%; }

        /* PRINT LOGIC */
        @media print {
            @page { size: A4; margin: 0; }
            body { background: none; padding: 0; }
            .no-print, .reference-img { display: none !important; }
            .a4-page { margin: 0; border: none; box-shadow: none; width: 21cm; height: 29.7cm; }
        }

        /* UI Styling */
        .controls { display: flex; justify-content: center; gap: 20px; align-items: center; flex-wrap: wrap; }
        .control-group { border: 1px solid #ddd; padding: 10px; border-radius: 5px; background: #f9f9f9; }
        button { padding: 8px 12px; cursor: pointer; font-weight: bold; background: #eee; border: 1px solid #ccc; }
        button:hover { background: #ddd; }
        input[type="number"] { width: 70px; padding: 5px; text-align: center; font-size: 16px; }
    </style>
</head>
<body>

<div class="no-print">
    <form method="POST" style="margin-bottom: 15px;">
        <input type="text" name="search" placeholder="Mobile / Name Search" style="padding:10px; width:250px;">
        <button type="submit" style="background:#007bff; color:#fff; border:none;">SEARCH</button>
    </form>
    
    <div class="controls">
        <div class="control-group">
            <b>VERTICAL (TOP)</b><br>
            <button onclick="move('up')">↑</button> 
            <input type="number" id="vPos" oninput="manual()"> 
            <button onclick="move('down')">↓</button>
        </div>
        
        <div class="control-group">
            <b>TEXT SIZE (SIDE)</b><br>
            <button onclick="scaleText(-2)">A-</button> 
            <input type="number" id="fSize" oninput="manual()"> 
            <button onclick="scaleText(2)">A+</button>
        </div>
    </div>

    <div style="margin-top:15px;">
        <button onclick="window.print()" style="background:#28a745; color:#fff; border:none; padding:12px 50px; font-size:18px; border-radius:5px;">PRINT BADGE</button>
    </div>
</div>

<div class="a4-page">
    <img src="img.jpg" class="reference-img" alt="Guide Image">

    <div id="badge-overlay">
        <div class="name" id="nameText" contenteditable="true">
            <?= htmlspecialchars($resultData['name']) ?>
        </div>
        <div class="company" id="compText" contenteditable="true">
            <?= htmlspecialchars($resultData['companyname']) ?>
        </div>
    </div>
</div>

<script>
    const el = document.getElementById('badge-overlay');
    const nameEl = document.getElementById('nameText');
    const compEl = document.getElementById('compText');
    
    const vInp = document.getElementById('vPos');
    const fInp = document.getElementById('fSize');

    // Default Values or Load from Memory
    let topVal = parseInt(localStorage.getItem('badge_top')) || 100;
    let fontSize = parseInt(localStorage.getItem('badge_font')) || 32;

    function refresh() {
        if(!el) return;
        
        // Vertical Move
        el.style.top = topVal + "px";
        vInp.value = topVal;
        
        // Text Size Move (Side/Scaling)
        nameEl.style.fontSize = fontSize + "px";
        compEl.style.fontSize = (fontSize * 0.7) + "px"; // Company slightly smaller
        fInp.value = fontSize;

        localStorage.setItem('badge_top', topVal);
        localStorage.setItem('badge_font', fontSize);
    }

    function move(dir) {
        if(dir === 'up') topVal -= 5;
        if(dir === 'down') topVal += 5;
        refresh();
    }

    function scaleText(delta) {
        fontSize += delta;
        refresh();
    }

    function manual() {
        topVal = parseInt(vInp.value) || 0;
        fontSize = parseInt(fInp.value) || 10;
        refresh();
    }

    window.onload = refresh;
</script>

</body>
</html>