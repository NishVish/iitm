<?php
include 'header.php';
?>


<h2>Step 2: Confirm Company & Contact Details</h2>

<h3>Company Details</h3>
<p>Name: <?= esc($company['company_name']) ?></p>
<p>Category: <?= esc($company['category']) ?></p>
<p>City: <?= esc($company['city']) ?></p>

<h3>Contact Persons</h3>
<?php foreach($contacts as $c): ?>
    <p>
        <?= esc($c['name']) ?> (<?= esc($c['designation']) ?>)<br>
        <?= esc($c['mobile']) ?> | <?= esc($c['email']) ?>
    </p>
<?php endforeach; ?>

<a href="<?= site_url('exhibitor/exhibition/'.$company['company_id']) ?>">Proceed to Step 3</a>
