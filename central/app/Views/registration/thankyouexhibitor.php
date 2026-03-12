<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>India International Travel Mart | Exhibitor Enquiry</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-red: #a5251f;
            --dark-accent: #2c3e50;
            --glass-white: rgba(255, 255, 255, 0.95);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(-45deg, #f4f4f4, #e7e7e7, #fde8e7, #ffffff);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .register {
            padding: 60px 0;
            width: 100%;
        }

        .register-left {
            text-align: center;
            padding: 40px;
            transition: transform 0.3s ease;
        }

        .register-left img {
            width: 220px;
            filter: drop-shadow(0 5px 15px rgba(0,0,0,0.1));
            margin-bottom: 30px;
        }

        .event-title {
            color: var(--primary-red);
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-size: 1.2rem;
            line-height: 1.6;
        }

        .register-right {
            background: var(--glass-white);
            border-radius: 30px;
            padding: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            border: 1px solid rgba(255,255,255,0.3);
            backdrop-filter: blur(10px);
        }

        .letter-box {
            padding: 50px;
            color: #444;
            position: relative;
        }

        /* Decorative Accent */
        .letter-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50px;
            width: 60px;
            height: 4px;
            background: var(--primary-red);
            border-radius: 0 0 5px 5px;
        }

        .letter-box h2 {
            font-weight: 600;
            color: var(--dark-accent);
            margin-bottom: 25px;
            font-size: 1.5rem;
        }

        .letter-box p {
            font-size: 15px;
            line-height: 1.8;
            margin-bottom: 20px;
            font-weight: 300;
        }

        .contact-info {
            background: #fdf2f2;
            padding: 20px;
            border-radius: 15px;
            border-left: 4px solid var(--primary-red);
            margin: 30px 0;
        }

        .contact-info strong {
            color: var(--primary-red);
        }

        .footer-text {
            margin-top: 40px;
            border-top: 1px solid #eee;
            padding-top: 25px;
        }

        .signature {
            color: var(--dark-accent);
            font-weight: 600;
            font-size: 1.1rem;
        }

        /* Mobile Optimization */
        @media (max-width: 768px) {
            .register-right { margin: 20px; }
            .letter-box { padding: 30px; }
        }
    </style>
</head>

<body>

<div class="container register">
    <div class="row align-items-center">

        <div class="col-lg-4 register-left">
            <img src="https://iitmindia.com/exhibitor/logo.png" alt="IITM Logo">
            <div class="event-title">
                India International<br>Travel Mart
                <div style="font-weight: 300; font-size: 0.9rem; color: #666; margin-top: 5px;">
                    Exhibitor Enquiry 2025-26
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="register-right">
                <div class="letter-box">
                    <h2>Dear <?= esc($alldata['contactName'] ?? 'Trade Partner'); ?>,</h2>

                    <p>
                        Thank you for reaching out to the <strong>India International Travel Mart (IITM 2026-27)</strong>. 
                        We are thrilled to see your interest in joining India's premier travel trade exhibition.
                    </p>

                    <p>
                        Our team is currently reviewing your details. We aim to provide you with a comprehensive 
                        participation proposal tailored to your needs within the next 24-48 hours.
                    </p>

                    <div class="contact-info">
                        <strong>Urgent Assistance?</strong><br>
                        Call: +91-080-40834100 <br> 
                        Email: info@iitmindia.com
                    </div>

                    <p>
                        We look forward to helping you create a successful and enriching presence at IITM.
                    </p>

                    <div class="footer-text">
                        <span style="font-size: 0.9rem; color: #888;">Warm Regards,</span><br>
                        <div class="signature">Team IITM</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>