<?php


include('contactqr.php');
include('connectionandsearch.php');


?>



<!DOCTYPE html>
<html>

<head>
    <title>Print Manager</title>

    <style>
        html,
        body {
            height: 100%;
            margin: 0;

        }

        body {
            display: flex;
            justify-content: center;
            /* horizontal centering */
            align-items: center;
            /* vertical centering */
            flex-direction: column;
            font-family: 'Times New Roman', serif;
            min-height: 100vh;
            text-align: center;

            box-sizing: border-box;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 8px;
            font-size: 16px;
            width: 200px;
            box-sizing: border-box;
        }

        button {
            padding: 8px 12px;
            font-size: 16px;
            cursor: pointer;
        }

        #printSection {
            margin-top: 0px;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            #printSection,
            #printSection * {
                visibility: visible;
            }

            #printSection {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                display: flex;
                justify-content: center;
                align-items: center;
            }






            /* Default image opacity (Hides background image) */
            .image-container img {
                opacity: 0 !important;
            }

            /* Show image if override class is present */
            .image-container.opacity-enabled img {
                opacity: 1 !important;
            }

            /* FORCE THE QR CODE TO SHOW REGARDLESS OF OPACITY RULES */
            img.contactQr,
            .contactQr img,
            .contactqr img {
                visibility: visible !important;
                opacity: 1 !important;
                /* Overrides the 0 opacity rule above */
                display: block !important;

            }



            .contactqr {
                display: none;
            }

            .contactqr.show {
                display: block !important;
            }

            .overlay-text {
                color: blue !important;
            }

        }

        .no-wrap {
            white-space: nowrap;
        }

        .image-container {
            position: relative;
            display: inline-block;
            width: 9.2cm;
            /* height: 13.3cm;  */
            height: 13.67cm;

            /* border: 2px solid black; */
        }

        .image-container img {
            width: 100%;
            height: 100%;
            display: block;

        }

        .overlay-text {
            position: absolute;
            color: black;
            text-align: left;
            width: calc(100% - 40px);
            line-height: 1.6;
            text-align: center;
            /* ← ADD THIS */

        }

        #temp {
            position: absolute;
            text-align: left;

            margin-top: 300px;
            margin-left: 15px;
            line-height: 1.3;

            color: blue;
        }
    </style>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

</head>

