<?php
$step = 5;

// Make sure $lead exists as an array for header3.php
$lead = [
    'lead_id'    => $lead_id ?? '',
    'company_id' => $company_id ?? ''
];

// Include header safely
include 'header3.php';
?>

Lead ID: <?= esc($lead['lead_id']) ?>
Company ID: <?= esc($lead['company_id']) ?>



<h2>Payment Summary</h2>
Total: ₹<?= number_format($total, 2) ?><br>
GST: ₹<?= number_format($gst, 2) ?><br>
Grand Total: ₹<?= number_format($grand_total, 2) ?>
<br>

<a href="<?= base_url('payment/'.$lead['lead_id']) ?>" 
   id="mainPaymentLink"
       class="btn-primary"
>   Proceed to Payment Gateway
</a>

