<?php

$host = '21.157.66.148.host.secureserver.net';
$user = 'iitminda_master';
$password = 'gB)%gU}ocn?MCP=}';
$database = 'iitminda_form_data';

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query: Get data from tradevisitor using visitor table
$sql = "
SELECT
    v.visitorid,
    v.created_at AS visitor_time,
    tv.*
FROM iitminda_visitor.visitor AS v
JOIN iitminda_form_data.tradevisitor AS tv
    ON tv.id = v.id
WHERE v.database_name = 'iitminda_form_data'
  AND v.table_name = 'tradevisitor'
  AND v.created_at > '2026-07-14 09:42:36'
";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}

echo "<table border='1' cellpadding='8' cellspacing='0'>";

if (mysqli_num_rows($result) > 0) {

    // Table Header
    $fields = mysqli_fetch_fields($result);

    echo "<tr>";
    foreach ($fields as $field) {
        echo "<th>" . htmlspecialchars($field->name) . "</th>";
    }
    echo "</tr>";

    // Reset pointer
    mysqli_data_seek($result, 0);

    // Table Data
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>" . htmlspecialchars($value ?? '') . "</td>";
        }
        echo "</tr>";
    }

} else {
    echo "<tr><td>No records found.</td></tr>";
}

echo "</table>";

mysqli_free_result($result);
mysqli_close($conn);

?>