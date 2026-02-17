<?php
$step = 1;
include 'header3.php';
?>
<title>Instructions Page</title>

<h2 style="text-align:center; margin-bottom:10px;">Step 1: Instructions to Participate as an Exhibitor in IITM</h2>

<!-- Full-width Welcome Card -->
<div class="card full-width">
    <p>
            <h3>Welcome</h3>
Thank you for your interest in exhibiting at the <strong>India International Travel Mart (IITM)</strong>.
        Please read the following instructions carefully before starting the registration process.
        This will help ensure a smooth and successful booking experience.
    </p>
</div>

<!-- Row of short cards with icons -->
<div class="card-row">

    <div class="card short-card">
        <div class="card-icon">📋</div>
        <h3>Important Guidelines</h3>
        <ul>
            <li>Complete registration within <strong>15 minutes</strong>.</li>
            <li>Keep <strong>company details, GST, and contact info</strong> ready.</li>
            <li>Ensure all info is <strong>accurate and final</strong>.</li>
            <li>Stall allocation depends on <strong>availability & payment</strong>.</li>
        </ul>
    </div>

    <div class="card short-card">
        <div class="card-icon">🛠️</div>
        <h3>Step-by-Step Process</h3>
        <ul>
            <li><strong>Step 1:</strong> Instructions & guidelines.</li>
            <li><strong>Step 2:</strong> Company details & billing info.</li>
            <li><strong>Step 3:</strong> Stall selection & GST calculation.</li>
            <li><strong>Step 4:</strong> Complete payment (min 25% advance).</li>
        </ul>
    </div>

    <div class="card short-card">
        <div class="card-icon">💰</div>
        <h3>Payment & Confirmation</h3>
        <ul>
            <li>Minimum <strong>25% payment</strong> to block space.</li>
            <li>Remaining balance as per payment schedule.</li>
            <li>Receive confirmation notification after payment.</li>
        </ul>
    </div>

</div>

<!-- Final Step Card -->
<div class="card full-width">
    <p>
        By clicking <strong>“Proceed to Step 2”</strong>, you confirm that you have read and understood the instructions
        and agree to continue with the exhibitor registration process.
    </p>
<div style="text-align: right; padding-right: 10px;">
    <a href="<?= site_url('booking/company/'.$lead['lead_id']) ?>" class="btn-next">Proceed to Step 2</a>
</div>



</div>

<style>
/* General Card Styles */
.card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    padding: 25px 30px;
    margin: 20px auto;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.15);
}

.card h3 {
    margin-top: 0;
    color: #c03b31;
    border-bottom: 2px solid #c03b31;
    display: inline-block;
    padding-bottom: 5px;
}

.card ul {
    margin: 15px 0 0 20px;
    padding: 0;
}

.card p {
    margin: 10px 0 0 0;
    line-height: 1.6;
}

/* Full-width cards */
/* Full-width cards aligned with row of short cards */
.card.full-width {
    width: 100%;
    max-width: 900px; /* matches the row */
    box-sizing: border-box; /* include padding in width */
}

/* Row of short cards */
.card-row {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;
    max-width: 900px; /* same as full-width cards */
    margin: 0 auto; /* center the row */
}


.card.short-card {
    flex: 1 1 250px;
    max-width: 230px;
    position: relative;
    padding-top: 10px;
    background: linear-gradient(145deg, #ffe6e6, #fff5f5);
}

/* Card icons */
.card-icon {
    position: absolute;
    top: -25px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 32px;
}

/* Proceed button */
.btn-next {
    display: inline-block;
    margin-top: 15px;
    padding: 12px 25px;
    background: linear-gradient(135deg, #c03b31, #bd3b08);
    color: #fff;
    font-weight: 600;
    border-radius: 8px;
    text-decoration: none;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.btn-next:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(172, 64, 31, 0.35);
}

/* Responsive adjustments */
@media (max-width: 900px) {
    .card-row {
        flex-direction: column;
        align-items: center;
    }

    .card.short-card {
        max-width: 90%;
        padding-top: 50px;
    }
}
</style>
