<?php $badge_color = '#c58940'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Event Badge</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Modern Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
:root{
    --primary: <?= $badge_color ?>;
    --dark: #111827;
    --gray: #6b7280;
    --light: #f9fafb;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family: 'Inter', sans-serif;
    background: linear-gradient(135deg,#f3f4f6,#e5e7eb);
    color: var(--dark);
    text-align:center;
}

.page-wrapper{
    padding:60px 20px;
    max-width:1000px;
    margin:auto;
}

/* ===== HEADER ===== */
#headder{
    background: linear-gradient(135deg,var(--primary),#a8742f);
    color:white;
    padding:40px 20px;
    border-radius:16px;
    box-shadow:0 10px 30px rgba(0,0,0,0.15);
    margin-bottom:40px;
}

#event-name{
    font-size:26px;
    font-weight:600;
    letter-spacing:.5px;
}

/* ===== BADGE WRAPPER ===== */
.both-wrapper{
    display:flex;
    justify-content:center;
    margin:auto;
    background:white;
    padding:40px;
    border-radius:20px;
    box-shadow:0 15px 40px rgba(0,0,0,0.08);
}

.badge{
    width:360px;
    height:520px;
    border-radius:18px;
    overflow:hidden;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    background:white;
    border:1px solid #eee;
    position:relative;
}

/* HEADER INSIDE BADGE */
.badge-header{
    background: linear-gradient(135deg,var(--primary),#a8742f);
    color:white;
    padding:20px;
}

.logo-white{
    width:110px;
    margin-bottom:10px;
}

.badge-body{
    padding:25px;
    flex:1;
}

.attendee-name{
    font-size:24px;
    font-weight:600;
    margin-bottom:6px;
}

.attendee-org{
    font-size:14px;
    color:var(--gray);
    margin-bottom:20px;
}

.qr-container img{
    width:180px;
    height:180px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

.badge-footer{
    background:#f3f4f6;
    padding:14px;
    font-weight:600;
    font-size:14px;
    letter-spacing:.5px;
}

/* Fold divider */
.fold-line{
border:grey dashed 1px;
    width:2px;
}

/* BACK SIDE */


/* NOTE BOX */
.note-box{
    margin-top:40px;
    padding:25px;
    background:white;
    border-radius:14px;
    box-shadow:0 10px 30px rgba(0,0,0,0.05);
    font-size:15px;
}

/* BUTTON */
.btn{
    margin-top:25px;
    padding:14px 28px;
    font-size:15px;
    border:none;
    border-radius:10px;
    background:var(--primary);
    color:white;
    cursor:pointer;
    font-weight:600;
    transition:all .3s ease;
    box-shadow:0 8px 20px rgba(0,0,0,0.15);
}

.btn:hover{
    transform:translateY(-2px);
    box-shadow:0 12px 25px rgba(0,0,0,0.2);
}

.print-hint{
    font-size:13px;
    margin-top:10px;
    color:var(--gray);
}

/* PRINT STYLING */
@media print{
    body{
        background:none;
    }
    .note-box,.btn,.print-hint,#headder{
        display:none;
    }
    .both-wrapper{
        box-shadow:none;
        padding:0;
    }
}
</style>
</head>

<body>

<div class="page-wrapper">

<!-- HEADER -->
<div id="headder">
    <div id="event-name">
        <?= esc($event[0]['name']); ?>
    </div>
</div>

<!-- BADGES -->
<div class="both-wrapper">

    <!-- FRONT -->
    <div class="badge">

        <div class="badge-header">
            <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" class="logo-white">
            <div><?= esc($event[0]['name']); ?></div>
        </div>

        <div class="badge-body">

        <?php if (!empty($alldata) && $alldata['contactName'] !== 'Not_Found'): ?>
            
            <div class="attendee-name"><?= esc($alldata['contactName']) ?></div>
            <div class="attendee-org"><?= esc($alldata['companyName']) ?></div>

            <?php $qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=" . urlencode($mobile); ?>
            
            <div class="qr-container">
                <img src="<?= $qr_url ?>" alt="QR Code">
            </div>

            <p style="font-size:12px;color:#9ca3af;margin-top:15px;">
                For B2B Access Only
            </p>

        <?php else: ?>

            <div class="attendee-name">Visitor</div>
            <div class="qr-container">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=<?= urlencode($mobile) ?>">
            </div>

        <?php endif; ?>

        </div>

        <div class="badge-footer">TRADE VISITOR</div>

    </div>

    <div class="fold-line"></div>

    <!-- BACK -->
    <div class="badge" id="badge-back">

        <div class="badge-header">
            <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" class="logo-white">
        </div>

        <div class="badge-body" style="text-align:left;font-size:13px;line-height:1.7;">

            <strong style="font-size:15px;">Visitor Guidelines</strong>

            <ol style="padding-left:18px;margin-top:10px;">
                <li>Carry badge at all times.</li>
                <li>Badge is non-transferable.</li>
                <li>Report to Registration Desk.</li>
                <li>Photography only in allowed areas.</li>
                <li>Maintain venue decorum.</li>
                <li>Food only in food court.</li>
                <li>Lost badges not replaced.</li>
                <li>Entry rights reserved.</li>
            </ol>

            <div style="margin-top:15px;">
                📍 <?= esc($event[0]['venue_details']); ?>
            </div>

            <div style="margin-top:10px;">
                📞 +91 XXXXX XXXXX
            </div>

        </div>

        <div class="badge-footer">IITM INDIA</div>

    </div>

</div>

<!-- NOTE -->
<div class="note-box">
    <strong>Registration Successful!</strong><br><br>
    You can print this badge or show it on your phone at the Registration Desk.<br><br>
    <strong>Important:</strong> Badge must be verified at the venue entrance.
</div>

<button class="btn" onclick="window.print()">Print Badge</button>
<p class="print-hint">Set margins to “None” while printing for best alignment.</p>

</div>

</body>
</html>