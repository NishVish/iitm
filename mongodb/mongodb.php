<?php
require 'vendor/autoload.php';

use MongoDB\Client;

// Connect to MongoDB
$client = new Client("mongodb://localhost:27017");
$collection = $client->mydb->users;

// ---------------------------
// HANDLE OPERATIONS
// ---------------------------

// INSERT
if (isset($_POST['insert'])) {
    $collection->insertOne([
        "name" => $_POST['name'],
        "age" => (int) $_POST['age']
    ]);
}

// UPDATE
if (isset($_POST['update'])) {
    $collection->updateOne(
        ["name" => $_POST['name']],
        ['$set' => ["age" => (int) $_POST['age']]]
    );
}

// DELETE
if (isset($_POST['delete'])) {
    $collection->deleteOne([
        "name" => $_POST['name']
    ]);
}

// CUSTOM QUERY (JSON input)
$customResult = null;
if (isset($_POST['query'])) {
    $json = $_POST['query_text'];
    $filter = json_decode($json, true);

    if (is_array($filter)) {
        $customResult = $collection->find($filter);
    }
}

// GET ALL DATA
$data = $collection->find();
?>

<!DOCTYPE html>
<html>

<head>
    <title>MongoDB CRUD</title>
    <style>
        body {
            font-family: Arial;
            margin: 20px;
        }

        input,
        textarea {
            margin: 5px;
            padding: 8px;
            width: 300px;
        }

        button {
            padding: 8px 12px;
            margin: 5px;
        }

        .box {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <h2>MongoDB CRUD + Query Panel</h2>

    <!-- INSERT -->
    <div class="box">
        <h3>Insert / Update / Delete</h3>

        <form method="post">
            <input type="text" name="name" placeholder="Name" required><br>
            <input type="number" name="age" placeholder="Age"><br>

            <button name="insert">Insert</button>
            <button name="update">Update</button>
            <button name="delete">Delete</button>
        </form>
    </div>

    <!-- CUSTOM QUERY -->
    <div class="box">
        <h3>Custom Query (JSON)</h3>

        <form method="post">
            <textarea name="query_text" placeholder='Example: {"age": 20}'></textarea><br>
            <button name="query">Run Query</button>
        </form>

        <?php if ($customResult): ?>
            <h4>Result:</h4>
            <?php foreach ($customResult as $doc): ?>
                <pre><?php print_r($doc); ?></pre>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- SHOW ALL DATA -->
    <div class="box">
        <h3>All Users</h3>

        <?php foreach ($data as $doc): ?>
            <div>
                <b>Name:</b> <?= $doc['name'] ?> |
                <b>Age:</b> <?= $doc['age'] ?>
            </div>
        <?php endforeach; ?>

    </div>

</body>

</html>