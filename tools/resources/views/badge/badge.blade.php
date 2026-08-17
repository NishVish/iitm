<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation & Badge | IITM</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary:
                {{ $badge_color ?? '#a42627' }}
            ;
            --dark: #4f3a30;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }

        .main-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            max-width: 110vh;
            margin: auto;
            justify-content: center;
        }

        .content-section {
            flex: 1;
            min-width: 350px;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .logo-main {
            width: 120px;
            margin-bottom: 20px;
        }

        .event-title {
            color: #a42627;
            font-weight: 700;
            margin-bottom: 25px;
        }

        .badge-section {
            flex: 0 0 380px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .badge-card {
            width: 350px;
            height: 480px;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
            text-align: center;
            margin-bottom: 20px;
        }

        .badge-header {
            background: linear-gradient(135deg, var(--primary), #a8742f);
            color: white;
            padding: 20px;
        }

        .badge-header img {
            width: 100px;
            margin-bottom: 10px;
        }

        .badge-body {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .attendee-name {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .attendee-org {
            color: #666;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .qr-container img {
            width: 150px;
            height: 150px;
            border: 1px solid #eee;
            padding: 5px;
            border-radius: 10px;
        }

        .badge-footer {
            background: var(--primary);
            color: white;
            padding: 10px;
            font-weight: bold;
            font-size: 14px;
        }

        .main-page-container {
            display: flex;
            flex-direction: row;
            gap: 30px;
            align-items: flex-start;
            padding: 20px;
        }

        .info-sidebar {
            flex: 1;
        }

        @media (max-width: 900px) {
            .main-page-container {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

    <div class="main-wrapper">

        <!-- LEFT CONTENT -->
        <div class="content-section">

            <div class="d-flex align-items-center gap-3">
                <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" class="logo-main" alt="Logo">
                <h3 class="event-title">Registration Confirmed</h3>
            </div>

            <p>
                <strong>
                    {{ ucwords(strtolower(trim($alldata['contactName'] ?? 'Guest User'))) }}
                </strong>
                We are delighted to inform you that your registration for
                <strong>{{ $event[0]['name'] ?? 'IITM Kolkata' }}</strong>
                has been successfully confirmed.
            </p>

            <p>
                This serves as your official entry pass for the B2B Travel & Tourism Exhibition.
                Please find your event badge displayed on the right.
            </p>

        </div>

        <!-- RIGHT BADGE -->
        <div class="badge-section">

            <!-- BADGE CARD -->
            <div class="badge-card">

                <div class="badge-header">
                    <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt="Logo">
                    <div class="small">
                        {{ $event[0]['name'] ?? 'IITM Kolkata' }}
                    </div>
                </div>

                <div class="badge-body">

                    <div class="attendee-name">
                        {{ $alldata['contactName'] ?? 'Guest User' }}
                    </div>

                    <div class="attendee-org">
                        {{ $alldata['companyName'] ?? 'Organization Name' }}
                    </div>

                    <div class="qr-container">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($mobile ?? '30053610') }}"
                            alt="QR Code">
                    </div>

                    <p class="mt-3 mb-0 small text-secondary">B2B Access Only</p>

                </div>

                <div class="badge-footer">TRADE VISITOR</div>
            </div>

            <!-- GUIDELINES CARD -->
            <div class="badge-card">

                <div class="badge-header">
                    <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt="Logo">
                </div>

                <div class="badge-body text-start">

                    <strong style="font-size:14px; color:#c40a00;">
                        Visitor Guidelines:
                    </strong>

                    <ul style="font-size:11px; padding-left:15px; margin-top:10px; line-height:1.5;">
                        <li>Carry badge at all times.</li>
                        <li>Badge is non-transferable.</li>
                        <li>Photography only in allowed areas.</li>
                        <li>Maintain venue decorum.</li>
                        <li>Entry rights reserved by Team IITM.</li>
                    </ul>

                    <div class="mt-3 pt-2 border-top">
                        <p class="small mb-0">
                            <strong>Venue:</strong>
                            {{ $event[0]['venue_details'] ?? 'TBA' }}
                        </p>
                    </div>

                </div>

                <div class="badge-footer">IITM INDIA</div>
            </div>

        </div>

    </div>

</body>

</html>