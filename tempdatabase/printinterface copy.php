<?php
$conn = new mysqli("localhost", "root", "", "tempdatabase");
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
            transform: translateX(-50%); /* Center the image horizontally */
            width: 9cm; /* Your badge width */
            opacity: 0.3; /* Faint so you can see the text over it */
            pointer-events: none; /* Allows clicking text through image */
        }

        /* TEXT BLOCK */
        #badge-overlay {
            position: absolute;
            width: 100%;
            left: 0;
            top: 100px;
            text-align: center;
            z-index: 10;
        }

        .name { font-weight: bold; text-transform: uppercase; margin-bottom: 5px; }
        .company { text-transform: uppercase; color: #444; }

        /* PRINT LOGIC */
        @media print {
            @page { size: A4; margin: 0; }
            body { background: none; padding: 0; }
            .no-print, .reference-img { display: none !important; }
            .a4-page { margin: 0; border: none; box-shadow: none; width: 21cm; height: 29.7cm; }
        }

        /* UI Styling */
        .controls div { margin: 10px 0; }
        button { padding: 8px 12px; cursor: pointer; font-weight: bold; }
        input[type="number"] { width: 60px; padding: 5px; }
    </style>
</head>
<body>

<div class="no-print">
    <form method="POST" style="margin-bottom: 10px;">
        <input type="text" name="search" placeholder="Mobile / Name" style="padding:8px; width:200px;">
        <button type="submit" style="background:#007bff; color:#fff; border:none;">SEARCH</button>
    </form>
    
    <div class="controls">
        <b>VERTICAL:</b> 
        <button onclick="move('up')">↑</button> 
        <input type="number" id="vPos" oninput="manual()"> 
        <button onclick="move('down')">↓</button>
        
        <span style="margin: 0 20px;">|</span>
        
        <b>TEXT SIZE:</b> 
        <button onclick="scaleText(-2)">A-</button> 
        <input type="number" id="fSize" oninput="manual()"> px 
        <button onclick="scaleText(2)">A+</button>
    </div>

    <div style="margin-top:10px;">
        <button onclick="window.print()" style="background:#28a745; color:#fff; border:none; padding:10px 40px; font-size:16px;">PRINT BADGE</button>
    </div>
</div>

<div class="a4-page">
    <img src="img.jpg" class="reference-img" alt="Badge Guide">

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

    // Default or Saved Values
    let topVal = parseInt(localStorage.getItem('badge_v')) || 100;
    let fontSize = parseInt(localStorage.getItem('badge_f')) || 32;

    function refresh() {
        if(!el) return;
        
        // Apply vertical position
        el.style.top = topVal + "px";
        vInp.value = topVal;
        
        // Apply font size (Company is slightly smaller than Name)
        nameEl.style.fontSize = fontSize + "px";
        compEl.style.fontSize = (fontSize * 0.7) + "px"; 
        fInp.value = fontSize;

        localStorage.setItem('badge_v', topVal);
        localStorage.setItem('badge_f', fontSize);
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
        topVal = parseInt(vInp.value);
        fontSize = parseInt(fInp.value);
        refresh();
    }

    window.onload = refresh;
</script>

</body>
</html>