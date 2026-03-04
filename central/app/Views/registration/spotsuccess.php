<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Success | IITM</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0073e6;
            --secondary: #00c6ff;
            --bg-gradient: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            --glass: rgba(255, 255, 255, 0.95);
        }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 20px;
            background: var(--bg-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2d3436;
        }

        .container {
            max-width: 450px;
            width: 100%;
            background: var(--glass);
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.3);
            transition: transform 0.3s ease;
        }

        .logo {
            max-width: 120px;
            margin-bottom: 20px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.05));
        }

        .success-icon {
            font-size: 50px;
            margin-bottom: 10px;
            display: block;
            animation: bounce 2s infinite;
        }

        h2 {
            font-weight: 800;
            font-size: 24px;
            margin-top: 0;
            color: #1a1a1a;
            letter-spacing: -0.5px;
        }

        .info-card {
            background: rgba(0,0,0,0.03);
            padding: 20px;
            border-radius: 16px;
            margin: 25px 0;
            text-align: left;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding-bottom: 8px;
        }

        .info-row:last-child { border: none; }

        .label { color: #636e72; font-weight: 400; }
        .value { color: #2d3436; font-weight: 600; }

        .qr-section {
            background: white;
            padding: 20px;
            border-radius: 20px;
            box-shadow: inset 0 2px 8px rgba(0,0,0,0.05);
            margin-top: 20px;
        }

        #qrImage {
            margin: 15px 0;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        #qrImage:hover {
            transform: scale(1.05);
        }

        .instruction {
            font-size: 13px;
            color: #636e72;
            line-height: 1.6;
            margin: 15px 0;
        }

        button {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            border: none;
            padding: 16px 24px;
            border-radius: 14px;
            font-weight: 600;
            font-size: 16px;
            width: 100%;
            cursor: pointer;
            box-shadow: 0 10px 20px rgba(0, 115, 230, 0.2);
            transition: all 0.3s ease;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(0, 115, 230, 0.3);
        }

        button:active { transform: translateY(0); }

        .welcome-msg {
            margin-top: 25px;
            font-size: 14px;
            color: var(--primary);
            font-weight: 600;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
            40% {transform: translateY(-10px);}
            60% {transform: translateY(-5px);}
        }

        @media (max-width: 480px) {
            .container { padding: 25px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt="IITM Logo" class="logo">
        
        <span class="success-icon">✅</span>
        <h2>Confirmed!</h2>

        <div class="info-card">
            <div class="info-row">
                <span class="label">Name</span>
                <span class="value"><?= !empty($alldata['contactName']) ? esc($alldata['contactName']) : 'N/A'; ?></span>
            </div>
            <div class="info-row">
                <span class="label">Company</span>
                <span class="value"><?= !empty($alldata['companyName']) ? esc($alldata['companyName']) : 'N/A'; ?></span>
            </div>
            <div class="info-row">
                <span class="label">Designation</span>
                <span class="value"><?= !empty($alldata['designation']) ? esc($alldata['designation']) : 'N/A'; ?></span>
            </div>
            <div class="info-row">
                <span class="label">Mobile</span>
                <span class="value"><?= !empty($mobile) ? esc($mobile) : 'N/A'; ?></span>
            </div>
        </div>

        <div class="qr-section">
            <p style="margin: 0; font-weight: 600; font-size: 14px;">Entry Pass QR Code</p>
            <?php $qr_data = urlencode(($mobile)); ?>
            <img id="qrImage" src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=<?= $qr_data ?>" alt="QR Code">
            
            <p class="instruction">
                Show this QR code at the <strong>Registration Counter</strong> to quickly print your badge.
            </p>
            
            <button onclick="downloadQR()">Save Pass to Phone</button>
        </div>

        <p class="welcome-msg">See you at IITM! 🚀</p>
    </div>

    <script>
        async function downloadQR() {
            const img = document.getElementById('qrImage');
            const url = img.src;
            const btn = document.querySelector('button');
            
            btn.innerText = "Downloading...";

            try {
                const response = await fetch(url, { mode: 'cors' });
                if (!response.ok) throw new Error('Failed');

                const blob = await response.blob();
                const blobUrl = window.URL.createObjectURL(blob);

                const a = document.createElement('a');
                a.href = blobUrl;
                a.download = 'IITM_Entry_Pass.png';
                document.body.appendChild(a);
                a.click();
                a.remove();

                window.URL.revokeObjectURL(blobUrl);
                btn.innerText = "Save Pass to Phone";
            } catch (error) {
                alert('Error downloading QR code: ' + error.message);
                btn.innerText = "Save Pass to Phone";
            }
        }
    </script>
</body>
</html>

