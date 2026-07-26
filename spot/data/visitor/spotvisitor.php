<?php

$host = '21.157.66.148.host.secureserver.net';
$user = 'iitminda_master';
$password = 'gB)%gU}ocn?MCP=}';
$database = 'iitminda_form_data';

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "
SELECT
    v.visitorid,
    v.created_at AS visitor_time,
    tv.*
FROM visitor v
JOIN tradevisitor tv
    ON tv.id = v.id
WHERE v.database_name = 'iitminda_form_data'
    AND v.table_name = 'tradevisitor'
    AND v.created_at > '2026-07-21 09:42:36'
";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}

echo "<table border='1' cellpadding='8' cellspacing='0'>";

// Print table header
$firstRow = true;

while ($row = mysqli_fetch_assoc($result)) {

    if ($firstRow) {
        echo "<tr>";
        foreach (array_keys($row) as $column) {
            echo "<th>" . htmlspecialchars($column) . "</th>";
        }
        echo "</tr>";
        $firstRow = false;
    }

    // Print table data
    echo "<tr>";
    foreach ($row as $value) {
        echo "<td>" . htmlspecialchars($value) . "</td>";
    }
    echo "</tr>";
}

echo "</table>";

mysqli_close($conn);

?>