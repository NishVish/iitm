<!DOCTYPE html>
<html>

<head>
    <title>Tools Dashboard</title>
    <style>
        body {
            font-family: Arial;
            margin: 40px;
        }

        .card {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            background: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 10px;
        }

        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>

    <h2>Tools</h2>

    <!-- Tool 1: Badge Printing -->
    <div class="card">
        <h3>Tool 1: Badge Printing</h3>
        <a href="{{ url('badgeprint') }}" class="btn">Open Badge Printing</a>
    </div>

    <!-- Tool 2: Image to Text (OCR) -->
    <div class="card">
        <h3>Tool 2: Image to Text (OCR)</h3>

        <a href="{{ url('scanner/Nishant') }}" class="btn">Nishant OCR</a>
        <a href="{{ url('scanner/Sangeetha') }}" class="btn">Sangeetha OCR</a>
        <a href="{{ url('scanner/Anurag') }}" class="btn">Anurag OCR</a>

    </div>

</body>

</html>