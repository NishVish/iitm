<?php $badge_color = '#c58940'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Event Badge</title>

<style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f4f4;
        margin: 0;
        padding: 20px;
        text-align: center;
    }

    .page-wrapper {
        padding-top:10vh;
        max-width: 900px;
        margin: auto;
    }

    #event-name {
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 20px;
    }

    /* NOTE BOX */
    .note-box {
        background: #fff8e5;
        border: 1px solid #ffd27a;
        padding: 15px;
        margin-top: 30px;
        border-radius: 6px;
        font-size: 14px;
    }

    .btn {
        margin-top: 15px;
        padding: 10px 20px;
        background: <?= $badge_color ?>;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }

    .btn:hover {
        opacity: 0.9;
    }

    .print-hint {
        font-size: 12px;
        color: #666;
        margin-top: 8px;
    }

    /* BADGE WRAPPER */
    .both-wrapper {
        width: 800px;
        margin: auto;
        display: flex;
        justify-content: space-between;
        position: relative;
        background: #fff;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .badge {
        width: 360px;
        height: 520px;
        border: 2px solid #ddd;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .badge-header {
        background: <?= $badge_color ?>;
        color: #fff;
        padding: 15px;
    }

    .logo-white {
        width: 120px;
        margin-bottom: 10px;
    }

    .badge-body {
        padding: 15px;
        flex: 1;
    }

    .attendee-name {
        margin: 10px 0 5px;
        font-size: 22px;
    }

    .attendee-org {
        font-size: 14px;
        margin-bottom: 15px;
    }

    .qr-container img {
        width: 180px;
        height: 180px;
    }

    .badge-footer {
        background: #f1f1f1;
        padding: 10px;
        font-weight: bold;
        font-size: 14px;
    }
#headder {
    height:15vh;
    margin: 0 auto 20px auto;
        background: rgba(200, 7, 7, 0.85);

    /* background: url('https://iitmindia.com/wp-content/uploads/2024/03/image-1.png') no-repeat center center; */
    background-size: cover;
    display: flex;
    align-items: center;
    justify-content: center;
}

#headder #event-name {
    background: rgba(200, 7, 7, 0.85);
    padding: 10px 25px;
    border-radius: 6px;
}
    .fold-line {
        width: 2px;
        background: #000;
        height: 520px;
        margin: 0 10px;
    }

    @media print {
        body {
            background: none;
        }
        .note-box, .btn, .print-hint {
            display: none;
        }
        .both-wrapper {
            box-shadow: none;
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
    
    <!-- SECTION 1 : BADGE -->
    <div class="both-wrapper">

        <!-- FRONT -->
        <div class="badge" id="badge-front">

            <div class="badge-header">
                <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt="Logo" class="logo-white">
                <div><?= esc($event[0]['name']); ?></div>
            </div>

            <div class="badge-body">
                <?php if (!empty($alldata) && $alldata['contactName'] !== 'Not_Found'): ?>
                    <h1 class="attendee-name"><?= esc($alldata['contactName']) ?></h1>
                    <div class="attendee-org"><?= esc($alldata['companyName']) ?></div>

                    <?php $qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=" . urlencode($mobile); ?>
                    <div class="qr-container">
                        <img src="<?= $qr_url ?>" alt="QR Code">
                    </div>

                    <p style="font-size: 10px; color: #999; margin-top: 10px;">
                        Note: Only For B2B
                    </p>

                <?php else: ?>
                    <h1 class="attendee-name">Visitor</h1>
                    <div class="qr-container">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=<?= urlencode($mobile) ?>" alt="QR Code">
                    </div>
                <?php endif; ?>
            </div>

            <div class="badge-footer">TRADE VISITOR</div>
        </div>

        <!-- FOLD LINE -->
        <div class="fold-line"></div>

        <!-- BACK -->
        <div class="badge" id="badge-back" style="transform: rotate(180deg);">

            <div class="badge-header">
                <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt="Logo" class="logo-white">
            </div>

            <div class="badge-body" style="text-align:left; font-size:12px; line-height:1.7;">

                <strong style="font-size:15px;">📋 Visitor Guidelines</strong>
                <ol style="padding-left:16px;">
                    <li>Carry this badge at all times inside the venue.</li>
                    <li>Badge is non-transferable and valid for one person only.</li>
                    <li>Report to Registration Desk upon arrival.</li>
                    <li>Photography allowed in designated areas only.</li>
                    <li>Maintain decorum inside the exhibition hall.</li>
                    <li>Food allowed only in food court.</li>
                    <li>Lost badges will not be replaced.</li>
                    <li>Organizers reserve the right to deny entry.</li>
                </ol>

                <div style="margin-top:10px;">
                    📍 <?= esc($event[0]['venue_details']); ?>
                </div>

                <div style="margin-top:10px;">
                    📞 +91 XXXXX XXXXX | info@iitmindia.com
                </div>

                <div style="margin-top:10px;">
                    🗓 XX – XX Month 20XX
                </div>

            </div>

            <div class="badge-footer">IITM INDIA</div>
        </div>

    </div>

    <!-- SECTION 2 -->
    <div class="note-box">
        ✅ <strong>Registration Successful!</strong> You can either print this badge or show it on your phone at the Registration Desk.
        <br><br>
        ⚠️ <strong>Important:</strong> You <strong>must</strong> verify your badge at the venue entrance before entering.
    </div>

    <button class="btn" onclick="window.print()">🖨️ Print This Badge</button>
    <p class="print-hint">Set margins to "None" in the print dialog for best results.</p>

</div>
</body>
</html>