<body>

    <div style="display: flex; gap: 20px; align-items: flex-start;">


        <div id="printSection" style="flex: 1; border: 1px solid #ccc; padding-top:0px;">
            <div class="image-container">
                <div id="temp">
                    <strong style="font-size: 24px; color: black;" contenteditable="true">
                        NISHANT VISHWAKARMA
                    </strong><br>

                    <span style="font-size: 24px; color: black;">
                        <span contenteditable="true">
                            Sphere Travel Media Pvt. Ltd.
                        </span><br>

                        <span contenteditable="true">
                            7909075195
                        </span>
                    </span>
                </div>

                <img id="badgeImage" src="trade2.jpg" alt="Background Image" class="background-image">
                <div class="overlay-text">



                    <?php if (!empty($search_result)): ?>

                        <?php foreach ($search_result as $row): ?>
                            <?php
                            // echo $row;
                            // print_r($row);
                    

                            if (!empty($row['select2'])) {
                                $name = strtoupper($row['select2']) . " " . strtoupper($row['name']);
                            } else {
                                $name = strtoupper($row['name']);
                            }
                            $company_name = strtoupper($row['company_name']);
                            $designation = $row['designation'];

                            // Combine all text blocks to evaluate length
                            $max_line_length = max(strlen($name), strlen($company_name), strlen($designation));

                            // Start from a reasonable base
                            $base_font_size = 20;

                            // Adjust down based on length
                            if ($max_line_length > 30) {
                                $base_font_size = 20;
                            } elseif ($max_line_length > 26) {
                                $base_font_size = 22;
                            } elseif ($max_line_length > 20) {
                                $base_font_size = 24;
                            }

                            // Final font sizes
                            if (strlen($name) < 14) {
                                $name_font_size = $base_font_size + 4;

                            } else {
                                $name_font_size = $base_font_size + 2;

                            }
                            // Name usually needs emphasis
                            $company_font_size = $base_font_size;          // Company
                            $designation_font_size = $base_font_size - 1;  // Designation, usually smallest
                            $qrUrl = generateContactQR($row);

                            ?>
                            <div id="BadeContent"
                                style="display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center;">

                                <div class="nameandCompany">
                                    <form method="POST" action="submittv.php" id="editForm">
                                        <!-- Visible editable name -->
                                        <strong id="nameEditable" contenteditable="true" class="no-wrap"
                                            style="font-size: <?= $name_font_size ?>px; color: black; text-transform: uppercase;">
                                            <?= htmlspecialchars($name) ?>
                                        </strong><br>

                                        <!-- Visible editable company name -->
                                        <span
                                            style="font-size: <?= $base_font_size ?>px; color: black; text-transform: uppercase;">
                                            <span id="companyEditable" contenteditable="true">
                                                <?= htmlspecialchars_decode(htmlspecialchars($company_name)) ?>
                                            </span><br>
                                        </span>

                                        <!-- Hidden inputs to store original values for comparison -->
                                        <input type="hidden" id="originalName" value="<?= htmlspecialchars($name) ?>" />
                                        <input type="hidden" id="originalCompany"
                                            value="<?= htmlspecialchars_decode(htmlspecialchars($company_name)) ?>" />
                                        <input type="hidden" id="originalMobile" value="<?= htmlspecialchars($mobile) ?>" />

                                        <!-- Hidden inputs to carry edited data for submission -->
                                        <input type="hidden" name="name" id="nameInput" />
                                        <input type="hidden" name="company_name" id="companyInput" />
                                        <input type="hidden" name="full_page" id="full_page" />

                                        <input type="hidden" name="mobile" id="mobileInput" />

                                    </form>
                                </div>


                                <div class="contactqr" style="border:1px solid black; display: none;">
                                    <style>
                                        .contactQr {
                                            width: 95px;
                                            height: 95px;
                                        }
                                    </style>

                                    <img src="<?php echo $qrUrl; ?>" alt="Contact QR" class="contactQr" id="contactQr">
                                    <script>
                                        const designation = <?= json_encode($designation) ?>;
                                        const mobile = <?= json_encode($row['mobile']) ?>;
                                        const city = <?= json_encode($row['city']) ?>;

                                        function updateQRCode() {
                                            const name = document.getElementById("nameEditable").innerText.trim();
                                            const company = document.getElementById("companyEditable").innerText.trim();

                                            const vcard =
                                                `BEGIN:VCARD
VERSION:3.0
FN:${name}
TITLE:${designation}
ORG:${company}
TEL:+91${mobile}
END:VCARD`;

                                            document.getElementById("contactQr").src =
                                                "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" +
                                                encodeURIComponent(vcard);
                                        }

                                        document.getElementById("nameEditable").addEventListener("input", updateQRCode);
                                        document.getElementById("companyEditable").addEventListener("input", updateQRCode);

                                        document.getElementById("nameEditable").addEventListener("input", updateQRCode);
                                        document.getElementById("companyEditable").addEventListener("input", updateQRCode);

                                    </script>
                                </div>


                                <!-- Hidden Form -->
                                <!-- <form method="POST" action="submittv.php" id="editForm">
  <input type="hidden" name="name" id="nameInput" />
  <input type="hidden" name="company_name" id="companyInput" />
  <input type="hidden" name="full_page" id="full_page" />
  <input type="hidden" name="mobile" id="mobileInput" />
