<?php if (!empty($images)): ?>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <?php foreach (array_keys($images[0]) as $key): ?>
                    <th><?= esc(ucfirst($key)) ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($images as $image): ?>
                <tr>
                    <?php foreach ($image as $key => $value): ?>
                        <td>
                            <?php if ($key === 'filename'): ?>
                                <img src="<?= base_url('uploads/' . $value) ?>" width="100">
                            <?php else: ?>
                                <?= esc($value) ?>
                            <?php endif; ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No image data found.</p>
<?php endif; ?>
