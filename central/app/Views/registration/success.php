<?php
$badge_color = '#c58940';

// var_dump($type);
// var_dump($alldata['contactName']);
// var_dump($alldata);

?>

<?php if ($type == "spot"  ): ?>

<?=view('registration/spotsuccess');?>

<?php elseif ($type == "online_registration"&& $alldata['contactName'] != "Not_Found" ): ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Token | IITM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
    
    <style>
        :root { 
            --primary: <?= $badge_color ?? '#a42627' ?>; 
            --dark: #1a1a1a; 
            --bg: #eef2f5;
        }
        
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: var(--bg); 
            color: #333; 
            padding: 20px; 
        }

        .main-wrapper {
            max-width: 900px;
            margin: auto;
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
        }

        /* Instructions Side */
        .content-section {
            flex: 1;
            min-width: 320px;
            padding-top: 20px;
        }

        .logo-main { width: 80px; margin-bottom: 20px; }
        .confirmation-label { 
            color: #27ae60; 
            font-weight: 700; 
            text-transform: uppercase; 
            font-size: 14px; 
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* The Receipt Token */
        .receipt-container {
            flex: 0 0 360px;
            filter: drop-shadow(0 10px 20px rgba(0,0,0,0.08));
        }

        .receipt {
            background: white;
            position: relative;
            padding: 0;
            border-radius: 4px 4px 0 0;
        }

        .receipt-header {
            padding: 30px 20px 20px;
            text-align: center;
            border-bottom: 2px dashed #eee;
        }

        .receipt-body {
            padding: 30px 25px;
        }

        .qr-box {
            background: #fcfcfc;
            border: 1px solid #eee;
            padding: 15px;
            border-radius: 12px;
            margin: 0 auto 25px;
            width: fit-content;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .info-label { color: #888; text-transform: uppercase; font-size: 11px; font-weight: 700; }
        .info-value { font-weight: 600; color: var(--dark); text-align: right; }

        .ref-code {
            font-family: 'JetBrains Mono', monospace;
            background: #f4f4f4;
            display: block;
            text-align: center;
            padding: 10px;
            font-size: 18px;
            letter-spacing: 2px;
            margin-top: 20px;
            border: 1px solid #ddd;
        }

        /* Zig Zag Bottom */
        .receipt-footer {
            background: white;
            padding: 20px;
            text-align: center;
            position: relative;
        }

        .zigzag {
            position: absolute;
            bottom: -15px;
            left: 0;
            width: 100%;
            height: 15px;
            background: linear-gradient(-45deg, var(--bg) 8px, transparent 0), 
                        linear-gradient(45deg, var(--bg) 8px, transparent 0);
            background-size: 16px 16px;
        }

        .status-badge {
            background: var(--primary);
            color: white;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
        }

        @media print {
            .no-print { display: none; }
            body { background: white; padding: 0; }
            .receipt-container { filter: none; }
            .main-wrapper { display: block; }
        }
    </style>
</head>
<body>

<div class="main-wrapper">
    
    <div class="content-section">
        <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt="IITM Logo" class="logo-main">
        
        <div class="confirmation-label">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </svg>
            Registration Confirmed
        </div>
        
        <h2 class="mt-3 fw-bold">Verification Receipt</h2>
        <p class="text-muted">Hello <?= esc(ucwords(strtolower(trim($alldata['contactName'] ?? 'Visitor')))) ?>,</p>
        
        <p>This is your <strong>Verification Token</strong> for <?= esc($event[0]['name'] ?? 'the Event'); ?>. Please present this at the registration counter to verify your entry and collect your printed badge.</p>

        <div class="alert alert-warning border-0 small">
            <strong>Note:</strong> You do not need to wear this printout. This receipt acts as a fast-track token for our on-site printing desk.
        </div>

        <div class="mt-4 no-print">
            <button onclick="window.print()" class="btn btn-dark px-4">Print / Save Receipt</button>
            <p class="mt-2 small text-muted">Or take a screenshot on your mobile.</p>
        </div>
    </div>

    <div class="receipt-container">
        <div class="receipt">
            <div class="receipt-header">
                <span class="status-badge">TRADE VISITOR</span>
                <h5 class="mt-3 mb-1 fw-bold"><?= esc($event[0]['name'] ?? 'IITM Event'); ?></h5>
                <p class="small text-muted mb-0"><?= esc($event[0]['venue_details'] ?? 'Venue Details'); ?></p>
            </div>

            <div class="receipt-body">
                <div class="qr-box">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=<?= urlencode($mobile ?? '30053610') ?>" alt="Verification QR">
                </div>

                <div class="info-row">
                    <span class="info-label">Name</span>
                    <span class="info-value"><?= esc($alldata['contactName'] ?? 'Visitor') ?></span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Company</span>
                    <span class="info-value"><?= esc($alldata['companyName'] ?? 'Not Specified') ?></span>
                </div>

                <div class="info-row">
                    <span class="info-label">City</span>
                    <span class="info-value"><?= strtoupper($citySuffix ?? 'Pune') ?></span>
                </div>

                <div class="mt-4">
                    <span class="info-label">Verification Reference</span>
                    <code class="ref-code"><?= $mobile ?? '30053610' ?></code>
                </div>
            </div>

            <div class="receipt-footer">
                <p class="small text-muted mb-0">Present this QR at the Desk</p>
                <div class="zigzag"></div>
            </div>
        </div>
    </div>

</div>

</body>
</html>
<?php elseif($type == "exhibitor"): ?>


    <?php view("registration/thankyouexhibitor"); ?>
<?php else: ?>
       <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connection Interrupted | IITM</title>
    <style>
        :root {
            --primary-blue: #0056b3;
            --error-red: #ff4d4d;
            --glass-bg: rgba(255, 255, 255, 0.9);
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            /* Modern deep gradient background */
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .container {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            padding: 50px 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            width: 90%;
            max-width: 450px;
            text-align: center;
            border: 1px solid rgba(255,255,255,0.3);
            transition: transform 0.3s ease;
        }

        .container:hover {
            transform: translateY(-5px);
        }

        .logo-main {
            width: 180px;
            margin-bottom: 30px;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
            animation: pulse 2s infinite ease-in-out;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.03); }
            100% { transform: scale(1); }
        }

        h1 {
            color: #2c3e50;
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .error-tag {
            color: var(--error-red);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 12px;
            margin-bottom: 20px;
            display: block;
        }

        p {
            color: #666;
            line-height: 1.6;
            font-size: 16px;
            margin-bottom: 35px;
        }

        .btn-group {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .btn {
            display: inline-block;
            padding: 12px 25px;
            background-color: var(--primary-blue);
            color: #ffffff;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 86, 179, 0.3);
        }

        .btn:hover {
            background-color: #004494;
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0, 86, 179, 0.4);
        }

        .btn-secondary {
            background-color: transparent;
            color: var(--primary-blue);
            border: 2px solid var(--primary-blue);
            box-shadow: none;
        }

        .btn-secondary:hover {
            background-color: var(--primary-blue);
            color: white;
        }
    </style>
</head>
<body>

    <div class="container">
        <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt="IITM Logo" class="logo-main">

        <span class="error-tag">System Notice</span>
        <h1>Please Try Again</h1>
        <p>The server encountered a temporary hiccup while processing your request. Don't worry, your data is safe.</p>

        <div class="btn-group">
            <a href="http://iitmindia.com" class="btn">Go Back</a>
            <a href="#" class="btn btn-secondary" onclick="location.reload()">Refresh</a>
        </div>
    </div>

</body>
</html>
<?php endif; ?>