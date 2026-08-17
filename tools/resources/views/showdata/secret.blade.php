<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Entry Form</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #003b95, #0066cc, #00a8ff);
            padding: 30px;
        }

        .card {
            width: 100%;
            max-width: 650px;
            background: rgba(255, 255, 255, .95);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, .18);
            overflow: hidden;
        }

        .header {
            text-align: center;
            padding: 35px 30px 20px;
            background: white;
        }

        .header img {
            width: 240px;
            max-width: 90%;
        }

        .header h2 {
            margin-top: 20px;
            color: #003b95;
            font-size: 28px;
        }

        .header p {
            color: #777;
            margin-top: 8px;
        }

        .form-area {
            padding: 35px;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .group {
            display: flex;
            flex-direction: column;
        }

        .group.full {
            grid-column: 1/-1;
        }

        label {
            font-size: 14px;
            margin-bottom: 8px;
            font-weight: 600;
            color: #444;
        }

        input {
            height: 50px;
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 0 15px;
            font-size: 15px;
            transition: .3s;
        }

        input:focus {
            outline: none;
            border-color: #0066cc;
            box-shadow: 0 0 0 4px rgba(0, 102, 204, .15);
        }

        button {
            margin-top: 30px;
            width: 100%;
            height: 55px;
            border: none;
            border-radius: 14px;
            background: linear-gradient(135deg, #0057d9, #0099ff);
            color: white;
            font-size: 17px;
            font-weight: 600;
            cursor: pointer;
            transition: .3s;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 102, 204, .35);
        }

        @media(max-width:700px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <div class="card">

        <div class="header">
            <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt="IITM India Logo">
            <h2> Entry</h2>
            <p>Please verify the details before submitting.</p>
        </div>

        <div class="form-area">

            <form method="POST" action="{{ 'entry' }}">
                @csrf

                <div class="grid">

                    <div class="group">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ $data->name }}" required>
                    </div>

                    <div class="group">
                        <label>Designation</label>
                        <input type="text" name="designation"
                            value="{{ $data->designation == 'NA' ? '' : $data->designation }} " required>
                    </div>

                    <div class="group full">
                        <label>Company Name</label>
                        <input type="text" name="company_name" value="{{ $data->company_name }}" required>
                    </div>



                    <div class="group">
                        <label>Email Address</label>
                        <input type="email" name="email" value="{{ $data->email == 'NA' ? '' : $data->email }}"
                            required>
                    </div>
                    <div class="group">
                        <label>Mobile Number</label>
                        <input type="text" name="mobile" value="{{ $data->mobile }}" required>
                    </div>

                </div>

                <!-- Hidden Fields -->
                <input type="hidden" name="person_key" value="{{ $data->person_key }}">
                <input type="hidden" name="db_name" value="{{ $data->dbname }}">
                <input type="hidden" name="table_name" value="{{ $data->tablename }}">

                <button type="submit">
                    ✓ Confirm Entry
                </button>

            </form>

        </div>

    </div>

</body>

</html>