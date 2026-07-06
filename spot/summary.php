<?php
include('db.php');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query count by day for exhibitor
$sql_exhibitor = "
    SELECT DATE(created_at) AS date, COUNT(*) AS count
    FROM exhibitor
    GROUP BY DATE(created_at)
    ORDER BY DATE(created_at) DESC
";

// Query count by day for tradevisitor
$sql_tradevisitor = "
    SELECT DATE(created_at) AS date, COUNT(*) AS count
    FROM tradevisitor
    GROUP BY DATE(created_at)
    ORDER BY DATE(created_at) DESC
";

$result_exhibitor = $conn->query($sql_exhibitor);
$result_tradevisitor = $conn->query($sql_tradevisitor);

// Collect data into arrays
$exhibitor_counts = [];
$tradevisitor_counts = [];

while ($row = $result_exhibitor->fetch_assoc()) {
    $exhibitor_counts[$row['date']] = $row['count'];
}
while ($row = $result_tradevisitor->fetch_assoc()) {
    $tradevisitor_counts[$row['date']] = $row['count'];
}

// Get all dates from both sets
$all_dates = array_unique(array_merge(array_keys($exhibitor_counts), array_keys($tradevisitor_counts)));
rsort($all_dates); // Sort dates descending

?>

<!DOCTYPE html>
<html>
<head>
    <title>Entries Count by Day</title>
    <style>
        table { border-collapse: collapse; width: 60%; margin: 20px auto; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Entries Count by Day</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th><a href="exhibitor.php">Exhibitor Count</a></th>
                <th><a href="tradevisitor.php">Trade Visitor Count</a></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($all_dates as $date): ?>
                <tr>
                    <td><?= htmlspecialchars($date) ?></td>
                    <td><?= isset($exhibitor_counts[$date]) ? $exhibitor_counts[$date] : 0 ?></td>
                    <td><?= isset($tradevisitor_counts[$date]) ? $tradevisitor_counts[$date] : 0 ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>
