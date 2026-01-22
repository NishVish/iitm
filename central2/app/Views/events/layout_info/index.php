<?= view('header') ?>  <!-- loads app/Views/header.php -->

<h2>Layout Information</h2>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Event Name</th>
            <th>Venue</th>
            <th>Event Dates</th>
            <th>Layout Date</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($layouts)): ?>
            <?php foreach ($layouts as $i => $row): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= esc($row['name']) ?></td>
                    <td><?= esc($row['venue_details']) ?></td>
                    <td>
                        <?= esc($row['start_date']) ?>
                        to
                        <?= esc($row['end_date']) ?>
                    </td>
                    <td><?= esc($row['layout_date']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">No layouts found</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
