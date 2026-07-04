<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Exhibitor Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #e3f2fd, #fce4ec);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 750px;
            background: #ffffff;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        img.logo {
            display: block;
            max-width: 140px;
            margin: 0 auto 15px;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: 700;
            color: #222;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: 500;
            color: #444;
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 12px 14px;
            margin-top: 6px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 14px;
            transition: 0.2s ease;
            outline: none;
        }

        input:focus {
            border-color: #6c63ff;
            box-shadow: 0 0 0 3px rgba(108, 99, 255, 0.15);
        }

        .btn {
            width: 100%;
            padding: 12px;
            margin-top: 18px;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .btn-submit {
            background: linear-gradient(135deg, #6c63ff, #5a55e0);
            color: #fff;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(108, 99, 255, 0.25);
        }

        .btn-add {
            background: #f1f1f1;
            color: #333;
            margin-top: 10px;
        }

        .btn-add:hover {
            background: #e6e6e6;
        }

        #delegateContainer input {
            margin-top: 10px;
        }

        .note {
            font-size: 12px;
            color: #888;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="container">
        <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt="IITM Logo" class="logo">
        @php
            $lastsegment = basename($_SERVER['REQUEST_URI']);
            $secondlastSegment = basename(dirname($_SERVER['REQUEST_URI']));
        @endphp