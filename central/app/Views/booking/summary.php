<?php
$step = 5;
include 'header3.php';
?>

<h2 style="text-align:center; margin-bottom:20px;">Booking Summary</h2>

<table style="width:100%; border-collapse: collapse; font-family: Arial, sans-serif;">
    <!-- Company Details -->
    <tr style="background-color:#f2f2f2;">
        <th colspan="2" style="padding:10px; text-align:left; border:1px solid #ddd;">Company Details</th>
    </tr>
    <tr>
        <td style="padding:8px; border:1px solid #ddd;"><strong>Company:</strong></td>
        <td style="padding:8px; border:1px solid #ddd;"><?= esc($company['company_name']) ?></td>
    </tr>
    <tr>
        <td style="padding:8px; border:1px solid #ddd;"><strong>City:</strong></td>
        <td style="padding:8px; border:1px solid #ddd;"><?= esc($company['city']) ?></td>
    </tr>
    <tr>
        <td style="padding:8px; border:1px solid #ddd;"><strong>GST:</strong></td>
        <td style="padding:8px; border:1px solid #ddd;"><?= esc($company['gst_number']) ?></td>
    </tr>
    <tr>
        <td style="padding:8px; border:1px solid #ddd;"><strong>Sales Person:</strong></td>
        <td style="padding:8px; border:1px solid #ddd;"><?= esc($lead['sales_person']) ?></td>
    </tr>

    <!-- Stall Details -->
    <tr style="background-color:#f2f2f2;">
        <th colspan="2" style="padding:10px; text-align:left; border:1px solid #ddd;">Stall Details</th>
    </tr>
    <tr>
        <td style="padding:8px; border:1px solid #ddd;"><strong>Location:</strong></td>
        <td style="padding:8px; border:1px solid #ddd;"><?= esc($lead['location']) ?></td>
    </tr>
    <tr>
        <td style="padding:8px; border:1px solid #ddd;"><strong>Stall Size:</strong></td>
        <td style="padding:8px; border:1px solid #ddd;"><?= esc($lead['size']) ?></td>
    </tr>
    <tr>
        <td style="padding:8px; border:1px solid #ddd;"><strong>Fascia Name:</strong></td>
        <td style="padding:8px; border:1px solid #ddd;"><?= esc($lead['fascia']) ?></td>
    </tr>
    <tr>
        <td style="padding:8px; border:1px solid #ddd;"><strong>Stall Preference:</strong></td>
        <td style="padding:8px; border:1px solid #ddd;"><?= esc($lead['stall_location']) ?></td>
    </tr>

    <!-- Payment Summary -->
    <tr style="background-color:#f2f2f2;">
        <th colspan="2" style="padding:10px; text-align:left; border:1px solid #ddd;">Payment Summary</th>
    </tr>
    <tr>
        <td style="padding:8px; border:1px solid #ddd;"><strong>Base Price:</strong></td>
        <td style="padding:8px; border:1px solid #ddd;">₹<?= esc($lead['price']) ?></td>
    </tr>
    <tr>
        <td style="padding:8px; border:1px solid #ddd;"><strong>GST (18%):</strong></td>
        <td style="padding:8px; border:1px solid #ddd;">₹<?= esc($lead['gst_amount']) ?></td>
    </tr>
    <tr>
        <td style="padding:8px; border:1px solid #ddd;"><strong>Discount:</strong></td>
        <td style="padding:8px; border:1px solid #ddd;">₹<?= esc($lead['discount_amount']) ?></td>
    </tr>
    <tr style="background-color:#ffe6e6;">
        <td style="padding:8px; border:1px solid #ddd; font-weight:bold;">Grand Total:</td>
        <td style="padding:8px; border:1px solid #ddd; font-weight:bold; color:#c03b31;">₹<?= esc($lead['grand_total']) ?></td>
    </tr>
</table>