</form> -->


                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>
            </div>
        </div>

        <!-- Form Section (Right Side) -->
        <div
            style="width: 350px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; border: 1px solid #ddd; padding: 12px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); background-color: #f9f9f9;">

            <!-- Position Controls -->
            <h3 style="margin-bottom: 7px; margin-top:5px;font-size: 16px; color: #333;">Position Settings</h3>
            <?php include 'controller.php'; ?>

        </div>


        <div id="visitorDisplayBox" style="
  width: 350px;
    height:515px;

  max-height:525px;
  padding: 4px;
  background-color:#f9f9f9;
  color: black;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  font-size: 1.1rem;
  border-radius: 12px;
  box-shadow: 0 1px 5px rgba(0,0,0,0.3);
  text-align: center;
  display:none;
  ">
            Loading visitor data...
        </div>

    </div>
    <div id="qr-reader" style="width: 300px;"></div>
    <div id="qr-result"></div>

    <!-- Hidden form to submit QR result to PHP -->
    <form id="qr-form" method="POST" action="">
        <input type="hidden" name="qrcode" id="qrcode-input">
    </form>
    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        console.log("Page Loaded");

        function onScanSuccess(decodedText, decodedResult) {
            // Show the scanned code
            document.getElementById('qr-result').innerText = `Scanned: ${decodedText}`;
            console.log(`QR matched: ${decodedText}`);

            // Set QR code in hidden input and submit form
            document.getElementById('qrcode-input').value = decodedText;
            document.getElementById('qr-form').submit();
        }

        // Initialize the scanner
        const html5QrCode = new Html5Qrcode("qr-reader");

        Html5Qrcode.getCameras().then(devices => {
            if (devices && devices.length) {
                let cameraId = devices[0].id;
                html5QrCode.start(
                    cameraId,
                    {
                        fps: 10,
                        qrbox: 250
                    },
                    onScanSuccess
                );
            }
        }).catch(err => {
            console.error("Camera access error: ", err);
        });
    </script>

    <?php if ($auto_print): ?>
        <script>

            function loadVisitorData(visitor_or_exhbitor) {
                const displayBox = document.getElementById('visitorDisplayBox');

                // First: Clear the display box
                displayBox.innerHTML = '';

                const fetch_url = visitor_or_exhbitor + ".php";
                console.log("fetch_url", fetch_url);

                // Then: Fetch and insert
                fetch(fetch_url)
                    .then(response => response.text())
                    .then(data => {
                        displayBox.innerHTML = data;
                    })
                    .catch(error => {
                        displayBox.innerText = "Error loading visitor data.";
                        console.error("Fetch error:", error);
                    });
            }


            // // Load immediately and then every 5 seconds
            // loadVisitorData();
            setInterval(updateImage, 15000);
            updateImage();





            function compareAndSubmitEdit() {
                const currentName = document.getElementById('nameEditable').innerText.trim().toUpperCase();
                const originalName = document.getElementById('originalName').value.trim().toUpperCase();
                const originalMobile = document.getElementById('originalMobile').value.trim().toUpperCase();
                const currentCompany = document.getElementById('companyEditable').innerText.trim().toUpperCase();
                const originalCompany = document.getElementById('originalCompany').value.trim().toUpperCase();


                if (currentName == originalName && currentCompany == originalCompany) {

                    window.print();

                } if (currentName !== originalName && currentCompany === originalCompany) {
                    console.log("Name is Changed");
                    document.getElementById('nameInput').value = currentName;
                    document.getElementById('companyInput').value = originalCompany;
                    document.getElementById('mobileInput').value = originalMobile;
                    document.getElementById('full_page').value = 'no';
                    document.getElementById('editForm').submit();
                }

                if (currentCompany !== originalCompany) {
                    console.log("Name and Company Both Changed Number is Required");
                    let mobile = prompt("Please enter your mobile number:");
                    if (mobile === null || mobile.trim() === "") {
                        alert("Mobile number is required to submit changes.");
                        return;
                    }
                    document.getElementById('nameInput').value = currentName;
                    document.getElementById('companyInput').value = currentCompany;
                    document.getElementById('mobileInput').value = mobile.trim();
                    document.getElementById('full_page').value = 'no';
                    document.getElementById('editForm').submit();
                }
            }

            function updateImage() {
                console.log("Interval is Working");
                const selected = document.querySelector('input[name="badgeType"]:checked').value;
                const img = document.getElementById('badgeImage');

                if (selected === 'exhibitor') {
                    img.src = 'trade2.jpg';
                    img.alt = 'Exhibitor Badge';
                    loadVisitorData("live_exhibitor");
                } else {
                    img.src = 'trade2.jpg';
                    img.alt = 'Trade Visitor Badge';
                    loadVisitorData("live_visitor");

                }
            }

            const overlayText = document.querySelector('.overlay-text');
            let originalTop = null;

            window.addEventListener('beforeprint', function () {
                const isChecked = document.getElementById('enableOpacity').checked;
                console.log("Is opacity enabled?", isChecked); // true if selected, false if not

                if (overlayText) {
                    // Save the original top value
                    originalTop = parseInt(getComputedStyle(overlayText).top, 10);

                    // If unchecked, move it up by 25px; otherwise leave it as is
                    const offset = isChecked ? 0 : 25;
                    overlayText.style.top = `${originalTop - offset}px`;
                }


            });

        </script>




    <?php endif; ?>

    <script>
        function smartNameFit() {
            const el = document.getElementById("nameEditable");
            if (!el) return;

            const containerWidth = document.querySelector(".overlay-text").offsetWidth;

            let fontSize = parseInt(window.getComputedStyle(el).fontSize);

            // Allow wrapping (for long names)
            el.style.whiteSpace = "normal";
            el.style.display = "inline-block";
            el.style.textAlign = "center";

            // If it fits without wrapping, keep font
            if (el.scrollWidth <= containerWidth) return;

            // If it wraps, try to shrink until it fits nicely
            while (el.scrollWidth > containerWidth && fontSize > 14) {
                fontSize -= 1;
                el.style.fontSize = fontSize + "px";
            }
        }

        window.addEventListener("load", smartNameFit);
        document.getElementById("nameEditable")?.addEventListener("input", smartNameFit);
    </script>

</body>

</html>