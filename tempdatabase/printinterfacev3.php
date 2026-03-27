<?php

// ================= QR API =================
if (isset($_GET['qr']) && $_SERVER["REQUEST_METHOD"] === "POST") {

    $data = json_decode(file_get_contents("php://input"), true);

    $name = "";
    $company = "";

    if (isset($data['qr'])) {
        $lines = explode("\n", $data['qr']);

        foreach ($lines as $line) {
            $line = trim($line);

            if (stripos($line, "NAME") !== false) {
                $parts = explode(":", $line, 2);
                $name = trim($parts[1] ?? "");
            }

            if (stripos($line, "Organisation") !== false) {
                $parts = explode(":", $line, 2);
                $company = trim($parts[1] ?? "");
            }
        }
    }

    echo json_encode([
        "name" => $name,
        "company" => $company
    ]);
    exit;
}

// ================= DB =================
$host = "sql305.yzz.me";
$username = "yzzme_41441837";
$password = "D5i1NHsZ97CF";
$database = "yzzme_41441837_tempdatabase";

// $conn = new mysqli($host, $username, $password, $database);
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
<title>A4 Badge System</title>

<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family: Arial; background:#e9ecef; text-align:center; }

/* TOP PANEL */
.no-print {
    background:white;
    padding:20px;
    border-bottom:3px solid #007bff;
    position:sticky;
    top:0;
    z-index:1000;
    box-shadow:0 4px 10px rgba(0,0,0,0.1);
}

/* A4 PAGE */
.a4-page {
    width:21cm;
    height:29.7cm;
    margin:20px auto;
    background:white;
    position:relative;
    box-shadow:0 0 15px rgba(0,0,0,0.2);
    overflow:hidden;
}

.reference-img {
    position:absolute;
    top:0;
    left:50%;
    transform:translateX(-50%);
    width:9cm;
    opacity:0.4;
}

/* TEXT */
#badge-overlay {
    position:absolute;
    width:100%;
    top:100px;
    text-align:center;
}

.name {
    font-weight:bold;
    text-transform:uppercase;
}

.company {
    text-transform:uppercase;
    color:#444;
}

/* CONTROLS */
.controls {
    display:flex;
    justify-content:center;
    gap:20px;
    flex-wrap:wrap;
}

.control-group {
    border:1px solid #ddd;
    padding:10px;
    background:#f9f9f9;
    border-radius:5px;
}

button {
    padding:8px 12px;
    cursor:pointer;
    font-weight:bold;
}

input[type="number"] {
    width:70px;
    padding:5px;
    text-align:center;
}

/* PRINT */
@media print {
    .no-print, .reference-img { display:none; }
    .a4-page { margin:0; box-shadow:none; }
}
</style>

<script src="https://unpkg.com/html5-qrcode"></script>
</head>

<body>

<div class="no-print">

<h3>QR Scanner</h3>
<div id="reader" style="width:300px;margin:auto;"></div>
<button onclick="startQR()">Start QR</button>
<button onclick="stopQR()">Stop QR</button>

<pre id="qrOutput" style="background:#000;color:#0f0;padding:10px;margin-top:10px;"></pre>

<form method="POST" style="margin-top:10px;">
    <input type="text" name="search" placeholder="Mobile / Name">
    <button type="submit">SEARCH</button>
</form>

<hr style="margin:15px 0;">

<div class="controls">

    <div class="control-group">
        <b>VERTICAL</b><br>
        <button onclick="move('up')">↑</button>
        <input type="number" id="vPos" oninput="manual()">
        <button onclick="move('down')">↓</button>
    </div>

    <div class="control-group">
        <b>TEXT SIZE</b><br>
        <button onclick="scaleText(-2)">A-</button>
        <input type="number" id="fSize" oninput="manual()">
        <button onclick="scaleText(2)">A+</button>
    </div>

</div>

<div style="margin-top:15px;">
    <button onclick="window.print()" style="background:green;color:#fff;padding:12px 40px;">
        PRINT BADGE
    </button>
</div>

</div>

<!-- BADGE -->
<div class="a4-page">
    <img src="img.jpg" class="reference-img">

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
let qrScanner;

// QR
function startQR() {
    qrScanner = new Html5Qrcode("reader");

    qrScanner.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: 250 },
        (decodedText) => {

            fetch("?qr=1", {
                method: "POST",
                body: JSON.stringify({ qr: decodedText }),
                headers: { "Content-Type": "application/json" }
            })
            .then(res => res.json())
            .then(data => {

                if (data.name) document.getElementById("nameText").innerText = data.name;
                if (data.company) document.getElementById("compText").innerText = data.company;

                document.getElementById("qrOutput").innerText = JSON.stringify(data, null, 2);
            });
        }
    );
}

function stopQR() {
    if (qrScanner) qrScanner.stop().then(() => qrScanner.clear());
}

// UI Controls
const el = document.getElementById('badge-overlay');
const nameEl = document.getElementById('nameText');
const compEl = document.getElementById('compText');

const vInp = document.getElementById('vPos');
const fInp = document.getElementById('fSize');

let topVal = parseInt(localStorage.getItem('badge_top')) || 100;
let fontSize = parseInt(localStorage.getItem('badge_font')) || 32;

function refresh() {
    el.style.top = topVal + "px";
    vInp.value = topVal;

    nameEl.style.fontSize = fontSize + "px";
    compEl.style.fontSize = (fontSize * 0.7) + "px";
    fInp.value = fontSize;

    localStorage.setItem('badge_top', topVal);
    localStorage.setItem('badge_font', fontSize);
}

function move(dir) {
    if (dir === 'up') topVal -= 5;
    if (dir === 'down') topVal += 5;
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

<p>
https://dashboard.free-hosting.org/login
</p>

</body>
</html>