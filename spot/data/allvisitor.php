<?php
$host = '21.157.66.148.host.secureserver.net';
$user = 'iitminda_master';
$password = 'gB)%gU}ocn?MCP=}';
$database = 'iitminda_visitor';

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "
SELECT
    v.visitorid,
    v.created_at AS visitor_time,
    'tradev' AS source_table,
        t.id,

    CONCAT_WS(' ', t.title, t.select2, t.name) AS name,
    t.designation,
    t.organisation AS company,
    t.email,
    t.phone AS mobile,
    t.address,
    t.city,
    t.pincode,
    t.state,
    t.country
FROM visitor v
JOIN iitminda_iitmindia_2024.tradev t
    ON t.id = v.id
WHERE v.database_name = 'iitminda_iitmindia_2024'
  AND v.table_name = 'tradev'
  AND v.created_at > '2025-12-04 09:42:36'

UNION ALL

SELECT
    v.visitorid,
    v.created_at AS visitor_time,
    'tradevisitor' AS source_table,
    tv.person_key As id,

    tv.name,
    tv.designation,
    tv.company_name AS company,
    tv.email,
    tv.mobile,
    tv.address,
    tv.city,
    tv.pin AS pincode,
    tv.state,
    NULL AS country
FROM visitor v
JOIN iitminda_form_data.tradevisitor tv
    ON tv.id = v.id
WHERE v.database_name = 'iitminda_form_data'
  AND v.table_name = 'tradevisitor'
  AND v.created_at > '2025-12-04 09:42:36'

ORDER BY visitor_time DESC
LIMIT 2000
";

$result = mysqli_query($conn, $sql);


if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Visitors List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #007BFF;
            color: #fff;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        tr:hover {
            background: #e9f5ff;
        }
    </style>
</head>

<body>
    <a href="./">Back</a>

    <h2>Visitors Entries</h2>

    <table>
        <thead>
            <tr>
                <th>Visitor ID</th>
                <th>Visitor Time</th>
                <th>Source</th>
                <th>id</th>
                <th>Name</th>
                <th>Designation</th>
                <th>Company</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Address</th>
                <th>City</th>
                <th>Pincode</th>
                <th>State</th>
                <th>Country</th>
            </tr>
        </thead>
        <tbody>

            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['visitorid']}</td>";
                    echo "<td>{$row['visitor_time']}</td>";
                    echo "<td>{$row['source_table']}</td>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['designation']}</td>";
                    echo "<td>{$row['company']}</td>";
                    echo "<td>{$row['email']}</td>";
                    echo "<td>{$row['mobile']}</td>";
                    echo "<td>{$row['address']}</td>";
                    echo "<td>{$row['city']}</td>";
                    echo "<td>{$row['pincode']}</td>";
                    echo "<td>{$row['state']}</td>";
                    echo "<td>" . ($row['country'] ?? '-') . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='13' style='text-align:center;'>No records found.</td></tr>";
            }

            mysqli_close($conn);
            ?>

        </tbody>
    </table>

</body>

</html>