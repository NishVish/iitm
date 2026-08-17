<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invalid Event</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #f8f9fa;

            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .box {
            background: white;
            padding: 30px 40px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .box h1 {
            color: #aa2324;
            margin-bottom: 10px;
        }

        .box p {
            color: #555;
            font-size: 14px;
        }

        .btn {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 18px;
            background: #aa2324;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
        }

        .btn:hover {
            background: #8e1c1d;
        }
    </style>
</head>

<body>

<div class="box">
    <h1>Invalid Event</h1>
    <p>The event you are trying to access is not valid or has been modified.</p>

    <a href="{{ url('/') }}" class="btn">Go Back</a>
</div>

</body>
</html>