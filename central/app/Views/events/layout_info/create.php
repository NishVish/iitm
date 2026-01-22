<?= view('header') ?>  <!-- loads app/Views/header.php -->


<h2>Add Layout</h2>

<?php if (session()->getFlashdata('success')): ?>
    <p style="color:green"><?= session()->getFlashdata('success') ?></p>
<?php endif; ?>

<form action="<?= base_url('layout-info/store') ?>" method="post" enctype="multipart/form-data">

    <label>Event / Venue</label><br>
    <select name="event_id" required>
        <option value="">-- Select Event --</option>
        <?php foreach ($events as $event): ?>
            <option value="<?= $event['event_id'] ?>">
                <?= esc($event['name']) ?> (<?= esc($event['venue_details']) ?>)
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Layout File</label><br>
    <input type="file" name="layout_file" required>
    <br><br>

    <button type="submit">Save</button>
</form>

</body>
</html>
