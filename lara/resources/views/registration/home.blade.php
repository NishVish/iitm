<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Share Links</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }


        <style>body {
            background: #f5f6f8;
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial;
            color: #1f2937;
        }

        .title {
            text-align: center;
            margin: 20px 0;
            font-size: 26px;
            font-weight: 600;
        }

        .subtitle {
            text-align: center;
            color: #6b7280;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .city-card {
            margin: 25px auto;
            width: 95%;
            background: #ffffff;
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
        }

        .city-title {
            margin-bottom: 10px;
            color: #374151;
            font-size: 18px;
            font-weight: 600;
        }

        .cool-table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
        }

        .cool-table thead {
            background: #f3f4f6;
            color: #374151;
        }

        .cool-table th,
        .cool-table td {
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }

        .cool-table tr:hover {
            background: #f9fafb;
        }

        .badge {
            background: #e5e7eb;
            color: #111827;
            padding: 3px 8px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
        }

        .btn {
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 12px;
            text-decoration: none;
            border: 1px solid #d1d5db;
            background: #fff;
            color: #374151;
            cursor: pointer;
        }

        .btn:hover {
            background: #f3f4f6;
        }

        .name-cell {
            font-weight: 500;
            text-transform: capitalize;
        }

        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #111827;
            color: #fff;
            padding: 10px 14px;
            border-radius: 8px;
            opacity: 0;
            transform: translateY(15px);
            transition: 0.3s;
            font-size: 13px;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

</head>

<body>

    <div class="container">
        <h1 class="title">🔗 Share Links Dashboard</h1>

        <h2 class="subtitle">
            Copy & share links with clients for quick badge pre-printing
        </h2>
        @include('registration.linksandcounts')

</body>


</html>