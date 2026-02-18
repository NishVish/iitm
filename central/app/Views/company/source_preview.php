<?= view('header') ?>
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

<h2>Source Preview</h2>

<?php foreach($companies as $company): ?>
    <p><strong>Company ID:</strong> <?= esc($company['company_id'] ?? '-') ?></p>
    <p><strong>Source ID:</strong> <?= esc($company['source_id'] ?? '-') ?></p>
    <p><strong>Event Date:</strong> <?= esc($company['event_date'] ?? '-') ?></p>
    <p><strong>Notes:</strong> <?= esc($company['notes'] ?? '-') ?></p>
    <hr>
<?php endforeach; ?>
