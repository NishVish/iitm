<?php
// Config - Recommended to move to a separate, non-public config.php file
$host = '21.157.66.148.host.secureserver.net';
$port = 3306;
$user = 'iitminda_master';
$password = 'gB)%gU}ocn?MCP=}';
$database = 'iitminda_visitor';

// Connect to MySQL
$conn = mysqli_connect($host, $user, $password, $database, $port);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Query to get entries grouped by date
$query = "
    SELECT DATE(created_at) AS entry_date, COUNT(*) AS total_entries
    FROM visitor
    WHERE table_name != 'exhibitor'
    GROUP BY DATE(created_at)
    ORDER BY entry_date DESC
";


$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query execution failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Visitor Entries</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f9;
            color: #333;
            padding: 40px;
        }
        h2 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 60%;
            margin: 0 auto 30px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        th, td {
            padding: 12px 16px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .links {
            text-align: center;
            margin-top: 30px;
        }
        .links a {
            text-decoration: none;
            padding: 10px 20px;
            margin: 0 10px;
            color: white;
            background-color: #28a745;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .links a:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<h2>Visitor Entries by Date</h2>

<table>
    <tr>
        <th>Date</th>
        <th>Total Entries</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= htmlspecialchars($row['entry_date']) ?></td>
            <td><?= htmlspecialchars($row['total_entries']) ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<div class="links">

    <a href="https://iitmindia.com/reg/spot/formtv.php" target="_blank">TV Form</a>
    <a href="https://iitmindia.com/reg/spot/search_form5.php" target="_blank">Print Manager</a>
</div>

</body>
</html>
<?php
// Free result and close connection
mysqli_free_result($result);
mysqli_close($conn);
?>
