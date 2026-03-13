<h2>Booking Details</h2>

<h3>Company</h3>
<p><?= esc($company['company_name']) ?> | <?= esc($company['city']) ?> | <?= esc($company['state']) ?></p>

<h3>Lead</h3>
<p>Exhibition Year: <?= esc($lead['exhibition_year']) ?> | Location: <?= esc($lead['location']) ?></p>

<h3>Contacts</h3>
<?php foreach ($contacts as $c): ?>
    <p><?= esc($c['name']) ?> (<?= esc($c['designation']) ?>)<br>
    Emails: <?= implode(', ', array_column($c['emails'], 'email')) ?><br>
    Mobiles: <?= implode(', ', array_column($c['mobiles'], 'mobile')) ?></p>
<?php endforeach; ?>
