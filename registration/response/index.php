<?php
// Logo & Thank You Page
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
    <!-- Google Fonts for modern typography -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
        }

        .thank-you-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px 30px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            text-align: center;
            max-width: 480px;
            width: 90%;
            animation: fadeInUp 0.6s ease-out;
        }

        .logo {
            max-height: 90px;
            width: auto;
            margin-bottom: 24px;
        }

        h2 {
            color: #A91E1C;
            /* Classy institutional blue */
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 16px;
        }

        p {
            color: #555;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 12px;
        }

        .highlight-text {
            font-weight: 500;
            color: #222;
        }

        .btn-container {
            margin-top: 30px;
        }

        .btn-back {
            display: inline-block;
            background-color: #A91E1C;
            color: #ffffff;
            padding: 12px 30px;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 86, 179, 0.2);
        }

        .btn-back:hover {
            background-color: #A91E1C;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(#A91E1C, 0.3);
        }

        .btn-back:active {
            transform: translateY(0);
        }

        /* Smooth entrance animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <div class="thank-you-card">
        <img src="https://iitmindia.com/reg/iitm_chennai/logo.png" alt="IITM Logo" class="logo">

        <h2>Thank You for Registering!</h2>

        <p class="highlight-text">
            We have successfully received your registration.
        </p>

        <p>
            Our team will review your details and update you shortly via email.
        </p>

        <div class="btn-container">
            <button onclick="history.back()" class="btn-back">
                &larr; Go Back
            </button>
        </div>
    </div>

</body>

</html>