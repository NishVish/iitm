<?php
$data = '{
  "program_name": "Hosted Buyer Program",
  "location": "Bengaluru",
  "accommodation": {
    "duration_nights": 1,
    "hotel_category": "4-5 star hotel",
    "meals_included": true
  },
  "financial_terms": {
    "security_deposit": 5000,
    "currency": "INR"
  },
  "inclusions": [
    "1 Night Premium Accommodation",
    "All Meals (Breakfast, Lunch, Dinner)",
    "Complimentary Airport Transfers",
    "Access to Business Networking Lounge",
    "Hosted Buyer Badge & Priority Entry",
    "Dedicated Buyer Assistance Desk"
  ]
}';

$program = json_decode($data, true);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Hosted Buyer Program</title>

    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            background: #f4f6f9;
            padding: 40px;
        }

        .container {
            max-width: 850px;
            margin: auto;
        }

        .card {
            background: #fff;
            border-radius: 14px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .header {
            border-bottom: 2px solid #AA2D2C;
            margin-bottom: 20px;
            padding-bottom: 15px;
        }

        .title {
            font-size: 28px;
            margin: 0;
            color: #AA2D2C;
        }

        .badge {
            display: inline-block;
            background: #AA2D2C;
            color: #fff;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            margin-top: 8px;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 20px;
        }

        .section {
            background: #fafafa;
            padding: 15px;
            border-radius: 10px;
        }

        .section h3 {
            margin-top: 0;
            color: #333;
            font-size: 16px;
        }

        ul {
            margin: 0;
            padding-left: 18px;
        }

        .highlight {
            color: #AA2D2C;
            font-weight: bold;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 13px;
            color: #777;
        }

        .full-width {
            grid-column: 1 / -1;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="card">

            <!-- HEADER -->
            <div class="header">
                <h1 class="title"><?= htmlspecialchars($program['program_name']) ?></h1>
                <span class="badge">Hosted Buyer Program</span>
            </div>

            <!-- LOCATION -->
            <p>
                📍 <strong>Location:</strong>
                <span class="highlight"><?= htmlspecialchars($program['location']) ?></span>
            </p>

            <!-- GRID -->
            <div class="grid">

                <div class="section">
                    <h3>🏨 Accommodation</h3>
                    <ul>
                        <li>Nights: <?= (int) $program['accommodation']['duration_nights'] ?></li>
                        <li>Hotel: <?= htmlspecialchars($program['accommodation']['hotel_category']) ?></li>
                        <li>Meals: <?= $program['accommodation']['meals_included'] ? 'Included' : 'Not Included' ?></li>
                    </ul>
                </div>

                <div class="section">
                    <h3>💰 Financial Terms</h3>
                    <ul>
                        <li>Security Deposit:
                            <?= htmlspecialchars($program['financial_terms']['currency']) ?>
                            <?= (int) $program['financial_terms']['security_deposit'] ?>
                        </li>
                    </ul>
                </div>

                <div class="section full-width">
                    <h3>🎁 Program Inclusions</h3>
                    <ul>
                        <?php foreach ($program['inclusions'] as $item): ?>
                        <li><?= htmlspecialchars($item) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

            </div>

            <!-- FOOTER -->
            <div class="footer">
                © IITM Hosted Buyer Program • All Rights Reserved
            </div>

        </div>

    </div>

</body>

</html>