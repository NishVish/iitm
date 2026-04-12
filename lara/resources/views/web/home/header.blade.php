<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Background + Floating Header</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #000;
            overflow: hidden;
            font-family: Arial, sans-serif;
        }

        /* Change body to allow scrolling */
        body {
            overflow-y: auto !important;
            overflow-x: hidden;
        }

        /* ===== FLOATING HEADER ===== */
        .header {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;

            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            padding: 12px 30px;
            border-radius: 40px;

            display: flex;
            gap: 30px;
        }

        .header a {
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            letter-spacing: 1px;
        }
    </style>
</head>

<body>