<!DOCTYPE html>
<html>
<head>
    <title>Live QR Code Generator</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        #qrcode {
            margin-top: 20px;
        }
        input, select {
            width: 400px;
            padding: 8px;
            font-size: 16px;
            margin-top: 10px;
        }
        label{
            display:block;
            margin-top:15px;
            font-weight:bold;
        }
    </style>
</head>
<body>

<h1>Live QR Code Generator</h1>

<?php
$url = $value ?? '';
?>

<label for="typeSelect">Type</label>
<select id="typeSelect">
    <option value="text" <?= ($type ?? '')=='text'?'selected':'' ?>>Text</option>
    <option value="whatsapp" <?= ($type ?? '')=='whatsapp'?'selected':'' ?>>WhatsApp</option>
</select>

<label for="urlInput">Value</label>
<input type="text" id="urlInput" placeholder="Enter text or phone number" value="<?= htmlspecialchars($url) ?>">

<div id="qrcode"></div>

<script>
const urlInput = document.getElementById('urlInput');
const typeSelect = document.getElementById('typeSelect');
const qrContainer = document.getElementById('qrcode');

function generateQRCode() {

    let value = urlInput.value.trim();
    let type = typeSelect.value;

    if (!value) {
        qrContainer.innerHTML = '';
        return;
    }

    if(type === "whatsapp"){
        value = "https://wa.me/" + value.replace(/\D/g,'');
    }

    qrContainer.innerHTML = '';

    new QRCode(qrContainer, {
        text: value,
        width: 220,
        height: 220,
        colorDark : "#000000",
        colorLight : "#ffffff",
        correctLevel : QRCode.CorrectLevel.H
    });
}

generateQRCode();

urlInput.addEventListener('input', generateQRCode);
typeSelect.addEventListener('change', generateQRCode);

</script>

</body>
</html>