<?php
// Database credentials
$host = "sql305.yzz.me";
$username = "yzzme_41441837";
$password = "D5i1NHsZ97CF"; 
$database = "yzzme_41441837_tempdatabase";

var_dump($host);
var_dump($username);
var_dump($password);
var_dump($database);
// exit;
// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query
$sql = "SELECT id, name, companyname, mobilenumber, emailid, city, created_at FROM registrations ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registrations List</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px; }
        h2 { text-align: center; color: #333; }
        
        table {
            border-collapse: collapse;
            width: 90%;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        
        th {
            background-color: #007bff;
            color: white;
            text-transform: uppercase;
            font-size: 14px;
        }
        
        tr:nth-child(even) { background-color: #f2f2f2; }
        tr:hover { background-color: #f1f1f1; }
        
        .no-data { text-align: center; padding: 20px; color: #666; }
    </style>
</head>
<body>

<h2>Registrations Data</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Company Name</th>
            <th>Mobile Number</th>
            <th>Email</th>
            <th>City</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . htmlspecialchars($row['id']) . "</td>
                    <td>" . htmlspecialchars($row['name']) . "</td>
                    <td>" . htmlspecialchars($row['companyname']) . "</td>
                    <td>" . htmlspecialchars($row['mobilenumber']) . "</td>
                    <td>" . htmlspecialchars($row['emailid']) . "</td>
                    <td>" . htmlspecialchars($row['city']) . "</td>
                    <td>" . htmlspecialchars($row['created_at']) . "</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='7' class='no-data'>No records found</td></tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>

<?php
if ($result) { $result->free(); }
$conn->close();
?>