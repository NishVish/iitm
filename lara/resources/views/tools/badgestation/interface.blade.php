<!DOCTYPE html>
<html>

<head>
    <title>Badge Station Interface</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            text-align: center;
            padding: 30px;
        }

        .container {
            background: #fff;
            max-width: 500px;
            margin: auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }

        h2 {
            color: #198754;
        }

        .mobile {
            font-size: 40px;
            font-weight: bold;
            margin: 30px 0;
            color: #222;
        }

        .waiting {
            color: #777;
            font-size: 20px;
        }
    </style>
</head>

<body>

    <div class="container">

        <h2>Badge Station</h2>

        <p>Relay ID: {{ $id }}</p>

        <div class="mobile" id="mobileNumber">

            @if($data && $data->mobilenumber)
                {{ $data->mobilenumber }}
            @else
                <span class="waiting">Waiting for scan...</span>
            @endif

        </div>

    </div>


    <script>

        setInterval(function () {

            fetch("{{ url('badgestation/interface/' . $id) }}")
                .then(response => response.text())
                .then(html => {

                    let parser = new DOMParser();
                    let doc = parser.parseFromString(html, 'text/html');

                    let mobile = doc.getElementById('mobileNumber').innerHTML;

                    document.getElementById('mobileNumber').innerHTML = mobile;

                });

        }, 2000);

    </script>

</body>

</html>