<?= view('backend/sidemenu') ?>  <!-- loads app/Views/header.php -->


<!DOCTYPE html>
<html>
<head>
    <title><?= esc($currentTable) ?> Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .nav {
            margin-bottom: 15px;
        }
        .nav a {
            margin-right: 10px;
            text-decoration: none;
            color: var(--button-color);
        }
    </style>
</head>
<body>

<h2>Table: <?= esc($currentTable) ?></h2>

<div class="nav">
    <strong>All Tables:</strong>
    <?php foreach ($alltables as $table): ?>
        <a href="<?= base_url('backend/tabledata/' . $table) ?>">
            <?= esc($table) ?>
        </a>
    <?php endforeach; ?>
</div>

<?php if (!empty($tablesdata)): ?>
    <table>
        <thead>
            <tr>
                <?php foreach (array_keys($tablesdata[0]) as $column): ?>
                    <th><?= esc($column) ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tablesdata as $row): ?>
                <tr>
                    <?php foreach ($row as $value): ?>
                        <td><?= esc($value) ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No data found in this table.</p>
<?php endif; ?>

</body>
</html>