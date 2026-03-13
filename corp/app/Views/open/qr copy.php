<!DOCTYPE html>
<html>
<head>
    <title>Live QR Code Generator</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        #qrcode {
            margin-top: 20px;
        }
        input[type="text"] {
            width: 400px;
            padding: 8px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <h1>Live QR Code Generator</h1>

    <?php
    // Decode the value if type is 'link'
    $url = $value;
    if ($type === 'link') {
        $url = str_replace('-', '/', $value);
    }
    ?>

    <!-- Input field -->
    <input type="text" id="urlInput" placeholder="Enter URL here" value="<?= htmlspecialchars($url) ?>">

    <!-- QR Code container -->
    <div id="qrcode"></div>

    <script>
        const urlInput = document.getElementById('urlInput');
        const qrContainer = document.getElementById('qrcode');

        function generateQRCode(url) {
            qrContainer.innerHTML = '';
            if (!url) return;
            new QRCode(qrContainer, {
                text: url,
                width: 200,
                height: 200,
                colorDark : "#000000",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });
        }

        // Generate QR code for initial value
        generateQRCode("<?= addslashes($url) ?>");

        // Live update as user types
        urlInput.addEventListener('input', function() {
            generateQRCode(urlInput.value.trim());
        });
    </script>
</body>
</html>