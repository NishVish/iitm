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

        /* Screen: show both badges stacked */
        .both-wrapper {
            position: relative;
            display: inline-flex;
            flex-direction: column;
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
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .fold-line {
            width: var(--badge-width);
            border-top: 2px dashed #aaa;
            margin: 0;
        }

        /* Cut marks */
        .cut {
            position: absolute;
            width: 15px;
            height: 15px;
        }
        .tl { top: 0;    left: 0;  border-top: 1px solid #000; border-left: 1px solid #000; }
        .tr { top: 0;    right: 0; border-top: 1px solid #000; border-right: 1px solid #000; }
        .bl { bottom: 0; left: 0;  border-bottom: 1px solid #000; border-left: 1px solid #000; }
        .br { bottom: 0; right: 0; border-bottom: 1px solid #000; border-right: 1px solid #000; }

        @media print {
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            body {
                background: white;
                padding: 0;
                margin: 0;
                display: block;
            }

            .note-box, .btn, .print-hint { display: none; }

            .both-wrapper {
                padding: 20px;
                position: relative;
                display: block;
            }

            .cut {
                display: block !important;
                visibility: visible !important;
                position: absolute !important;
                width: 15px !important;
                height: 15px !important;
            }

            .fold-line {
                display: block !important;
                width: 100% !important;
                border-top: 1px dashed #aaa !important;
            }

            .badge {
                box-shadow: none;
                border: 0.5pt solid #eee;
                border-radius: 0;
                position: relative;
            }

            @page {
                size: 9.3cm 26.6cm;
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

    <!-- 3. Both Sides in One Wrapper -->
    <div class="both-wrapper">

        <!-- Corner cut marks (outer only) -->
        <div class="cut tl"></div>
        <div class="cut tr"></div>
        <div class="cut bl"></div>
        <div class="cut br"></div>

        <!-- FRONT -->
        <div class="badge" id="badge-front">
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

        <!-- FOLD LINE -->
        <div class="fold-line"></div>

       <!-- FOLD LINE -->
        <div class="fold-line"></div>

        <!-- BACK (inverted so when folded it reads correctly) -->
        <div class="badge" id="badge-back" style="transform: rotate(180deg);">

            <div class="badge-header">
                <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt="Logo" class="logo-white">
            </div>

            <div class="badge-body">
                <div style="font-size: 12px; color: #444; line-height: 1.8; text-align: left; padding: 0 10px;">

                    <strong style="font-size: 15px; color: #1a1a1a; display: block; margin-bottom: 6px;">
                        📋 Visitor Guidelines
                    </strong>

                    <ol style="margin: 0; padding-left: 16px;">
                        <li>Carry this badge at all times inside the venue.</li>
                        <li>Badge is non-transferable and valid for one person only.</li>
                        <li>Report to the Registration Desk upon arrival for verification.</li>
                        <li>Photography is allowed in designated areas only.</li>
                        <li>Please maintain decorum inside the exhibition hall.</li>
                        <li>Food & beverages are allowed only in the food court area.</li>
                        <li>Lost badges will not be replaced.</li>
                        <li>Organizers reserve the right to deny entry without reason.</li>
                    </ol>

                    <strong style="font-size: 13px; color: #1a1a1a; display: block; margin: 12px 0 4px;">
                        📍 Venue
                    </strong>
                    Hall No. X, Pragati Maidan, New Delhi

                    <strong style="font-size: 13px; color: #1a1a1a; display: block; margin: 10px 0 4px;">
                        📞 Helpdesk
                    </strong>
                    +91 XXXXX XXXXX &nbsp;|&nbsp; info@iitmindia.com

                    <strong style="font-size: 13px; color: #1a1a1a; display: block; margin: 10px 0 4px;">
                        🗓 Event Dates
                    </strong>
                    XX – XX Month 20XX

                </div>
            </div>

            <div class="badge-footer">IITM INDIA</div>

        </div>

    </div><!-- end .both-wrapper -->

</body>
</html>