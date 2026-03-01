
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Success | IITM</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f2f2f2;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #2a2a2a;
        }
        .info {
            margin-bottom: 10px;
            font-size: 16px;
            line-height: 1.5;
        }
        .qr-code {
            text-align: center;
            margin-top: 20px;
        }
        button {
            display: block;
            width: 100%;
            padding: 12px;
            font-size: 16px;
            margin-top: 15px;
            background-color: #0073e6;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #005bb5;
        }
        img.logo {
            max-width: 150px;
            display: block;
            margin: 0 auto 15px auto;
        }
        .programme-schedule {
            font-family: Arial, sans-serif;
            max-width: 100%;
            margin: 20px 0;
            padding: 20px;
            background: #f9f9f9;
            border-left: 6px solid #3f51b5;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt="IITM Logo" class="logo">
        <h2>Registration Successful!</h2>

        <div class="info"><strong>Name:</strong> <?= !empty($alldata['contactName']) ? esc($alldata['contactName']) : 'N/A'; ?></div>
        <div class="info"><strong>Designation:</strong> <?= !empty($alldata['designation']) ? esc($alldata['designation']) : 'N/A'; ?></div>
        <div class="info"><strong>Company Name:</strong> <?= !empty($alldata['companyName']) ? esc($alldata['companyName']) : 'N/A'; ?></div>
        <div class="info"><strong>Mobile:</strong> <?= !empty($mobile) ? esc($mobile) : 'N/A'; ?></div>
        <div class="info"><strong>Email:</strong> <?= !empty($alldata['email']) ? esc($alldata['email']) : 'N/A'; ?></div>

        <div class="qr-code">
            <h2>🎉 You're All Set!</h2>
            <p style="font-size: 1.1em; font-weight: 500; text-align: center; margin: 10px 0;">
                📲 <strong>Final Step:</strong> Please mention your <strong>mobile number or Show QR Code</strong> at the <strong>registration counter</strong> to print your entry pass.
            </p>
            <p><strong>Registration Key QR Code:</strong></p>
            
            <?php 
                $qr_data = urlencode(($mobile));
            ?>
            <img id="qrImage" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?= $qr_data ?>" alt="QR Code">
            
            <button onclick="downloadQR()">Download QR Code</button>

            <p>🙌 <strong>Welcome to IITM — we're excited to have you here!</strong></p>
        </div>

        <!-- <div class="programme-schedule">
            <h2 style="font-size: 1.2em; margin-bottom: 5px;">📅 Event Details</h2>
            <p><strong>Event:</strong> <?= esc($event[0]['name'] ?? 'IITM Event'); ?></p>
            <p><strong>Venue:</strong> <?= esc($event[0]['venue_details'] ?? 'TBA'); ?></p>
        </div> -->
    </div>

    <script>
        async function downloadQR() {
            const img = document.getElementById('qrImage');
            const url = img.src;

            try {
                const response = await fetch(url, { mode: 'cors' });
                if (!response.ok) throw new Error('Failed to fetch QR image.');

                const blob = await response.blob();
                const blobUrl = window.URL.createObjectURL(blob);

                const a = document.createElement('a');
                a.href = blobUrl;
                a.download = 'iitm_qr_code.png';
                document.body.appendChild(a);
                a.click();
                a.remove();

                window.URL.revokeObjectURL(blobUrl);
            } catch (error) {
                alert('Error downloading QR code: ' + error.message);
            }
        }
    </script>
</body>
</html>
