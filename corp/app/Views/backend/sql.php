<?= view('backend/sidemenu') ?>  <!-- loads app/Views/header.php -->

<h3>Saved SQL Tickets</h3>

<?php if (!empty($sql_tickets)): ?>

<table border="1" cellpadding="6" style="border-collapse:collapse;width:100%">
<tr style="background:#f2f2f2">
    <th>ID</th>
    <th>Title</th>
    <th>Description (SQL)</th>
    <th>Created</th>
    <th>Use</th>
</tr>

<?php foreach ($sql_tickets as $ticket): ?>

<tr>
    <td><?= esc($ticket['id']) ?></td>
    <td><?= esc($ticket['title']) ?></td>
    <td style="font-family:monospace;">
        <?= esc($ticket['description']) ?>
    </td>
    <td><?= esc($ticket['created_at']) ?></td>

    <td>
        <button onclick="useQuery(`<?= esc($ticket['description'], 'js') ?>`)">
            Use
        </button>
    </td>
</tr>

<?php endforeach; ?>

</table>

<?php else: ?>
<p>No SQL tickets found.</p>
<?php endif; ?>
<h2>SQL Query Runner</h2>
<p>Delete queries</p>
<button type="button" onclick="fillQuery()">Fill Delete Query</button>

<form method="post" action="<?= site_url('backend/sql') ?>">
    <?= csrf_field() ?>

    <textarea id="sqlQuery" name="sql" rows="10" style="width:100%; font-family: monospace;">
<?= esc($sql ?? '') ?>
    </textarea>

    <br>
    <button type="submit">Run Query</button>
</form>

<script>
function fillQuery() {
    // The query you want to insert
    const query = "DELETE FROM company_data WHERE session > 1;";
    // Put it into the textarea
    document.getElementById('sqlQuery').value = query;
}
</script>


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
