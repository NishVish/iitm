// Step 4: Generate QR code using Google Chart API
    $qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($person_key);
    echo "<p>QR Code:</p><img src='$qr_url' alt='QR Code'>";