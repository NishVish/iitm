<?php
session_start();

// === PIN PROTECTION ===
$correct_pin = "iitm2026";

if (isset($_POST['pin'])) {
    if ($_POST['pin'] === $correct_pin) {
        $_SESSION['access'] = true;
    } else {
        $error = "Invalid PIN";
    }
}

if (!isset($_SESSION['access'])) {
?>
<!DOCTYPE html>
<html>
<head>
<title>Enter PIN</title>
<style>
body{
    font-family:Arial;
    background:#f3f4f6;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    margin:0;
}
.box{
    background:white;
    padding:30px;
    border-radius:8px;
    box-shadow:0 4px 10px rgba(0,0,0,0.1);
    text-align:center;
}
input{
    padding:10px;
    width:200px;
    margin-bottom:10px;
    border-radius:4px;
    border:1px solid #ccc;
}
button{
    background:#a82324;
    color:white;
    border:none;
    padding:10px 20px;
    cursor:pointer;
    border-radius:4px;
}
button:hover{
    background:#7d1a1b;
}
.error{
    color:red;
    margin-top:10px;
}
</style>
</head>
<body>
<div class="box">
<h3>Enter PIN</h3>
<form method="POST">
    <input type="password" name="pin" placeholder="Enter PIN" required><br>
    <button type="submit">Access</button>
</form>
<?php
if (isset($error)) {
    echo "<div class='error'>$error</div>";
}
?>
</div>
</body>
</html>
<?php
exit();
}

// === DATABASE CONNECTION ===
$host = '21.157.66.148.host.secureserver.net';
$port = 3306;
$user = 'iitminda_master';
$password = 'gB)%gU}ocn?MCP=}';
$database = 'iitminda_form_data';

$conn = mysqli_connect($host, $user, $password, $database, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sqlQuery = "
SELECT id, company_name, name, city, mobile
FROM tradevisitor
WHERE DATE(created_at) >= '2026-03-12'
ORDER BY id ASC
";

$visitorResult = mysqli_query($conn, $sqlQuery);
?>

<!DOCTYPE html>
<html>
<head>
<title>IITM Registration</title>
<style>
body{
    font-family: Arial, sans-serif;
    background:#f3f4f6;
    margin:0;
}
.header{
    background:#a82324;
    color:white;
    padding:15px;
    display:flex;
    align-items:center;
}
.header img{
    height:40px;
    margin-right:15px;
}
.container{
    width:90%;
    margin:auto;
    margin-top:20px;
}
.row{
    display:flex;
    background:white;
    margin-bottom:8px;
    border-radius:6px;
    padding:10px;
    align-items:center;
    box-shadow:0 2px 4px rgba(0,0,0,0.05);
}
.row div{
    flex:1;
}
.company{
    font-weight:bold;
    color:#a82324;
}
.name{
    font-weight:600;
}
.mobile{
    font-family:monospace;
}
button{
    background:#a82324;
    color:white;
    border:none;
    padding:6px 12px;
    border-radius:4px;
    cursor:pointer;
}
button:hover{
    background:#7d1a1b;
}
.headrow{
    display:flex;
    font-weight:bold;
    padding:10px;
    color:#555;
}
.headrow div{
    flex:1;
}
</style>
</head>
<body>
<div class="header">
<img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png">
<h2>Registration List</h2>
</div>
<div class="container">
<div class="headrow">
<div>Name</div>
<div>Company</div>
<div>City</div>
<div>Mobile</div>
</div>

<?php
if (mysqli_num_rows($visitorResult) > 0) {
    while ($row = mysqli_fetch_assoc($visitorResult)) {
        echo "
        <div class='row'>
            <div class='name'>{$row['name']}</div>
            <div class='company'>{$row['company_name']}</div>
            <div>{$row['city']}</div>
            <div class='mobile'>{$row['mobile']}</div>
        </div>
        ";
    }
} else {
    echo "<div>No Registration found.</div>";
}
mysqli_close($conn);
?>

</div>
</body>
</html>