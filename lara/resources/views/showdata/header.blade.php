<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Details</title>

    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .card {
            background: #fff;
            max-width: 500px;
            margin: auto;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
            box-sizing: border-box;
        }

        .row {
            padding: 12px 8px;
            border-bottom: 1px solid #eee;
            font-size: 15px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 14px;
            margin-top: 12px;
            color: #fff;
            border: 0;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            box-sizing: border-box;
        }

        .btn-call {
            background: #198754;
        }

        .btn-vcard {
            background: #007AFF;
        }

        .btn-whatsapp {
            background: #25D366;
        }

        .btn-calendar {
            background: #FF9500;
        }

        .qr-section {
            text-align: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .qr-code {
            width: 160px;
            height: 160px;
            margin-top: 10px;
        }

        input[type=password] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            width: 120px;
        }
    </style>
</head>

<body>


    <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt="IITM Logo" class="logo">
    @php
        $lastsegment = basename($_SERVER['REQUEST_URI']);
        $secondlastSegment = basename(dirname($_SERVER['REQUEST_URI']));
    @endphp