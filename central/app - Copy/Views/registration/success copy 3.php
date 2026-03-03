<?php $badge_color = '#c58940'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Badge - 9.3x13.3</title>
    <style>
        :root {
            --brand-blue: <?= $badge_color ?>;
            --badge-width: 9.3cm;
            --badge-height: 13.3cm;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #e0e0e0;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        /* Note Box */
        .note-box {
            width: 100%;
            max-width: 9.3cm;
            background: #fff8e1;
            border-left: 4px solid <?= $badge_color ?>;
            padding: 12px 15px;
            border-radius: 4px;
            font-size: 14px;
            color: #444;
            line-height: 1.7;
            box-sizing: border-box;
        }

        /* Print Button */
        .btn {
            width: 100%;
            max-width: 9.3cm;
            padding: 14px;
            border-radius: 8px;
            border: none;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            background: var(--brand-blue);
            color: white;
            text-align: center;
            box-sizing: border-box;
        }

        .print-hint {
            font-size: 11px;
            color: #888;
            text-align: center;
            margin-top: -10px;
        }

        /* Badge */
        .cut-wrapper {
            position: relative;
            display: inline-block;
            padding: 10px;
        }

        .badge {
            width: var(--badge-width);
            height: var(--badge-height);
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            border: 1px solid #ccc;
        }
.badge::after {
    content: "";
    position: absolute;
    inset: 0;
    /* border: 2px solid #000; */
    pointer-events: none;
}
        /* .badge::before {
            content: '';
            position: absolute;
            top: 12px;
            left: 50%;
            transform: translateX(-50%);
            width: 1.2cm;
            height: 0.3cm;
            background: #e0e0e0;
            border-radius: 10px;
            z-index: 10;
        } */

        .badge-header {
            background-color: var(--brand-blue);
            height: 3.2cm;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding-top: 20px;
            color: white;
        }

        .logo-white {
            max-width: 70%;
            max-height: 3cm;
            margin-bottom: 8px;
        }

        .category-tag {
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            background: rgba(255,255,255,0.2);
            padding: 4px 15px;
            border-radius: 50px;
        }

        .badge-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0 15px;
        }

        .attendee-name {
            font-size: 26px;
            font-weight: 800;
            color: #1a1a1a;
            margin: 0;
            line-height: 1.1;
            text-transform: uppercase;
        }

        .attendee-org {
            font-size: 18px;
            color: var(--brand-blue);
            font-weight: 600;
            margin: 10px 0 20px 0;
        }

        .qr-container {
            background: white;
            padding: 10px;
            border: 2px solid #f0f0f0;
            border-radius: 10px;
        }

        .qr-container img {
            width: 3.5cm;
            height: 3.5cm;
            display: block;
        }

        .badge-footer {
            height: 1.8cm;
            background-color: var(--brand-blue);
            border-top: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
        }
.cut {
    position: absolute;
    width: 20px;
    height: 20px;
}

.tl { top: 0; left: 0; border-top: 1px solid #000; border-left: 1px solid #000; }
.tr { top: 0; right: 0; border-top: 1px solid #000; border-right: 1px solid #000; }
.bl { bottom: 0; left: 0; border-bottom: 1px solid #000; border-left: 1px solid #000; }
.br { bottom: 0; right: 0; border-bottom: 1px solid #000; border-right: 1px solid #000; }

@media print {
    * {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
    body { background: white; padding: 0; margin: 10px; display: block; }
    .note-box, .btn, .print-hint { display: none; }

    .cut-wrapper {
        padding: 20px;       /* ← give space for cut marks */
        position: relative;
        display: inline-block;
    }

    .cut {
        display: block !important;
        visibility: visible !important;
        position: absolute !important;
        width: 20px !important;   /* ← expand size */
        height: 20px !important;
    }

    /* ← badge must be relative so wrapper has correct size */
    .badge {
        box-shadow: none;
        border: 0.5pt solid #eee;
        border-radius: 0;
        position: relative;
    }

    /* remove the ::after border overlay on print */
    .badge::after { display: none; }

    @page {
        size: 9.3cm 13.3cm;
        margin: 0;
    }
}
    </style>
</head>
<body>

    <!-- 1. Note -->
    <div class="note-box">
        ✅ <strong>Registration Successful!</strong> You can either print this badge or show it on your phone at the Registration Desk.<br><br>
        ⚠️ <strong>Important:</strong> You <strong>must</strong> verify your badge at the venue entrance before entering.
    </div>

    <!-- 2. Print Button -->
    <button class="btn" onclick="window.print()">🖨️ Print This Badge</button>
    <p class="print-hint">Set margins to "None" in the print dialog for best results.</p>

    <!-- 3. Badge -->
    <div class="cut-wrapper">



<div class="cut tl"></div>
<div class="cut tr"></div>
<div class="cut bl"></div>
<div class="cut br"></div>













    <div class="badge" id="badge">

            <div class="badge-header">
                <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt="Logo" class="logo-white">
            </div>

            <div class="badge-body">
                <?php if (!empty($alldata) && $alldata['contactName'] !== 'Not_Found'): ?>
                    <h1 class="attendee-name"><?= esc($alldata['contactName']) ?></h1>
                    <div class="attendee-org"><?= esc($alldata['companyName']) ?></div>
                    <div class="qr-container">
                        <?php $qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=" . urlencode($mobile); ?>
                        <img src="<?= $qr_url ?>" alt="QR Code">
                    </div>
                    <p style="font-size: 10px; color: #999; margin-top: 10px;">Note: Only For B2B</p>
                <?php else: ?>
                    <h1 class="attendee-name">Visitor</h1>
                    <div class="qr-container">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=<?= urlencode($mobile) ?>" alt="QR Code">
                    </div>
                <?php endif; ?>
            </div>

            <div class="badge-footer">TRADE VISITOR</div>

        </div>
    </div>
    

</body>
</html>