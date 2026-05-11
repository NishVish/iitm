<?php

// include your connection file
include 'header.php'; // or db.php if that's your filename

echo "<h2>Database: localtesting</h2>";

// =====================
// 1. Get all tables
// =====================
$tablesResult = $conn->query("SHOW TABLES");

if (!$tablesResult) {
    die("Error fetching tables: " . $conn->error);
}

echo "<h3>Tables:</h3>";
echo "<ul>";

$tables = [];

while ($row = $tablesResult->fetch_array()) {
    $tableName = $row[0];
    $tables[] = $tableName;
    echo "<li><b>$tableName</b></li>";
}

echo "</ul>";

// =====================
// 2. Get schema details
// =====================
echo "<h3>Schema Details:</h3>";

foreach ($tables as $table) {

    echo "<h4>Table: $table</h4>";

    $schemaQuery = "
        SELECT COLUMN_NAME, DATA_TYPE, IS_NULLABLE, COLUMN_KEY
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = 'localtesting'
        AND TABLE_NAME = '$table'
    ";

    $schemaResult = $conn->query($schemaQuery);

    if (!$schemaResult) {
        echo "Error fetching schema for $table<br>";
        continue;
    }

    echo "<table border='1' cellpadding='5'>";
    echo "<tr>
            <th>Column</th>
            <th>Type</th>
            <th>Nullable</th>
            <th>Key</th>
          </tr>";

    while ($col = $schemaResult->fetch_assoc()) {
        echo "<tr>
                <td>{$col['COLUMN_NAME']}</td>
                <td>{$col['DATA_TYPE']}</td>
                <td>{$col['IS_NULLABLE']}</td>
                <td>{$col['COLUMN_KEY']}</td>
              </tr>";
    }

    echo "</table><br>";
}

?>