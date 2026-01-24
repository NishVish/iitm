<?= view('header') ?>

<h2>Source Preview</h2>

<?php foreach($companies as $company): ?>
    <p><strong>Company ID:</strong> <?= esc($company['company_id'] ?? '-') ?></p>
    <p><strong>Source ID:</strong> <?= esc($company['source_id'] ?? '-') ?></p>
    <p><strong>Event Date:</strong> <?= esc($company['event_date'] ?? '-') ?></p>
    <p><strong>Notes:</strong> <?= esc($company['notes'] ?? '-') ?></p>
    <hr>
<?php endforeach; ?>
