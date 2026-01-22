<?= view('header') ?>  <!-- loads app/Views/header.php -->

    <h1>Database Schema | <a href="<?= site_url('backend/sql') ?>" class="btn btn-primary">
    SQL Runner
</a>
</h1>

    <?php foreach ($dbSchema as $table => $columns): ?>
        <h2>Table: <?= $table ?></h2>
        <table>
            <tr>
                <th>Column Name</th>
                <th>Type</th>
                <th>Max Length</th>
                <th>Primary Key</th>
                <th>Default</th>
            </tr>
            <?php foreach ($columns as $col): ?>
                <tr>
                    <td><?= $col->name ?></td>
                    <td><?= $col->type ?></td>
                    <td><?= $col->max_length ?></td>
                    <td><?= $col->primary_key ? 'Yes' : 'No' ?></td>
                    <td><?= $col->default ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endforeach; ?>

</body>
</html>
