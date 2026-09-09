<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Exhibitor</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f6fa;
        }

        .form-card {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, .08);
        }

        .form-title {
            font-weight: 600;
            margin-bottom: 25px;
        }

        .required {
            color: red;
        }

        .form-label {
            font-weight: 500;
        }
    </style>
</head>

<body>



    <div class="container">

        <a href="{{ url('add_booking') }}">


            Add Booking
        </a>



    </div>

</body>

</html>