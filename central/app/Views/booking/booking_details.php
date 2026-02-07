<?php
include 'header.php';
?>

<h2>Step 3: Exhibition Details & Payment</h2>

<form method="post" action="<?= site_url('booking/processPayment') ?>">
    <!-- Hidden fields for lead and company -->
    <input type="hidden" name="lead_id" value="<?= esc($lead['lead_id']) ?>">
    <input type="hidden" name="company_id" value="<?= esc($company['company_id']) ?>">

    <label>Exhibition Location</label>
    <input type="text" name="location" value="<?= esc($lead['location']) ?>" readonly><br><br>

    <label>Stall No</label>
    <input type="text" name="stall_no" value="<?= esc($lead['stall_location'] ?? '') ?>" required><br><br>

    <label>Size (sqm)</label>
    <input type="number" name="size" value="<?= esc($lead['size'] ?? '') ?>" required><br><br>

    <label>Fascia Name</label>
    <input type="text" name="fascia_name" value="<?= esc($lead['fascia'] ?? '') ?>" required><br><br>

    <label>Price</label>
    <input type="number" step="0.01" name="price" value="<?= esc($lead['price'] ?? '') ?>" required><br><br>

    <button type="submit"        style="padding:10px 20px; background:#4CAF50; color:white; border-radius:5px; text-decoration:none;">
Calculate & Proceed to Payment</button>
</form>
