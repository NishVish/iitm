<?php
$conn = new mysqli("localhost", "root", "", "tempdatabase");
if ($conn->connect_error) die("Connection failed");

$resultData = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = $_POST['search'] ?? '';

    $stmt = $conn->prepare("
        SELECT name, companyname 
        FROM registrations 
        WHERE mobilenumber = ? OR name LIKE ?
        LIMIT 1
    ");

    $likeSearch = "%" . $search . "%";
    $stmt->bind_param("ss", $search, $likeSearch);
    $stmt->execute();

    $result = $stmt->get_result();
    $resultData = $result->fetch_assoc();

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
<style>
body {
    font-family: Arial;
    text-align: center;
}

/* Badge (9x14 style area) */
.badge {
    position: relative;
    width: 9.2cm;
    height: 13.6cm;
    margin: 20px auto;
}

/* Movable text (MAIN CONTROL) */
.overlay {
    position: absolute;
    top: 150px;
    left: 45px;
    width: calc(100% - 40px);
    text-align: center;
}

/* FORCE CAPS */
.overlay div {
    text-transform: uppercase;
}

/* Text */
.name {
    font-size: 26px;
    font-weight: bold;
}
.company {
    font-size: 24px;
}

/* PRINT (NO CENTERING — YOUR STYLE) */
@media print {
    body * {
        visibility: hidden;
    }

    .badge, .badge * {
        visibility: visible;
    }

    .badge {
        position: absolute;
        top: 0;
        left: 0;
    }
}
</style>
</head>
<body>

<h2>SEARCH VISITOR</h2>

<form method="POST">
    <input type="text" name="search" placeholder="ENTER MOBILE OR NAME" required>
    <button type="submit">SEARCH</button>
</form>

<?php if (!empty($resultData)): ?>

<div class="badge">

    <div class="overlay" id="overlay">
        <div class="name" contenteditable="true">
            <?= htmlspecialchars($resultData['name']) ?>
        </div>
        <div class="company" contenteditable="true">
            <?= htmlspecialchars($resultData['companyname']) ?>
        </div>
    </div>

</div>

<!-- CONTROLS (SAME LOGIC AS YOUR ORIGINAL) -->
<div style="margin-top:20px;">

    <button onclick="adjust('up')">↑</button>
    <button onclick="adjust('down')">↓</button>
    <button onclick="adjust('left')">←</button>
    <button onclick="adjust('right')">→</button>

    <br><br>

    TOP: <input type="number" id="topInput" style="width:70px;">
    LEFT: <input type="number" id="leftInput" style="width:70px;">

    <br><br>

    <button onclick="resetPos()">RESET</button>
    <button onclick="window.print()">PRINT</button>
</div>

<script>
// LOAD SAVED POSITION
window.onload = function () {
    const top = localStorage.getItem('top') || 150;
    const left = localStorage.getItem('left') || 45;

    document.getElementById('topInput').value = top;
    document.getElementById('leftInput').value = left;

    apply(top, left);
};

// APPLY POSITION
function apply(top, left) {
    const el = document.getElementById('overlay');
    el.style.top = top + "px";
    el.style.left = left + "px";
}

// MOVE BUTTONS
function adjust(dir) {
    let top = parseInt(document.getElementById('topInput').value);
    let left = parseInt(document.getElementById('leftInput').value);

    const step = 5;

    if (dir === 'up') top -= step;
    if (dir === 'down') top += step;
    if (dir === 'left') left -= step;
    if (dir === 'right') left += step;

    document.getElementById('topInput').value = top;
    document.getElementById('leftInput').value = left;

    apply(top, left);

    localStorage.setItem('top', top);
    localStorage.setItem('left', left);
}

// RESET
function resetPos() {
    apply(150, 45);
    localStorage.setItem('top', 150);
    localStorage.setItem('left', 45);

    document.getElementById('topInput').value = 150;
    document.getElementById('leftInput').value = 45;
}

// MANUAL INPUT CHANGE
document.addEventListener("DOMContentLoaded", () => {
    const topInput = document.getElementById('topInput');
    const leftInput = document.getElementById('leftInput');

    topInput.addEventListener('input', () => {
        apply(topInput.value, leftInput.value);
        localStorage.setItem('top', topInput.value);
    });

    leftInput.addEventListener('input', () => {
        apply(topInput.value, leftInput.value);
        localStorage.setItem('left', leftInput.value);
    });
});
</script>

<?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
<p>NO RESULT FOUND</p>
<?php endif; ?>

</body>
</html>