<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Details</title>

    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .card {
            background: #fff;
            max-width: 500px;
            margin: auto;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
            box-sizing: border-box;
        }

        #screenshotCard {
            background: #ffffff;
            padding: 15px;
            border-radius: 8px;
        }

        /* Styling for the new company logo container inside the card */
        .company-logo-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .company-logo {
            max-width: 180px;
            height: auto;
            display: inline-block;
        }

        .row {
            padding: 12px 8px;
            border-bottom: 1px solid #eee;
            font-size: 15px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 14px;
            margin-top: 12px;
            color: #fff;
            border: 0;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            box-sizing: border-box;
        }

        .btn-call {
            background: #198754;
        }

        .btn-vcard {
            background: #007AFF;
        }

        .btn-whatsapp {
            background: #25D366;
        }

        .btn-calendar {
            background: #FF9500;
        }

        .qr-section {
            text-align: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .qr-code {
            width: 160px;
            height: 160px;
            margin-top: 10px;
        }

        input[type=password] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            width: 120px;
        }
    </style>
</head>

<body>

    <div class="card">

        <!-- THIS AREA WILL BE SAVED AS IMAGE -->
        <div id="screenshotCard">

            <!-- Company Logo Section Added Here -->
            <div class="company-logo-container">
                <img class="company-logo" src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt=""
                    crossorigin="anonymous">
            </div>

            <h2> Details</h2>

            <div class="row">
                <strong>Name:</strong>
                <span id="dyn-name">{{ $data->name }}</span>
            </div>

            <div class="row">
                <strong>Designation:</strong>
                <span id="dyn-designation">{{ $data->designation }}</span>
            </div>

            <div class="row">
                <strong>Company:</strong>
                <span id="dyn-company">{{ $data->company_name }}</span>
            </div>

            <div class="row">
                <strong>Mobile:</strong>
                <span id="dyn-phone">{{ $data->mobile }}</span>
            </div>

            <div class="row">
                <strong>Email:</strong>
                <span id="dyn-email">{{ $data->email }}</span>
            </div>
            <!-- <h1>{{ $data->verification }}</h1> -->

            <div class="qr-section">
                <small>Scan QR to save contact</small><br>
                <img id="dynamic-qr" class="qr-code" src="" alt="QR Code" crossorigin="anonymous">
            </div>

            @if ($data->allowedit == 1)
                <div class="row">
                    <strong>Edit Data:</strong>
                    <a href="{{ url('editdata/' . $data->person_key) }}" class="btn btn-call">
                        Edit Contact
                    </a>
                </div>


            @endif
        </div>

        <button class="btn btn-vcard" onclick="saveScreenshot()">
            📸 Save Screenshot
        </button>

        <a href="tel:{{ $data->mobile }}" class="btn btn-call">
            Call Contact
        </a>

        <button class="btn btn-vcard" onclick="handleVcardUri()">
            Save to Contacts
        </button>

        <button class="btn btn-whatsapp" onclick="handleWhatsAppOpen()">
            Open in WhatsApp
        </button>

        <button class="btn btn-calendar" onclick="handleCalendarShortcut()">
            Create Meeting
        </button>

        <div class="row">
            <strong>Other Info:</strong><br><br>
            <input type="password" id="lastFour" maxlength="4" inputmode="numeric" placeholder="Last 4 digits">
        </div>

        <a href="javascript:void(0)" id="editBtn" class="btn btn-call">
            Edit Contact
        </a>

    </div>

    <script>
        function getPageData() {
            return {
                name: document.getElementById('dyn-name').innerText.trim(),
                title: document.getElementById('dyn-designation').innerText.trim(),
                company: document.getElementById('dyn-company').innerText.trim(),
                phone: document.getElementById('dyn-phone').innerText.trim(),
                email: document.getElementById('dyn-email').innerText.trim()
            };
        }

        async function saveScreenshot() {
            const target = document.getElementById("screenshotCard");

            const canvas = await html2canvas(target, {
                scale: 3,                 // Keeps everything pin-sharp
                useCORS: true,            // Crucial! Allows html2canvas to fetch and render your logo and the QR code securely without blurring
                logging: false,
                backgroundColor: "#ffffff",
                windowWidth: target.scrollWidth,
                windowHeight: target.scrollHeight
            });

            const a = document.createElement("a");
            a.download = "Visitor-Contact.png";
            a.href = canvas.toDataURL("image/png", 1.0);
            a.click();
        }

        function handleVcardUri() {
            const d = getPageData();
            const vcard = [
                "BEGIN:VCARD",
                "VERSION:3.0",
                `FN:${d.name}`,
                `ORG:${d.company}`,
                `TITLE:${d.title}`,
                `TEL:${d.phone}`,
                `EMAIL:${d.email}`,
                "END:VCARD"
            ].join("\n");

            window.location.href = "data:text/vcard;charset=utf-8," + encodeURIComponent(vcard);
        }

        function handleWhatsAppOpen() {
            const d = getPageData();
            const phone = d.phone.replace(/\D/g, '');
            window.open("https://wa.me/" + phone + "?text=" + encodeURIComponent("Hi " + d.name), "_blank");
        }

        function handleCalendarShortcut() {
            const d = getPageData();
            const ics = [
                "BEGIN:VCALENDAR",
                "VERSION:2.0",
                "BEGIN:VEVENT",
                "SUMMARY:Meeting with " + d.name,
                "DESCRIPTION:Phone: " + d.phone + "\\nEmail: " + d.email,
                "DTSTART:20260711T120000Z",
                "DTEND:20260711T130000Z",
                "END:VEVENT",
                "END:VCALENDAR"
            ].join("\n");

            window.location.href = "data:text/calendar;charset=utf-8," + encodeURIComponent(ics);
        }

        document.getElementById("editBtn").addEventListener("click", function () {
            const lastFour = document.getElementById("lastFour").value.trim();
            if (!/^\d{4}$/.test(lastFour)) {
                alert("Enter the last 4 digits.");
                return;
            }
            window.location.href = "{{ url('editdata/' . $data->person_key) }}/";
        });

        window.onload = function () {
            const d = getPageData();
            const vcard = `BEGIN:VCARD\nVERSION:3.0\nFN:${d.name}\nORG:${d.company}\nTITLE:${d.title}\nTEL:${d.phone}\nEMAIL:${d.email}\nEND:VCARD`;

            document.getElementById("dynamic-qr").src =
                "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" + encodeURIComponent(vcard);
        };
    </script>
</body>

</html>