<!DOCTYPE html>
<html>

<head>
    <title>PDF To Text</title>

    <style>
        body {
            font-family: Arial;
            padding: 40px;
            background: #f5f5f5;
        }

        .box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            max-width: 1000px;
            margin: auto;
        }

        textarea {
            width: 100%;
            height: 500px;
            padding: 15px;
            margin-top: 20px;
            font-size: 14px;
        }

        button {
            padding: 10px 20px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="box">

        <h1>PDF To Text</h1>

        <form method="POST" action="{{ route('pdf.convert') }}" enctype="multipart/form-data">

            @csrf

            <input type="file" name="pdf" required>

            <button type="submit">
                Convert
            </button>

        </form>

        @isset($error)

            <div style="color:red;margin-top:20px;">
                {{ $error }}
            </div>

        @endisset

        @isset($text)

            <textarea>{{ $text }}</textarea>

        @endisset

    </div>

</body>

</html>