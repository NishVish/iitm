<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profile Submitted | IITM</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">

<style>

:root{
    --primary: <?= $badge_color ?? '#a42627' ?>;
    --dark:#1a1a1a;
    --bg:#eef2f5;
}

body{
    font-family:'Inter',sans-serif;
    background:var(--bg);
    padding:20px;
    color:#333;
}

.main-wrapper{
    max-width:900px;
    margin:auto;
    display:flex;
    flex-wrap:wrap;
    gap:30px;
    justify-content:center;
}

.content-section{
    flex:1;
    min-width:320px;
    padding-top:20px;
}

.logo-main{
    width:80px;
    margin-bottom:20px;
}

.confirmation-label{
    color:#f39c12;
    font-weight:700;
    text-transform:uppercase;
    font-size:14px;
    display:flex;
    align-items:center;
    gap:8px;
}

.receipt-container{
    flex:0 0 360px;
    filter:drop-shadow(0 10px 20px rgba(0,0,0,0.08));
}

.receipt{
    background:white;
    border-radius:4px 4px 0 0;
}

.receipt-header{
    padding:30px 20px 20px;
    text-align:center;
    border-bottom:2px dashed #eee;
}

.receipt-body{
    padding:30px 25px;
}

.qr-box{
    background:#fcfcfc;
    border:1px solid #eee;
    padding:15px;
    border-radius:12px;
    margin:0 auto 25px;
    width:fit-content;
}

.info-row{
    display:flex;
    justify-content:space-between;
    margin-bottom:15px;
    font-size:14px;
}

.info-label{
    color:#888;
    text-transform:uppercase;
    font-size:11px;
    font-weight:700;
}

.info-value{
    font-weight:600;
    color:var(--dark);
    text-align:right;
}

.ref-code{
    font-family:'JetBrains Mono',monospace;
    background:#f4f4f4;
    display:block;
    text-align:center;
    padding:10px;
    font-size:18px;
    letter-spacing:2px;
    margin-top:20px;
    border:1px solid #ddd;
}

.receipt-footer{
    background:white;
    padding:20px;
    text-align:center;
    position:relative;
}

.zigzag{
    position:absolute;
    bottom:-15px;
    left:0;
    width:100%;
    height:15px;
    background:
    linear-gradient(-45deg,var(--bg) 8px,transparent 0),
    linear-gradient(45deg,var(--bg) 8px,transparent 0);
    background-size:16px 16px;
}

.status-badge{
    background:var(--primary);
    color:white;
    padding:5px 15px;
    border-radius:50px;
    font-size:12px;
    font-weight:700;
}

@media print{
.no-print{display:none;}
body{background:white;padding:0;}
.receipt-container{filter:none;}
.main-wrapper{display:block;}
}

</style>
</head>

<body>

<div class="main-wrapper">

<div class="content-section">

<img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" class="logo-main">

<div class="confirmation-label">

<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM7 10l3-3-1-1-2 2-1-1-1 1 2 2z"/>
</svg>

Profile Submitted

</div>

<h2 class="mt-3 fw-bold">Profile Under Review</h2>

<p class="text-muted">
Hello <?= esc(ucwords(strtolower(trim($alldata['contactName'] ?? 'Visitor')))) ?>,
</p>

<p>
Thank you for submitting your profile for 
<strong><?= esc($event[0]['name'] ?? 'the Event'); ?></strong>.
</p>

<p>
Our team will carefully review your profile. Once the verification is completed,
we will notify you with further updates regarding your participation.
</p>

<div class="alert alert-warning border-0 small">

<strong>Note:</strong>
Please keep this reference for your records. Once your profile is approved,
you will receive confirmation along with badge and entry instructions.

</div>

<div class="mt-4 no-print">

<button onclick="window.print()" class="btn btn-dark px-4">
Print / Save Receipt
</button>

<p class="mt-2 small text-muted">
You may also take a screenshot for your reference.
</p>

</div>

</div>

<div class="receipt-container">

<div class="receipt">

<div class="receipt-header">

<span class="status-badge">
UNDER REVIEW
</span>

<h5 class="mt-3 mb-1 fw-bold">
<?= esc($event[0]['name'] ?? 'IITM Event'); ?>
</h5>

<p class="small text-muted mb-0">
<?= esc($event[0]['venue_details'] ?? 'Venue Details'); ?>
</p>

</div>

<div class="receipt-body">

<div class="qr-box">

<img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=<?= urlencode($mobile ?? '30053610') ?>">

</div>

<div class="info-row">

<span class="info-label">
Name
</span>

<span class="info-value">
<?= esc($alldata['contactName'] ?? 'Visitor') ?>
</span>

</div>

<div class="info-row">

<span class="info-label">
Company
</span>

<span class="info-value">
<?= esc($alldata['companyName'] ?? 'Not Specified') ?>
</span>

</div>

<div class="info-row">

<span class="info-label">
City
</span>

<span class="info-value">
<?= strtoupper($citySuffix ?? 'Pune') ?>
</span>

</div>

<div class="mt-4">

<span class="info-label">
Submission Reference
</span>

<code class="ref-code">
<?= $mobile ?? '30053610' ?>
</code>

</div>

</div>

<div class="receipt-footer">

<p class="small text-muted mb-0">
Reference ID for your submission
</p>

<div class="zigzag"></div>

</div>

</div>

</div>

</div>

</body>
</html>