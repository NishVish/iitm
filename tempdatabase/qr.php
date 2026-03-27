<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan to Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Changed primary color to red to match the QR code */
            --primary: #ef4444; 
            --bg: #f3f4f6;
            --text: #1f2937;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg);
            background-image: radial-gradient(circle at 2px 2px, #e5e7eb 1px, transparent 0);
            background-size: 40px 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .qr-card {
            background: white;
            padding: 30px 30px 40px;
            border-radius: 32px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 360px;
            width: 100%;
            border: 1px solid rgba(255, 255, 255, 0.8);
        }

        /* Added Logo Styling */
        .brand-logo {
            width: 80px;
            height: auto;
            margin-bottom: 20px;
        }

        .qr-wrapper {
            background: #fff5f5; /* Light red tint for the background */
            padding: 20px;
            border-radius: 24px;
            display: inline-block;
            margin-bottom: 25px;
            border: 1px solid #fee2e2;
            transition: transform 0.3s ease;
        }

        .qr-wrapper:hover {
            transform: scale(1.02);
        }

        .qr-code {
            display: block;
            width: 220px;
            height: 220px;
            border-radius: 12px;
        }

        h1 {
            color: var(--text);
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        p {
            color: #6b7280;
            font-size: 15px;
            line-height: 1.5;
            margin-bottom: 30px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            background: #fee2e2;
            color: var(--primary);
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 15px;
        }

        .scan-line {
            width: 40px;
            height: 4px;
            background: var(--primary);
            margin: 0 auto;
            border-radius: 10px;
            opacity: 0.3;
        }

        @media (max-width: 400px) {
            .qr-code {
                width: 180px;
                height: 180px;
            }
        }
    </style>
</head>
<body>

    <div class="qr-card">
        <img src="logo.png" alt="Logo" class="brand-logo">
        
        <br>
        <div class="badge">Register Here</div>
        <div class="scan-line"></div>

        <div class="qr-wrapper" style="margin-top: 25px;">
            <img 
                /* Updated color to ff0000 (Red) */
                src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=https://databasebackend.yzz.me/form.php&color=ff0000&bgcolor=fff5f5&qzone=1" 
                alt="Register Here QR Code" 
                class="qr-code"
            >
        </div>

        <h1>Scan to Register</h1>
        <p>
            Google Scanner
            or QR Scanner
       
    </div>

</body>
</html>