
<?php if(session()->getFlashdata('message')): ?>
    <p style="color: green;"><?= session()->getFlashdata('message') ?></p>
<?php endif; ?>

<?php if (!empty($announcements) && is_array($announcements)): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Topic</th>
                <th>Info</th>
                <th>Department</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($announcements as $announcement): ?>
                <tr>
                    <td><?= esc($announcement['id']) ?></td>
                    <td><?= esc($announcement['date']) ?></td>
                    <td><?= esc($announcement['topic']) ?></td>
                    <td><?= esc($announcement['info']) ?></td>
                    <td><?= esc($announcement['department']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No announcements found.</p>
<?php endif; ?>