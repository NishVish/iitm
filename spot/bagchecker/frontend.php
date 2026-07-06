<!DOCTYPE html>
<html>

<head>
    <title>Bag Distribution</title>


    <script src="https://unpkg.com/html5-qrcode"></script>

</head>

<body>

    <div class="phone">

        <div class="header">
            📷 Bag Distribution
        </div>

        <div class="container">

            <form method="post" id="searchForm">

                <div class="card">

                    <div class="label">Mobile Number</div>

                    <input type="text" id="mobile" name="mobile" placeholder="Scan or enter mobile number">

                    <button class="scan-btn" type="submit">
                        Search
                    </button>

                </div>

            </form>


            <?php if (!empty($search_result)): ?>

                <?php foreach ($search_result as $row): ?>
                    <!--  -->

                    <div class="card">

                        <div class="label">Status</div>

                        <div class="status">
                            <span id="statusText">
                                <?php if ($row['bag_collected'] == 0) { ?>
                                    <span style="color:green;font-size:20px;">&#10004;</span>
                                <?php } else { ?>
                                    <span style="color:red;font-size:20px;">&#10008;</span>
                                <?php } ?>
                                <?= htmlspecialchars_decode(htmlspecialchars($mobile)) ?>

                            </span>
                        </div>

                    </div>



                    <?php
                    $name = !empty($row['select2'])
                        ? strtoupper($row['select2']) . " " . strtoupper($row['name'])
                        : strtoupper($row['name']);

                    $company_name = strtoupper($row['company_name']);
                    ?>

                    <div class="card">

                        <div class="label">Found Record</div>

                        <div class="info-row">
                            <span>Name</span>

                            <strong id="nameEditable" contenteditable="true">

                                <?= htmlspecialchars($name) ?>

                            </strong>
                        </div>

                        <div class="info-row">
                            <span>Company</span>

                            <strong id="companyEditable" contenteditable="true">

                                <?= htmlspecialchars_decode(htmlspecialchars($company_name)) ?>

                            </strong>
                        </div>

                        <input type="hidden" id="nameInput" name="name">
                        <input type="hidden" id="companyInput" name="company_name">

                    </div>

                <?php endforeach; ?>

            <?php endif; ?>

            <div class="card">

                <div class="label">
                    Scanner Camera Feed
                </div>

                <div class="camera">

                    <div id="reader"></div>

                    <div class="scan-box"></div>

                    <div class="scan-line"></div>

                </div>

            </div>

        </div>

    </div>

    <script>

        function onScanSuccess(decodedText) {

            document.getElementById("mobile").value = decodedText;

            document.getElementById("statusText").innerText = "QR Detected";

            scanner.clear();

            document.getElementById("searchForm").submit();
        }

        scanner.render(onScanSuccess);

        const nameEditable = document.getElementById("nameEditable");
        const companyEditable = document.getElementById("companyEditable");

        if (nameEditable) {

            document.getElementById("nameInput").value =
                nameEditable.innerText.trim();

            nameEditable.addEventListener("input", function () {

                document.getElementById("nameInput").value =
                    this.innerText.trim();

            });

        }

        if (companyEditable) {

            document.getElementById("companyInput").value =
                companyEditable.innerText.trim();

            companyEditable.addEventListener("input", function () {

                document.getElementById("companyInput").value =
                    this.innerText.trim();

            });

        }
    </script>

    <style>
        .camera {
            position: relative;
            width: 100%;
            height: 320px;
            background: #000;
            border-radius: 15px;
            overflow: hidden;
        }

        #reader {
            width: 100%;
            height: 100%;
        }

        #reader video {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
        }

        #reader__scan_region {
            width: 100% !important;
            height: 100% !important;
        }

        #reader img {
            display: none !important;
        }

        #reader__dashboard {
            display: none !important;
        }
    </style>

    <script>
        const scanner = new Html5Qrcode("reader");

        scanner.start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: { width: 220, height: 220 }
            },
            function (decodedText) {
                console.log(decodedText);

                let mobile = decodedText;

                // If it's a vCard, extract the mobile number
                if (decodedText.includes("BEGIN:VCARD")) {
                    const match = decodedText.match(/TEL:\+?(\d+)/);

                    if (match) {
                        mobile = match[1];

                        // Keep only the last 10 digits (remove country code)
                        if (mobile.length > 10) {
                            mobile = mobile.slice(-10);
                        }
                    }
                }

                console.log("Mobile:", mobile);

                document.getElementById("mobile").value = mobile;
                document.getElementById("statusText").innerHTML = "QR Detected";
                scanner.stop().then(() => {
                    document.getElementById("searchForm").submit();
                });
            },
            function () { }
        );
    </script>

</body>

</html>