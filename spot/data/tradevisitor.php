<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = '21.157.66.148.host.secureserver.net';
$user = 'iitminda_master';
$password = 'gB)%gU}ocn?MCP=}';

$databases = [

    'tradevisitor' => [
        'db' => 'iitminda_form_data',
        'table' => 'tradevisitor',
        'order_by' => 'created_at',
        'label' => 'Trade Visitor'
    ],

    'tradev' => [
        'db' => 'iitminda_iitmindia_2024',
        'table' => 'tradev',
        'order_by' => 'date_reg',
        'label' => 'Trade Visitor 2024'
    ],

    'visitor' => [
        'db' => 'iitminda_visitor',
        'table' => 'visitor',
        'order_by' => 'created_at',
        'label' => 'Visitor'
    ],

    'exhibitor' => [
        'db' => 'iitminda_form_data',
        'table' => 'exhibitor',
        'order_by' => 'created_at',
        'label' => 'Exhibitor'
    ]

];


$selected = $_GET['view'] ?? array_key_first($databases);

if (!isset($databases[$selected])) {
    $selected = array_key_first($databases);
}


$config = $databases[$selected];

$conn = mysqli_connect(
    $host,
    $user,
    $password,
    $config['db']
);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$sql = "SELECT * FROM `{$config['table']}` 
        ORDER BY `{$config['order_by']}` DESC 
        LIMIT 2000";


$result = mysqli_query($conn, $sql);


if (!$result) {
    die("SQL Error: " . mysqli_error($conn));
}

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Database Viewer</title>

    <style>
        body {
            font-family: Arial;
            margin: 20px;
            background: #f5f5f5;
        }

        .buttons {
            margin-bottom: 20px;
        }

        .buttons a {
            display: inline-block;
            padding: 10px 18px;
            margin: 5px;
            background: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .buttons a:hover,
        .buttons .active {
            background: #0056b3;
        }


        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            white-space: nowrap;
        }

        th {
            background: #333;
            color: white;
        }

        .table-container {
            overflow: auto;
            max-height: 80vh;
        }
    </style>

</head>


<body>


    <h2>Database Viewer</h2>


    <div class="buttons">

        <?php foreach ($databases as $key => $item): ?>

            <a class="<?= ($selected == $key ? 'active' : '') ?>" href="?view=<?= urlencode($key) ?>">
                <?= htmlspecialchars($item['label']) ?>
            </a>

        <?php endforeach; ?>

    </div>



    <h3>
        Database : <?= htmlspecialchars($config['db']) ?><br>
        Table : <?= htmlspecialchars($config['table']) ?>
    </h3>



    <div class="table-container">


        <?php

        if (mysqli_num_rows($result) > 0) {

            echo "<table>";

            $fields = mysqli_fetch_fields($result);


            echo "<tr>";

            foreach ($fields as $field) {
                echo "<th>" . htmlspecialchars($field->name) . "</th>";
            }

            echo "</tr>";



            while ($row = mysqli_fetch_assoc($result)) {

                echo "<tr>";

                foreach ($fields as $field) {

                    echo "<td>" .
                        htmlspecialchars($row[$field->name] ?? '') .
                        "</td>";

                }

                echo "</tr>";

            }


            echo "</table>";

        } else {

            echo "<p>No records found.</p>";

        }


        mysqli_close($conn);

        ?>

    </div>


</body>

</html>