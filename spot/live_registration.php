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
body{font-family:Arial;background:#f3f4f6;display:flex;justify-content:center;align-items:center;height:100vh;margin:0;}
.box{background:white;padding:30px;border-radius:8px;box-shadow:0 4px 10px rgba(0,0,0,0.1);text-align:center;}
input{padding:10px;width:200px;margin-bottom:10px;border-radius:4px;border:1px solid #ccc;}
button{background:#a82324;color:white;border:none;padding:10px 20px;cursor:pointer;border-radius:4px;}
button:hover{background:#7d1a1b;}
.error{color:red;margin-top:10px;}
</style>
</head>
<body>
<div class="box">
<h3>Enter PIN</h3>
<form method="POST">
<input type="password" name="pin" placeholder="Enter PIN" required><br>
<button type="submit">Access</button>
</form>
<?php if(isset($error)){ echo "<div class='error'>$error</div>"; } ?>
</div>
</body>
</html>
<?php exit(); }

// === DATABASE CONNECTION ===
$host = '21.157.66.148.host.secureserver.net';
$port = 3306;
$user = 'iitminda_master';
$password = 'gB)%gU}ocn?MCP=}';
$database = 'iitminda_iitmindia_2024';

$conn = mysqli_connect($host, $user, $password, $database, $port);
if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

// === FILTERS ===
$filter_year = $_GET['year'] ?? date('Y');
$filter_city = $_GET['city'] ?? '';
$page = $_GET['page'] ?? 1;
$limit = 50; // number of entries per page
$offset = ($page - 1) * $limit;

// Build query using YEAR(date_reg) and city_name
$where = "WHERE YEAR(date_reg) = '".mysqli_real_escape_string($conn, $filter_year)."'";
if ($filter_city) {
    $where .= " AND city_name = '".mysqli_real_escape_string($conn, $filter_city)."'";
}

// Count total records for pagination
$countAll = mysqli_query($conn, "SELECT COUNT(*) as total FROM tradev $where");
$totalRows = mysqli_fetch_assoc($countAll)['total'];
$totalPages = ceil($totalRows / $limit);

// Main query with LIMIT for pagination
$sqlQuery = "
SELECT 
    id,
    select2,
    name,
    designation,
    organisation AS company_name,
    email,
    phone,
    mobile,
    city_name,
    state,
    country,
    date_reg
FROM tradev
$where
ORDER BY id DESC
LIMIT $offset, $limit
";
$visitorResult = mysqli_query($conn, $sqlQuery);

// Counts by year and city_name
$countQuery = "
SELECT YEAR(date_reg) AS reg_year, city_name, COUNT(*) AS total
FROM tradev
$where
GROUP BY reg_year, city_name
ORDER BY reg_year ASC, city_name ASC
";
$countResult = mysqli_query($conn, $countQuery);

// Unique cities for dropdown
$cityResult = mysqli_query($conn, "SELECT DISTINCT city_name FROM tradev ORDER BY city_name ASC");
$cities = [];
while($c = mysqli_fetch_assoc($cityResult)){ $cities[] = $c['city_name']; }
?>

<!DOCTYPE html>
<html>
<head>
<title>IITM Registration</title>
<style>
body{font-family: Arial,sans-serif;background:#f3f4f6;margin:0;}
.header{background:#a82324;color:white;padding:15px;display:flex;align-items:center;}
.header img{height:40px;margin-right:15px;}
.container{width:90%;margin:auto;margin-top:20px;}
.row{display:flex;background:white;margin-bottom:8px;border-radius:6px;padding:10px;align-items:center;box-shadow:0 2px 4px rgba(0,0,0,0.05);}
.row div{flex:1;}
.company{font-weight:bold;color:#a82324;}
.name{font-weight:600;}
.mobile{font-family:monospace;}
.headrow{display:flex;font-weight:bold;padding:10px;color:#555;}
.headrow div{flex:1;}
.filter-form{background:white;padding:10px;border-radius:6px;margin-bottom:15px;display:flex;gap:10px;flex-wrap:wrap;align-items:center;}
.filter-form select{padding:5px;border-radius:4px;border:1px solid #ccc;}
.filter-form button{background:#a82324;color:white;border:none;padding:6px 12px;cursor:pointer;border-radius:4px;}
.filter-form button:hover{background:#7d1a1b;}
.count-table{background:white;padding:10px;border-radius:6px;margin-bottom:20px;box-shadow:0 2px 4px rgba(0,0,0,0.05);}
.count-table table{width:100%;border-collapse: collapse;}
.count-table th, .count-table td{border:1px solid #ccc;padding:5px;text-align:left;}
.pagination{margin:15px 0;text-align:center;}
.pagination a{margin:0 5px;padding:5px 10px;background:#a82324;color:white;text-decoration:none;border-radius:4px;}
.pagination a:hover{background:#7d1a1b;}
.pagination .current{background:#555;}
</style>
</head>
<body>
<div class="header">
<img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png">
<h2>Registration List</h2>
</div>

<div class="container">
<!-- Filter Form -->
<form method="GET" class="filter-form">
<label>Year: 
<select name="year">
<?php 
for($y=date('Y');$y>=2020;$y--){
    $selected = ($y==$filter_year)?'selected':'';
    echo "<option value='$y' $selected>$y</option>";
}
?>
</select>
</label>
<label>City: 
<select name="city">
<option value="">All Cities</option>
<?php foreach($cities as $cityOption): ?>
<option value="<?php echo $cityOption; ?>" <?php echo ($cityOption==$filter_city)?'selected':''; ?>><?php echo $cityOption; ?></option>
<?php endforeach; ?>
</select>
</label>
<button type="submit">Filter</button>
</form>

<!-- Counts by year and city_name -->
<div class="count-table">
<h3>Registration Counts by Year and City</h3>
<table>
<tr><th>Year</th><th>City</th><th>Total</th></tr>
<?php
if(mysqli_num_rows($countResult)>0){
    while($c = mysqli_fetch_assoc($countResult)){
        echo "<tr><td>{$c['reg_year']}</td><td>{$c['city_name']}</td><td>{$c['total']}</td></tr>";
    }
}else{
    echo "<tr><td colspan='3'>No data</td></tr>";
}
?>
</table>
</div>

<!-- Notice about raw data -->
<div style="background:#fff3cd; color:#856404; border:1px solid #ffeeba; padding:10px; border-radius:6px; margin-bottom:15px;">
<strong>Note:</strong> This data is raw and may contain duplicates or incorrect entries. Please verify before using.
</div>

<!-- Visitor Table -->
<div class="headrow">
<div>Time</div>
<div>Name</div>
<div>Company</div>
<div>City</div>
</div>

<?php
if (mysqli_num_rows($visitorResult) > 0) {
    while ($row = mysqli_fetch_assoc($visitorResult)) {
        echo "
        <div class='row'>
            <div class='time'>{$row['date_reg']}</div>
            <div class='name'>{$row['select2']} {$row['name']}</div>
            <div class='company'>{$row['company_name']}</div>
            <div>{$row['city_name']}</div>
        </div>
        ";
    }
} else {
    echo "<div>No registrations found.</div>";
}
?>

<!-- Pagination Links -->
<div class="pagination">
<?php
for($p=1;$p<=$totalPages;$p++){
    $active = ($p==$page)?'current':'';
    $queryStr = "?year=$filter_year&city=".urlencode($filter_city)."&page=$p";
    echo "<a class='$active' href='$queryStr'>$p</a>";
}
?>
</div>
</div>
</body>
</html>