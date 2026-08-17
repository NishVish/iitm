<!DOCTYPE html>
<html>

<head>
    <title>Generated Questions</title>
    <style>
        body {
            font-family: Arial;
            padding: 30px;
        }

        .box {
            max-width: 800px;
            margin: auto;
        }

        li {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <div class="box">

        <h2>Generated Questions</h2>

        @isset($error)
            <p style="color:red">{{ $error }}</p>
        @endisset

        @isset($inserted)
            <p><b>Inserted:</b> {{ $inserted }}</p>
        @endisset

        <ul>
            @isset($questions)
                @foreach($questions as $q)
                    <li>{{ $q }}</li>
                @endforeach
            @endisset
        </ul>

    </div>

</body>

</html>