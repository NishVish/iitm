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

    <!-- Input field -->
    <input type="text" id="urlInput" placeholder="Enter URL here" value="<?= htmlspecialchars($url ?? '') ?>">

    <!-- QR Code container -->
    <div id="qrcode"></div>

    <script>
        const urlInput = document.getElementById('urlInput');
        const qrContainer = document.getElementById('qrcode');
        let qrCodeInstance = null;

        function generateQRCode(url) {
            // Clear previous QR code
            qrContainer.innerHTML = '';
            if (!url) return;

            // Create new QR code
            qrCodeInstance = new QRCode(qrContainer, {
                text: url,
                width: 200,
                height: 200,
                colorDark : "#000000",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });
        }

        // Generate QR code for initial PHP value (if any)
        <?php if (!empty($url)) : ?>
            generateQRCode("<?= addslashes($url) ?>");
        <?php endif; ?>

        // Live update as user types
        urlInput.addEventListener('input', function() {
            generateQRCode(urlInput.value.trim());
        });
    </script>
</body>
</html>