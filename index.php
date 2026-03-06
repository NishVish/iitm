<?php
session_start();

$password = "nin";
$showContent = false;

if (isset($_POST['password']) && $_POST['password'] === $password) {
    $_SESSION['auth'] = true;
}

if (isset($_SESSION['auth'])) {
    $showContent = true;
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . basename(__FILE__));
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>404 Not Found</title>

<style>
body{
    font-family: Arial, sans-serif;
    text-align:center;
    padding:100px;
}

#loginBox{
    display:none;
    margin-top:20px;
}

input{
    padding:8px;
}
</style>

<script>
function showLogin(){
    document.getElementById("loginBox").style.display="block";
}
</script>

</head>
<body>

<?php if(!$showContent): ?>

<h1 onclick="showLogin()" style="cursor:pointer;">404</h1>
<p>The page you requested could not be found.</p>

<div id="loginBox">
<form method="post">
<input type="password" name="password">
<button type="submit">Enter</button>
</form>
</div>

<?php else: ?>

<h1>IITM Directory</h1>

<ul>
<?php
$files = scandir(__DIR__);

foreach($files as $file){

    if($file=="." || $file=="..") continue;
    if($file==basename(__FILE__)) continue;

    echo "<li><a href='".htmlspecialchars($file)."'>".htmlspecialchars($file)."</a></li>";
}
?>
</ul>

<p><a href="?logout=1">Logout</a></p>

<?php endif; ?>

</body>
</html>