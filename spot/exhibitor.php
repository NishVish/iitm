<?php
include 'db.php'; // your DB connection file

// Query all rows from exhibitor
$sql = "SELECT * FROM exhibitor";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Exhibitor Table</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
    </style>
</head>
<body>

<h2>All Exhibitors</h2>

<?php if ($result && $result->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <?php
                // Print column headers dynamically
                while ($fieldinfo = $result->fetch_field()) {
                    echo "<th>" . htmlspecialchars($fieldinfo->name) . "</th>";
                }
                // Reset pointer back to first row
                $result->data_seek(0);
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            // Print all rows
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                foreach ($row as $cell) {
                    echo "<td>" . htmlspecialchars($cell) . "</td>";
                }
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No records found.</p>
<?php endif; ?>

</body>
</html>
