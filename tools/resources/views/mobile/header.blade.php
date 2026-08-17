<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Static Event Header</title>

    <style>
        body {
            margin: 0;
            font-family: system-ui, -apple-system, sans-serif;
            background: #f5f5f5;
        }

        /* Header */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 20px;
            background: #a82324;
            color: white;
        }

        .brand-logo img {
            height: 40px;
        }

        .event-details {
            display: flex;
            flex-direction: column;
            text-align: center;
        }

        .event-value {
            font-size: 1.6rem;
            font-weight: 600;
            color: white;
        }

        .event-label {
            font-size: 0.9rem;
            color: #ddd;
        }

        /* Stats Card */
        .stats-container {
            padding: 0 20px;
            margin-top: -25px;
        }

        .stats-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            padding: 20px 10px;
            display: flex;
            justify-content: space-around;
            box-shadow: 0 15px 35px rgba(168, 35, 36, 0.15);
        }

        .stat-item {
            text-align: center;
            flex: 1;
        }

        .stat-item:not(:last-child) {
            border-right: 1px solid rgba(168, 35, 36, 0.1);
        }

        .stat-value {
            font-weight: 800;
            font-size: 24px;
            color: #a82324;
            display: block;
        }

        .stat-label {
            font-size: 10px;
            color: #7f8c8d;
            margin-top: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        <div class="brand-logo">
            <img src="https://iitmindia.com/reg/iitm_chennai/logo.png" alt="Logo">
        </div>

        <div class="event-details">
            <span class="event-value" id="eventName">Tech Fest 2026</span>
            <span class="event-label">Next Event || 10-12 May 2026</span>
        </div>

        <div></div>
    </div>

    <!-- STATS -->
    <div class="stats-container">
        <div class="stats-card">
            <div class="stat-item">
                <span class="stat-value" id="eventDays">12</span>
                <span class="stat-label">Days</span>
            </div>
            <div class="stat-item">
                <span class="stat-value" id="eventHours">08</span>
                <span class="stat-label">Hours</span>
            </div>
            <div class="stat-item">
                <span class="stat-value" id="eventMins">45</span>
                <span class="stat-label">Mins</span>
            </div>
        </div>
    </div>

</body>

</html>