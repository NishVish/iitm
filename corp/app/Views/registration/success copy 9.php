<?php 
$badge_color = '#c58940'; 
// Fallback for esc function if not defined in your framework

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation & Badge | IITM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root { --primary: <?= $badge_color ?>; --dark: #4f3a30; }
        body { font-family: 'Inter', sans-serif; background-color: #f4f4f4; color: #333; padding: 20px; }
        
        /* Main Layout */
        .main-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            max-width: 1200px;
            margin: auto;
            justify-content: center;
        }

        /* Left Side: Confirmation Text */
        .content-section {
            flex: 1;
            min-width: 350px;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .logo-main { width: 120px; margin-bottom: 20px; }
        .event-title { color: #a42627; font-weight: 700; margin-bottom: 25px; }

        /* Right Side: Badge Section */
        .badge-section {
            flex: 0 0 380px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            align-items: center;
        }

        /* Badge Styling */
        .badge-card {
            width: 350px;
            height: 480px;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border: 1px solid #ddd;
            text-align: center;
        }
        .badge-header {
            background: linear-gradient(135deg, var(--primary), #a8742f);
            color: white;
            padding: 20px;
        }
        .badge-header img { width: 100px; margin-bottom: 10px; }
        .badge-body { padding: 20px; flex-grow: 1; display: flex; flex-direction: column; justify-content: center; }
        .attendee-name { font-size: 24px; font-weight: 700; margin-bottom: 5px; text-transform: uppercase; }
        .attendee-org { color: #666; font-size: 14px; margin-bottom: 15px; }
        .qr-container img { width: 150px; height: 150px; border: 1px solid #eee; padding: 5px; border-radius: 10px; }
        .badge-footer { background: #222; color: white; padding: 12px; font-weight: 600; font-size: 14px; letter-spacing: 1px; }

        .fold-hint { border-top: 2px dashed #bbb; width: 100%; margin: 10px 0; position: relative; }
        .fold-hint::after { content: 'FOLD HERE'; position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: #f4f4f4; padding: 0 10px; font-size: 10px; color: #888; }

        .btn-print {
            background: var(--dark);
            color: white;
            padding: 12px 25px;
            border-radius: 30px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-print:hover { background: #a42627; color: white; }

            
    </style>
</head>
<body>

<div class="main-wrapper">
    
    <div class="content-section">
        <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt="IITM Logo" class="logo-main">
        <h3 class="event-title">Registration Confirmed</h3>
        
        <p><strong>Dear Mr. Jio J,</strong></p>
        <p>We are delighted to inform you that your registration for <strong>IITM Kolkata</strong> has been successfully confirmed.</p>
        <p>This serves as your official entry pass for the B2B Travel & Tourism Exhibition. Please find your event badge displayed on the right.</p>
        
        <div class="alert alert-light border">
            <p class="mb-1"><strong>Reference Number:</strong> 30053610</p>
            <p class="mb-0"><strong>Venue:</strong> <?= esc($event[0]['venue_details'] ?? 'TBA, Kolkata'); ?></p>
        </div>

        <p class="small text-muted">Kindly print this page and wear the badge during the event. Lost badges will not be replaced.</p>
        
        <p><strong>Contact Us:</strong><br>
        📧 info@iitmindia.com | 📞 +91-80-40834100</p>

        <a href="javascript:window.print()" class="btn-print">Print Event Badge</a>
    
    <div class="badge-section">
        
        <div class="badge-card">
            <div class="badge-header">
                <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt="Logo">
                <div class="small"><?= esc($event[0]['name'] ?? 'IITM Kolkata'); ?></div>
            </div>
            <div class="badge-body">
                <div class="attendee-name"><?= !empty($alldata['contactName']) ? esc($alldata['contactName']) : 'Jio J'; ?></div>
                <div class="attendee-org"><?= !empty($alldata['companyName']) ? esc($alldata['companyName']) : 'Organization Name'; ?></div>
                
                <div class="qr-container">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= urlencode($mobile ?? '30053610') ?>" alt="QR Code">
                </div>
                <p class="mt-3 mb-0 small text-secondary">B2B Access Only</p>
            </div>
            <div class="badge-footer">TRADE VISITOR</div>
        </div>

        <div class="fold-hint"></div>

        <div class="badge-card">
            <div class="badge-header">
                <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt="Logo">
            </div>
            <div class="badge-body text-start">
                <strong style="font-size:14px; color: var(--primary);">Visitor Guidelines:</strong>
                <ul style="font-size:11px; padding-left:15px; margin-top:10px; line-height:1.5;">
                    <li>Carry badge at all times.</li>
                    <li>Badge is non-transferable.</li>
                    <li>Photography only in allowed areas.</li>
                    <li>Maintain venue decorum.</li>
                    <li>Entry rights reserved by Team IITM.</li>
                </ul>
                <div class="mt-3 pt-2 border-top">
                    <p class="small mb-0"><strong>Venue:</strong> <?= esc($event[0]['venue_details'] ?? 'TBA'); ?></p>
                </div>
            </div>
            <div class="badge-footer">IITM INDIA</div>
        </div>

    </div>


    </div>

    
</div>

</body>
</html>