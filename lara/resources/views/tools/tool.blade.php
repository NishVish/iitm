<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Document Scanner (Front/Back Mode)</title>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #0f172a;
            color: white;
            text-align: center;
            margin: 0;
            padding: 20px;
        }

        #camera-wrapper {
            position: relative;
            width: 100%;
            max-width: 500px;
            margin: auto;
            border: 3px solid #6366f1;
            border-radius: 15px;
            overflow: hidden;
            background: #000;
        }

        video {
            width: 100%;
            display: block;
        }

        .controls {
            margin: 20px 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        /* Mode Switch Styling */
        .mode-selector {
            background: #1e293b;
            padding: 10px;
            border-radius: 50px;
            border: 1px solid #334155;
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }

        .mode-btn {
            background: transparent;
            border: none;
            color: #94a3b8;
            padding: 8px 20px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        .mode-btn.active {
            background: #6366f1;
            color: white;
        }

        button.main-scan {
            background: #6366f1;
            color: white;
            border: none;
            padding: 15px 40px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 10px;
            cursor: pointer;
        }

        button:disabled {
            background: #334155;
            opacity: 0.7;
        }

        .status {
            font-size: 14px;
            color: #94a3b8;
            min-height: 20px;
        }

        .main-container {
            display: flex;
            gap: 20px;
            justify-content: center;
            align-items: flex-start;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        #result-box {
            flex: 1;
            min-width: 300px;
            max-width: 450px;
            background: #1e293b;
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #334155;
            white-space: pre-wrap;
            font-size: 12px;
            color: #cbd5e1;
            text-align: left;
            height: 400px;
            overflow-y: auto;
        }

        .form-container {
            flex: 1;
            min-width: 300px;
            max-width: 450px;
            background: #1e293b;
            padding: 20px;
            border-radius: 15px;
            border: 1px solid #6366f1;
            text-align: left;
        }

        .form-group {
            margin-bottom: 12px;
        }

        label {
            display: block;
            font-size: 11px;
            color: #94a3b8;
            margin-bottom: 4px;
            text-transform: uppercase;
        }

        input {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #334155;
            background: #0f172a;
            color: white;
            box-sizing: border-box;
        }

        canvas {
            display: none;
        }
    </style>
</head>

<body>

    <h2>📷 AI Document Scanner</h2>

    <div id="camera-wrapper">
        <video id="video" autoplay playsinline muted></video>
    </div>

    <div class="controls">
        <div class="mode-selector">
            <button class="mode-btn active" id="btn-front" onclick="setMode('front')">FRONT ONLY</button>
            <button class="mode-btn" id="btn-both" onclick="setMode('both')">FRONT & BACK</button>
        </div>
        <button id="scan-btn" class="main-scan" onclick="captureAndProcess()">SCAN FRONT</button>
        <div id="status" class="status">Starting camera...</div>
    </div>

    <div class="main-container">
        <div id="result-box">Waiting for scan...</div>

        <div class="form-container">
            <h3>Parsed Details</h3>
            <form id="data-form">
                @csrf
                <div class="form-group"><label>Company</label><input type="text" id="form-company" name="company_name">
                </div>
                <div class="form-group"><label>Name</label><input type="text" id="form-name" name="person_name"></div>
                <div class="form-group"><label>Designation</label><input type="text" id="form-designation"
                        name="designation"></div>
                <div class="form-group"><label>Mobile</label><input type="text" id="form-mobile" name="mobile"></div>
                <div class="form-group"><label>Email</label><input type="text" id="form-email" name="email"></div>
                <div class="form-group"><label>Address</label><input type="text" id="form-address" name="address"></div>

                <input type="hidden" id="raw_ocr_text" name="raw_ocr_text">
                <button type="submit" id="save-btn"
                    style="width: 100%; margin-top: 10px; background: #10b981; color: white; border: none; padding: 12px; border-radius: 8px; cursor: pointer; font-weight: bold;">💾
                    Save Data</button>
            </form>
        </div>
    </div>

    <canvas id="canvas"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@4.1.1/dist/tesseract.min.js"></script>

    <script>
        const video = document.getElementById("video");
        const canvas = document.getElementById("canvas");
        const status = document.getElementById("status");
        const resultBox = document.getElementById("result-box");
        const scanBtn = document.getElementById("scan-btn");

        let currentMode = 'front'; // 'front' or 'both'
        let step = 1; // 1 = Front, 2 = Back
        let frontText = "";
        let backText = "";

        async function startCamera() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment", width: 1280 } });
                video.srcObject = stream;
                status.innerText = "Camera Active";
            } catch (err) { status.innerText = "Camera Error"; }
        }

        function setMode(mode) {
            currentMode = mode;
            step = 1;
            frontText = "";
            backText = "";
            document.getElementById('btn-front').classList.toggle('active', mode === 'front');
            document.getElementById('btn-both').classList.toggle('active', mode === 'both');
            scanBtn.innerText = "SCAN FRONT";
            status.innerText = `Mode: ${mode === 'front' ? 'Front Only' : 'Front & Back'}`;
        }

        async function captureAndProcess() {
            scanBtn.disabled = true;
            status.innerText = "Reading Text...";

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext("2d").drawImage(video, 0, 0);

            try {
                const { data: { text } } = await Tesseract.recognize(canvas.toDataURL("image/jpeg"), 'eng');
                const cleanText = text.trim();

                if (currentMode === 'front') {
                    // Scenario 1: Front Only
                    processResults(cleanText);
                    status.innerText = "Front Scan Done ✅";
                } else {
                    // Scenario 2: Front & Back
                    if (step === 1) {
                        frontText = cleanText;
                        resultBox.innerText = "--- FRONT SIDE ---\n" + frontText;
                        status.innerText = "Front Scanned. Now flip to BACK.";
                        scanBtn.innerText = "SCAN BACK";
                        step = 2;
                    } else {
                        backText = cleanText;
                        const combinedText = frontText + "\n\n--- BACK SIDE ---\n" + backText;
                        processResults(combinedText);
                        status.innerText = "Both Sides Scanned ✅";
                        scanBtn.innerText = "SCAN FRONT (NEW)";
                        step = 1;
                    }
                }
            } catch (err) { status.innerText = "OCR Failed"; }
            finally { scanBtn.disabled = false; }
        }

        function processResults(fullText) {
            resultBox.innerText = fullText;
            document.getElementById('raw_ocr_text').value = fullText;
            parseTextToForm(fullText);
        }

        function parseTextToForm(rawText) {
            const lines = rawText.split('\n').map(l => l.trim()).filter(l => l.length > 2);

            // Basic Regex
            const email = rawText.match(/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}/i);
            const phone = rawText.match(/(\+?\d[\d\s-]{7,15})/);

            if (email) document.getElementById("form-email").value = email[0];
            if (phone) document.getElementById("form-mobile").value = phone[0];
            if (lines.length > 0) document.getElementById("form-name").value = lines[0];

            const jobKeys = ["manager", "director", "engineer", "ceo", "developer", "founder"];
            const compKeys = ["ltd", "inc", "corp", "group", "solutions", "private"];
            const addrKeys = ["road", "street", "st.", "floor", "city", "zip", "building"];
            let addrLines = [];

            lines.forEach(line => {
                const lower = line.toLowerCase();
                if (jobKeys.some(k => lower.includes(k))) document.getElementById("form-designation").value = line;
                if (compKeys.some(k => lower.includes(k))) document.getElementById("form-company").value = line;
                if (addrKeys.some(k => lower.includes(k))) addrLines.push(line);
            });
            if (addrLines.length > 0) document.getElementById("form-address").value = addrLines.join(", ");
        }

        // AJAX POST
        document.getElementById('data-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const saveBtn = document.getElementById('save-btn');
            saveBtn.disabled = true;
            saveBtn.innerText = "Saving...";

            try {
                const response = await fetch("{{ route('save.ocr') }}", {
                    method: "POST",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "Accept": "application/json"
                    },
                    body: new FormData(e.target)
                });

                // 1. Convert the response to JSON
                const result = await response.json();

                // 2. Print it to the console log
                console.log("Response Data:", result);

                if (response.ok) {
                    status.innerText = "Saved to Database! 💾";
                    status.style.color = "#4ade80";
                } else {
                    // 3. Log errors if the server returns a 422 or 500
                    console.error("Server Error:", result);
                    status.innerText = "Save Failed. Check console.";
                }
            } catch (err) { status.innerText = "Save Error"; }
            finally { saveBtn.disabled = false; saveBtn.innerText = "💾 Save Data"; }
        });

        startCamera();
    </script>
</body>

</html>