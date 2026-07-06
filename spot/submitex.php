<?php
include('db.php');

// Get the last ID from the tradevisitor table
$sqlx = "SELECT MAX(id) AS last_id FROM exhibitor";
$resultx = $conn->query($sqlx);

$last_id = 0;
if ($resultx && $row = $resultx->fetch_assoc()) {
    $last_id = $row['last_id'] ?? 0;
}
$new_id = $last_id + 1;

$name = isset($_POST['name']) ? $_POST['name'] : 'Unknown';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $names = $_POST['delegates']; // first delegate becomes the main name

    foreach ($names as $name) {
        $person_key = $new_id . "_" . strtolower($name);
        $designation = 'NA';

        // $designation = $_POST['designation'];
        $company_name = $_POST['company_name'];
        $last_segment = $_POST['last_segment'];
        // $address = $_POST['address'];
        // $city = $_POST['city'];
        // $pin = $_POST['pin'];
        // $state = $_POST['state'];
        // var_dump($name);


        // exit;
        // dd($last_segment);
        $address = 'NA';
        $city = 'NA';
        $pin = 'NA';
        $state = 'NA';

        $mobile = $_POST['mobile'];
        // $email = $_POST['email'];
        $email = 'NA';
        $sql = "INSERT INTO exhibitor (person_key, name, designation, company_name, address, city, pin, state, mobile, email)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssss", $person_key, $name, $designation, $company_name, $address, $city, $pin, $state, $mobile, $email);

        if ($stmt->execute()) {
            $qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($person_key);
        }


        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Registration Success</title>
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
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
                    justify-contect: left;
                    font-family: Arial, sans-serif;
                    max-width: 700px;
                    margin: 20px auto;
                    padding: 20px;
                    background: #f9f9f9;
                    border-left: 6px solid #3f51b5;
                    text-align: left;
                }

                .programme-schedule h2 {
                    color: #3f51b5;
                }

                .programme-schedule h3 {
                    margin-top: 0;
                    font-size: 1.2em;
                }

                .programme-schedule h4 {
                    margin-top: 20px;
                    color: #444;
                }

                .programme-schedule ul {
                    padding-left: 20px;
                }

                .programme-schedule li {
                    margin-bottom: 5px;
                }
            </style>
        </head>

        <body>
            <div class="container">
                <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt="IITM Logo" class="logo">
                <h2>Registration Successful!</h2>

                <div class="info"><strong>Name:</strong> <?= htmlspecialchars($name) ?></div>
                <!--<div class="info"><strong>Designation:</strong> <?= htmlspecialchars($designation) ?></div>-->
                <div class="info"><strong>Company Name:</strong> <?= htmlspecialchars($company_name) ?></div>
                <!--<div class="info"><strong>Address:</strong> <?= htmlspecialchars($address) ?></div>-->
                <!--<div class="info"><strong>City:</strong> <?= htmlspecialchars($city) ?></div>-->
                <!--<div class="info"><strong>PIN Code:</strong> <?= htmlspecialchars($pin) ?></div>-->
                <!--<div class="info"><strong>State:</strong> <?= htmlspecialchars($state) ?></div>-->
                <div class="info"><strong>Mobile:</strong> <?= htmlspecialchars($mobile) ?></div>
                <!--<div class="info"><strong>Email:</strong> <?= htmlspecialchars($email) ?></div>-->

                <div class="qr-code">
                    <p><strong>Registration Key QR Code:</strong></p>
                    <img id="qrImage" src="<?= $qr_url ?>" alt="QR Code">
                    <button onclick="downloadQR()">Download QR Code</button>
                    <h2>🎉 You're All Set!</h2>
                    <p style="font-size: 1.1em; font-weight: 500; text-align: center; margin: 10px 0;">
                        📲 <strong>Final Step:</strong> Please mention your <strong>mobile number</strong> at the
                        <strong>registration counter</strong> to print your entry pass.
                    </p>

                    <p>🙌 <strong>We sincerely appreciate your participation as an exhibitor at the IITM Exhibition. We look
                            forward to a successful and engaging event together.</strong></p>

                    <p>
                        <!--            <div class="programme-schedule">-->
                        <!--  <h2>📅 Full Event Schedule IITM Bengaluru</h2>-->
                        <!--  <p><strong>Dates:</strong> 24 – 26 July 2025</p>-->
                        <!--  <p><strong>Venue:</strong> Hall No. A, Gate No. 2, Tripura Vasini, Palace Grounds,<br>-->
                        <!--     Bellary Road, Near Mekhri Circle, Bengaluru - 560006-->
                        <!--  </p>-->

                        <!--  <section>-->
                        <!--    <h4>Wednesday, 23 July 2025</h4>-->
                        <!--    <ul>-->
                        <!--      <li>05:00 PM: Stall Setup</li>-->
                        <!--    </ul>-->
                        <!--  </section>-->

                        <!--  <section>-->
                        <!--    <h4>Thursday, 24 July 2025</h4>-->
                        <!--    <ul>-->
                        <!--      <li>09:00 AM – 10:30 AM: Registration</li>-->
                        <!--      <li>12:00 PM: Inauguration</li>-->
                        <!--      <li>11:00 AM – 6:30 PM: Exhibition Open for Business (B2B)</li>-->

                        <!--    </ul>-->
                        <!--  </section>-->

                        <!--  <section>-->
                        <!--    <h4>Friday, 25 July 2025</h4>-->
                        <!--    <ul>-->
                        <!--      <li>11:00 AM – 6:30 PM: Exhibition Open for Business (B2B)</li>-->
                        <!--      <li>03:00 PM: Tourism Malaysia Presentation</li>-->
                        <!--    </ul>-->
                        <!--  </section>-->

                        <!--  <section>-->
                        <!--    <h4>Saturday, 26 July 2025</h4>-->
                        <!--    <ul>-->
                        <!--      <li>11:00 AM – 6:30 PM: Exhibition Open for Business (B2B)</li>-->
                        <!--    </ul>-->
                        <!--    <p><strong>Note:</strong> Exhibition Closes at 6:30 PM Daily</p>-->
                        <!--  </section>-->
                        <!--</div>-->


                    </p>


                </div>
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
                        a.download = 'qr_code.png';
                        document.body.appendChild(a);
                        a.click();
                        a.remove();

                        window.URL.revokeObjectURL(blobUrl);
                        // download_pdf()

                    } catch (error) {
                        alert('Error downloading QR code: ' + error.message);
                    }
                }


                function download_pdf() {
                    setTimeout(() => {
                        const pdfUrl = '/IITM%20Registration/Offline/map.pdf';

                        const a = document.createElement('a');
                        a.href = pdfUrl;
                        a.download = 'myfile.pdf';
                        document.body.appendChild(a);
                        a.click();
                        a.remove();
                    }, 2000);
                }
            </script>
        </body>

        </html>
        <?php
    }
} else {
    echo "Error: " . $stmt->error;
}

?>