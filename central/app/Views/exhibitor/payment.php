<?php
include 'header.php';
?>

<h2>Payment Summary</h2>
<p>Price: <?= esc($price) ?></p>
<p>GST (18%): <?= esc($gst) ?></p>
<p><strong>Grand Total: <?= esc($grand_total) ?></strong></p>

<a href="/payment/gateway">Proceed to Payment Gateway</a>
