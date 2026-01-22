<?php
include 'header.php';
?>

<h2>Step 3: Exhibition Details & Payment</h2>

<form method="post" action="<?= site_url('exhibitor/processPayment') ?>">
    <input type="hidden" name="company_id" value="<?= esc($company['company_id']) ?>">

    <label>Exhibition Location</label>
    <select name="location" required>
        <?php foreach($exhibitions as $e): ?>
            <option value="<?= esc($e['location']) ?>"><?= esc($e['location']) ?> (<?= esc($e['year']) ?>)</option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Stall No</label>
    <input type="text" name="stall_no" required><br><br>

    <label>Size (sqm)</label>
    <input type="number" name="size" required><br><br>

    <label>Fascia Name</label>
    <input type="text" name="fascia_name" required><br><br>

    <label>Price</label>
    <input type="number" name="price" required><br><br>

    <button type="submit">Calculate & Proceed to Payment</button>
</form>
