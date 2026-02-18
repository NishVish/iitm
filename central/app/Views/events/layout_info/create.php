<?= view('header') ?>  <!-- loads app/Views/header.php -->
<?php
$segment1 = service('uri')->getSegment(1);

if ($segment1 == 'backend') : ?>
    <div class="submenu">
        <a href="<?= base_url('plan') ?>">Plan</a>
        <a href="<?= base_url('games') ?>">Play Games</a>
        <a href="<?= base_url('tv') ?>">TV</a>
        <a href="<?= base_url('company') ?>">View Companies</a>
        <a href="<?= base_url('company/add') ?>">Add Company</a>
    </div>
<?php endif; ?>

</div>

<div class="content">


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
