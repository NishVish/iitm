<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registration Success</title>
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            /* Remove height: 100% to allow scrolling */
            min-height: 100vh;
        }

        .bg {
            /* Combined background: Gradient on top of the Image */
            background:
                linear-gradient(to bottom, rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.8)),
                url("https://iitmindia.com/assets/creatives/1.jpg");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            /* Keeps bg still while content scrolls */

            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            box-sizing: border-box;
            color: white;
        }

        .section {
            width: 100%;
            max-width: 600px;
            /* Narrower looks cleaner for forms */
            text-align: center;
            margin-bottom: 20px;
        }

        .sect1 img {
            width: 120px;
            margin-bottom: 10px;
        }

        .sect1 h1 {
            font-size: clamp(24px, 5vw, 38px);
            /* Responsive font size */
            margin: 0;
        }

        .box {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 16px;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            /* Safari support */
            border: 1px solid rgba(255, 255, 255, 0.2);
            text-align: left;
        }

        .box h2 {
            margin-top: 0;
            text-align: center;
            font-size: 22px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 15px;
        }

        .row {
            margin: 12px 0;
            font-size: 16px;
        }

        .success {
            color: #00ff9d;
            font-weight: bold;
            font-size: 18px;
            text-transform: uppercase;
        }
    </style>
</head>

<body>