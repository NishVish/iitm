<!DOCTYPE html>
<html>

<head>
    <title>Registration Successful</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }

        .logo {
            width: 180px;
            display: block;
            margin: auto;
        }

        h2 {
            text-align: center;
            color: #198754;
        }

        .info {
            padding: 8px 0;
            font-size: 16px;
            border-bottom: 1px solid #eee;
        }

        .delegate {
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .delegate-details {
            flex: 1;
        }

        .qr-code {
            width: 160px;
            text-align: center;
            flex-shrink: 0;
        }

        .qr-code img {
            width: 130px;
        }

        button {
            background: #198754;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
        }

        @media(max-width:600px) {
            .delegate {
                flex-direction: column;
            }

            .qr-code {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt="IITM Logo" class="logo">

        <h2>Registration Successful!</h2>

        <div class="info">
            <strong>Company Name:</strong>
            {{ $data['company_name'] }}
        </div>

        <div class="info">
            <strong>Company ID:</strong>
            {{ $data['company_id'] }}
        </div>


        <h3>Delegate Details</h3>


        @foreach($data['delegates'] as $index => $delegate)

            <div class="delegate">

                <div class="delegate-details">

                    <h4>Delegate {{ $index + 1 }}</h4>

                    <div class="info">
                        <strong>Name:</strong>
                        {{ $delegate['name'] }}
                    </div>

                    <div class="info">
                        <strong>Designation:</strong>
                        {{ $delegate['designation'] }}
                    </div>

                    <div class="info">
                        <strong>Mobile:</strong>
                        {{ $delegate['mobile'] }}
                    </div>

                    <div class="info">
                        <strong>Email:</strong>
                        {{ $delegate['email'] }}
                    </div>

                </div>


                <div class="qr-code">

                    <strong>QR Code</strong>

                    <br><br>

                    <img id="qrImage{{ $index }}"
                        src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $delegate['mobile'] }}"
                        alt="QR Code">

                    <br><br>

                    <button onclick="downloadQR('qrImage{{ $index }}')">
                        Download QR
                    </button>

                </div>

            </div>

        @endforeach


        <div class="qr-code" style="width:100%; margin-top:30px;">

            <h2>🎉 You're All Set!</h2>

            <p>
                📲 Please show your QR code at the registration counter to print your entry pass.
            </p>

            <p>
                🙌 <strong>Welcome to IITM — we're excited to have you here!</strong>
            </p>

        </div>


    </div>


    <script>

        async function downloadQR(id) {

            const img = document.getElementById(id);
            const url = img.src;

            try {

                const response = await fetch(url);

                if (!response.ok) {
                    throw new Error('Failed to fetch QR image.');
                }

                const blob = await response.blob();

                const blobUrl = window.URL.createObjectURL(blob);

                const a = document.createElement('a');
                a.href = blobUrl;
                a.download = 'registration_qr.png';

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