<?= view('header') ?>  <!-- loads app/Views/header.php -->


<h2>SQL Query Runner</h2>

<form method="post" action="<?= site_url('backend/sql/run') ?>">
    <?= csrf_field() ?>

    <textarea name="sql" rows="10" style="width:100%; font-family: monospace;">
<?= esc($sql ?? '') ?>
    </textarea>

    <br><br>
    <button type="submit">Run Query</button>
</form>

<hr>

<?php if (!empty($error)): ?>
    <div style="color:red;">
        <strong>Error:</strong> <?= esc($error) ?>
    </div>
<?php endif; ?>

<?php if (!empty($message)): ?>
    <div style="color:green;">
        <?= esc($message) ?>
    </div>
<?php endif; ?>

<?php if (!empty($results)): ?>
    <table border="1" cellpadding="5">
        <tr>
            <?php foreach (array_keys($results[0]) as $col): ?>
                <th><?= esc($col) ?></th>
            <?php endforeach; ?>
        </tr>

        <?php foreach ($results as $row): ?>
            <tr>
                <?php foreach ($row as $cell): ?>
                    <td><?= esc($cell) ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
