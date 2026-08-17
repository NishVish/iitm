<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trade Visitors Analytics - 2005 Edition</title>

    <link href="https://fonts.googleapis.com/css2?family=Trebuchet+MS:wght@400;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Trebuchet MS', Arial, sans-serif;
            /* Forces color preservation during print */
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        body {
            background: #e4e7eb url('data:image/png;base64,iVBORw0KGgoAAAANSU53EUgAAAAQAAAAECAYAAACp8Z5+AAAAIklEQVQIW2NkQAKjR4//M2AAM0gAog3AAnA2mABIEy4AUgoA/8MME/1S7JgAAAAASUVORK5CYII=') repeat;
            color: #333;
            padding: 30px;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background: #ffffff;
            border: 3px solid #b2b2b2;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.3), inset 0px 1px 0px #ffffff;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            background: linear-gradient(180deg, #ffffff 0%, #eaeaea 100%);
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #cccccc;
            box-shadow: inset 0 1px 0 #fff, 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            font-size: 36px;
            color: #AA2324;
            font-weight: 700;
            text-shadow: 1px 1px 0px #ffffff, 2px 2px 2px rgba(0, 0, 0, 0.2);
        }

        .header p {
            color: #555;
            margin-top: 5px;
            font-size: 14px;
            font-weight: bold;
        }

        .card {
            background: #f4f5f7;
            border-radius: 12px;
            padding: 25px;
            border: 1px solid #d1d5db;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .chart {
            display: flex;
            justify-content: space-around;
            align-items: flex-end;
            height: 350px;
            /* Adjusted height to accommodate YoY indicators */
            margin-top: 15px;
            background: #ffffff;
            border: 2px solid #cccccc;
            border-radius: 8px;
            padding: 45px 10px 10px 10px;
            /* Room for stacked labels above bars */
            box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.1);
        }

        .year {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .bars {
            display: flex;
            gap: 15px;
            align-items: flex-end;
        }

        .bar-box {
            text-align: center;
        }

        .bar {
            width: 50px;
            border-radius: 6px 6px 0 0;
            position: relative;
            border: 1px solid rgba(0, 0, 0, 0.3);
            border-bottom: none;
        }

        /* Single Color Bar Style */
        .trade {
            background: #AA2324;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4),
                2px 2px 5px rgba(0, 0, 0, 0.2);
        }

        .exhibitor {
            background: #eb8e8eff;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4),
                2px 2px 5px rgba(0, 0, 0, 0.2);
        }

        /* Container for value and YoY growth badge */
        .bar-header {
            position: absolute;
            top: -38px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            white-space: nowrap;
        }



        .yoy-badge {
            font-size: 10px;
            font-weight: 700;
            color: #008000;
            background: #e6ffe6;
            border: 1px solid #b3ffb3;
            padding: 1px 4px;
            border-radius: 3px;
            margin-bottom: 2px;
        }

        .value {
            font-weight: 700;
            color: #AA2324;
            font-size: 12px;
            text-shadow: 1px 1px 0 #fff;
        }

        .label {
            margin-top: 6px;
            color: #444;
            font-size: 11px;
            font-weight: bold;
        }

        .year-name {
            margin-top: 12px;
            font-size: 18px;
            font-weight: 700;
            color: #ffffff;
            background: linear-gradient(180deg, #AA2324 0%, #660000 100%);
            padding: 3px 15px;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .legend {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 20px 0;
        }

        .legend div {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #333;
            font-weight: bold;
            font-size: 13px;
        }

        .dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            border: 1px solid rgba(0, 0, 0, 0.3);
        }

        .trade-dot {
            background: linear-gradient(180deg, #ff6b6b 0%, #AA2324 100%);
            box-shadow: inset 0 1px 0 #fff;
        }

        .expo-dot {
            background: linear-gradient(180deg, #ffcfcf 0%, #d65b5d 100%);
            box-shadow: inset 0 1px 0 #fff;
        }

        .stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .stat-card {
            background: linear-gradient(180deg, #ffffff 0%, #fff0f0 100%);
            border: 2px solid #e2b6b6;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.05);
        }

        .stat-card h3 {
            color: #AA2324;
            margin-bottom: 10px;
            font-size: 15px;
            border-bottom: 2px solid #f0c2c2;
            padding-bottom: 4px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            border-bottom: 1px dotted #d68a8a;
            font-size: 13px;
        }

        .row:last-child {
            border: none;
        }

        .growth {
            color: #008000;
            font-weight: 700;
        }

        .insight-box {
            margin-top: 20px;
            background: linear-gradient(180deg, #fffde6 0%, #fff9b3 100%);
            border: 2px dashed #e6c200;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
        }

        .insight-box h3 {
            color: #997a00;
            font-size: 15px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .insight-box p {
            font-size: 13px;
            color: #444;
            line-height: 1.5;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 12px;
        }

        @media print {
            body {
                background: #fff !important;
                padding: 0;
            }

            .container {
                width: 100%;
                border: none;
                box-shadow: none;
            }
        }
    </style>
</head>

<body></body>