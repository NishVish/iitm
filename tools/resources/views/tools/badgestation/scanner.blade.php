<!DOCTYPE html>
<html>

<head>
    <title>QR Scanner</title>

    <script src="https://unpkg.com/html5-qrcode"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }

        #reader {
            width: 350px;
            margin: auto;
        }

        .status {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <h2>QR Scanner</h2>

    <div id="reader"></div>

    <div class="status" id="status"></div>


    <form id="scanForm" method="POST" action="{{ url('badgestation/scanner', $relay) }}">
        @csrf
        <input type="text" name="relay" id="relay" value="{{ $relay }}">
        <input type="hidden" name="scannedqrdata" id="scannedqrdata">
    </form>

    <h2>{{ $scannedqrdata }}</h2>
    <script>

        function onScanSuccess(decodedText, decodedResult) {

            document.getElementById('status').innerHTML =
                "Scanned: " + decodedText;


            document.getElementById('scannedqrdata').value = decodedText;


            document.getElementById('scanForm').submit();

        }


        function onScanFailure(error) {

        }


        let scanner = new Html5QrcodeScanner(
            "reader",
            {
                fps: 10,
                qrbox: 250
            }
        );


        scanner.render(
            onScanSuccess,
            onScanFailure
        );


    </script>

</body>

</html>