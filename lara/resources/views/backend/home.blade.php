<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Dashboard</title>

    ```
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            color: white;
        }

        h1 {
            margin-bottom: 40px;
            font-size: 32px;
        }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .big-btn {
            display: block;
            width: 300px;
            padding: 20px;
            font-size: 20px;
            font-weight: bold;
            color: #fff;
            text-decoration: none;
            border-radius: 12px;
            background: #007bff;
            transition: 0.3s ease;
        }

        .big-btn:hover {
            background: #0056b3;
            transform: scale(1.05);
        }

        /* different colors */
        .sales {
            background: #28a745;
        }

        .admin {
            background: #dc3545;
        }

        .ops {
            background: #ffc107;
            color: #000;
        }

        .sales:hover {
            background: #1e7e34;
        }

        .admin:hover {
            background: #a71d2a;
        }

        .ops:hover {
            background: #e0a800;
        }
    </style>

</head>

<body>

    <div class="container">
        <h1>Portal Dashboard</h1>

        <div class="btn-group">
            <a href="{{ url('salesportal') }}" class="big-btn sales">Sales Portal</a>
            <a href="{{ url('bookingportal') }}" class="big-btn sales">Booking Portal</a>
            <a href="{{ url('admin') }}" class="big-btn admin">Admin Portal</a>
            <a href="{{ url('../central') }}" class="big-btn ops">Operations</a> <a href="{{ url('/') }}"
                class="big-btn ops">website</a>

            <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <button type="submit" class="logout-btn">LOGOUT</button>
            </form>
        </div>

    </div>