<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IITM Booking Form</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary: #A62322;
            --primary-dark: #821b1b;
            --primary-light: #fff5f4;
            --border: #d9d9d9;
            --text: #222;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            background: #f5f5f5;
            font-family: Arial, sans-serif;
            color: var(--text);
        }

        .main {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 10px;
            overflow: visible !important;
        }

        .container {
            width: 100%;
            padding: 8px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
            overflow: visible !important;
        }

        /* =========================================================
           PROFESSIONAL BOOKING HEADER
           ========================================================= */

        .booking-header {
            position: relative;
            width: 100%;
            min-height: 175px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 30px;
            padding: 22px 35px;
            overflow: hidden;

            background:
                linear-gradient(135deg,
                    #ffffff 0%,
                    #ffffff 55%,
                    #fff7f6 100%);

            border: 1px solid #ead8d7;
            border-bottom: 5px solid var(--primary);
            border-radius: 8px 8px 0 0;
        }

        .booking-header::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 9px;
            height: 100%;
            background: var(--primary);
        }

        .booking-header::after {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            right: -100px;
            top: -110px;
            border-radius: 50%;
            background: rgba(166, 35, 34, 0.05);
            pointer-events: none;
        }

        .booking-logo-wrapper {
            width: 36%;
            max-width: 340px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
        }

        .booking-logo {
            display: block;
            width: 100%;
            max-width: 320px;
            height: auto;
            max-height: 125px;
            object-fit: contain;
        }

        .booking-header-divider {
            width: 1px;
            height: 105px;
            background: linear-gradient(to bottom,
                    transparent,
                    #c9c9c9,
                    transparent);
            flex-shrink: 0;
            position: relative;
            z-index: 1;
        }

        .booking-header-content {
            flex: 1;
            text-align: center;
            position: relative;
            z-index: 1;
            padding: 5px 10px;
        }

        .booking-title {
            margin: 0;
            padding: 0;
            color: var(--primary);
            font-family: 'Plus Jakarta Sans', sans-serif !important;

            font-size: clamp(25px, 4vw, 40px);
            font-weight: 900;
            letter-spacing: 2.5px;
            line-height: 1.15;
        }

        .booking-title-accent {
            width: 75px;
            height: 4px;
            margin: 12px auto 13px;
            background: var(--primary);
            border-radius: 10px;
        }

        .booking-subtitle {
            margin: 0;
            padding: 0;
            color: #333;
            font-family: Arial, sans-serif;
            font-size: clamp(13px, 2vw, 18px);
            font-weight: 600;
            line-height: 1.45;
        }

        .booking-subtitle-highlight {
            color: var(--primary);
            font-weight: 800;
        }

        .booking-tag {
            display: inline-block;
            margin-top: 12px;
            padding: 5px 13px;
            border: 1px solid rgba(166, 35, 34, 0.25);
            border-radius: 20px;
            color: var(--primary-dark);
            background: var(--primary-light);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* =========================================================
           GENERAL FORM STYLES
           ========================================================= */

        h3 {
            width: 100%;
            margin: 15px 0 10px;
            padding: 10px 12px;
            background-color: #d3d3d3;
            border-radius: 4px;
            font-size: 1.1em;
            text-align: center;
            line-height: 1.4 !important;
        }

        h2 {
            padding: 15px;
            margin: 20px 0 10px;
            border-radius: 6px;
            text-align: center;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .column {
            flex: 1;
            min-width: 280px;
            box-sizing: border-box;
            overflow: visible !important;
        }

        .form-line {
            display: flex;
            align-items: center;
            gap: 7px;
            margin-bottom: 11px;
            flex-wrap: wrap;
        }

        .form-line label {
            white-space: nowrap;
            margin: 0;
        }

        .form-line input,
        .form-line textarea {
            width: auto;
            flex: 1 1 auto;
            min-width: 150px;
        }

        label {
            font-weight: bold;
            display: inline-block;
            margin-bottom: 5px;
            line-height: 1.4 !important;
            padding-bottom: 3px !important;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="date"],
        textarea {
            border: none;
            border-bottom: 1px solid #000;
            border-radius: 0;
            background-color: transparent;
            padding: 4px 0;
            text-align: center;
            line-height: 1.4;
        }

        textarea {
            padding-bottom: 5px;
        }

        #a-rs,
        #b-rs,
        #grand-total {
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
            padding: 8px;
        }

        .checkbox-group label {
            font-weight: normal;
            display: block;
            margin-bottom: 10px;
        }

        .image-placeholder {
            width: auto;
            height: auto;
            margin: 40px;
            background-color: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #555;
            font-weight: bold;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        .account-info {
            display: block;
            padding: 10px;
            font-size: 1.1em;
            line-height: 1.5;
            width: auto;
            height: auto;
            text-align: left;
        }

        .note {
            background-color: #ffffe0;
            border-left: 4px solid #ccc;
            border-radius: 4px;
        }

        .note p {
            margin: 0;
            padding: 0;
        }

        .note ol {
            margin: 0;
            padding-left: 20px;
        }

        .note li {
            margin: 0;
            padding: 0;
        }

        .footer {
            font-size: 0.9em;
            color: #333;
            margin-top: 10px;
            text-align: center;
        }

        .footer a {
            color: #000;
            text-decoration: none;
        }

        .line {
            border-bottom: 1px solid #000;
            width: 150px;
            margin-top: 10px;
        }

        td {
            text-align: center;
        }

        .submit-button {
            background: none;
            border: none;
            padding: 0;
            font-size: inherit;
            font-weight: bold;
            text-align: left;
            cursor: pointer;
        }

        .submit-button:hover {
            text-decoration: underline;
        }

        .cropped-header {
            height: 180px;
            overflow: hidden;
            position: relative;
        }

        #fascia {
            text-transform: uppercase;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        .form-line input,
        .account-info,
        .responsive-subtitle {
            line-height: 1.4 !important;
        }

        /* =========================================================
           TABLET
           ========================================================= */

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .main {
                padding: 5px;
            }

            .booking-header {
                gap: 18px;
                padding: 20px;
            }

            .booking-logo-wrapper {
                width: 35%;
            }

            .booking-header-divider {
                height: 90px;
            }

            .booking-title {
                font-size: clamp(22px, 5vw, 32px);
            }

            .booking-subtitle {
                font-size: 14px;
            }
        }

        /* =========================================================
           MOBILE
           ========================================================= */

        @media screen and (max-width: 600px) {
            .form-line {
                flex-direction: column;
                align-items: flex-start;
            }

            .form-line label,
            .form-line input,
            .form-line textarea {
                width: 100%;
            }

            .footer {
                font-size: 0.8em;
            }

            .booking-header {
                flex-direction: column;
                gap: 12px;
                padding: 18px 12px 20px;
                min-height: auto;
                border-bottom-width: 4px;
            }

            .booking-header::before {
                width: 6px;
            }

            .booking-logo-wrapper {
                width: 72%;
                max-width: 280px;
            }

            .booking-logo {
                max-height: 100px;
            }

            .booking-header-divider {
                width: 70px;
                height: 1px;
                background: linear-gradient(to right,
                        transparent,
                        #c9c9c9,
                        transparent);
            }

            .booking-header-content {
                width: 100%;
                padding: 0 5px;
            }

            .booking-title {
                font-size: clamp(23px, 7vw, 30px);
                letter-spacing: 1.5px;
            }

            .booking-title-accent {
                width: 55px;
                height: 3px;
                margin: 8px auto 10px;
            }

            .booking-subtitle {
                font-size: 13px;
                line-height: 1.4;
            }

            .booking-tag {
                margin-top: 9px;
                font-size: 9px;
                padding: 4px 10px;
            }
        }

        /* =========================================================
           VERY SMALL MOBILE
           ========================================================= */

        @media screen and (max-width: 380px) {
            .booking-header {
                padding: 15px 10px 18px;
            }

            .booking-logo-wrapper {
                width: 78%;
            }

            .booking-title {
                font-size: 22px;
            }

            .booking-subtitle {
                font-size: 12px;
            }

            .booking-tag {
                font-size: 8px;
            }
        }

        /* =========================================================
           PRINT / PDF
           ========================================================= */

        @media print {
            body {
                padding: 0;
                background: #fff;
            }

            .main {
                max-width: none;
                padding: 0;
            }

            .container {
                box-shadow: none;
                border-radius: 0;
            }

            .booking-header {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>

    <div class="main">

        <div class="container">


            <!-- =====================================================
                     IITM BOOKING HEADER
                     ===================================================== -->

            <div class="booking-header">

                <div class="booking-logo-wrapper">
                    <img src="{{ url('public/resources/logo.png') }}" alt="IITM Logo" class="booking-logo">
                </div>

                <div class="booking-header-divider"></div>

                <div class="booking-header-content">

                    <h1 class="booking-title">
                        BOOKING FORM
                    </h1>

                    <div class="booking-title-accent"></div>

                    <p class="booking-subtitle">
                        <span class="booking-subtitle-highlight">
                            India's Premier
                        </span>
                        Travel &amp; Tourism Exhibition
                    </p>


                </div>

            </div>

            <!-- =====================================================
                     YOUR FORM CONTENT STARTS HERE
                     ===================================================== -->