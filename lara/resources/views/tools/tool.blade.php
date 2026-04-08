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
            margin: 0;
            padding: 20px;
            overflow-x: hidden;
        }

        h1 {
            text-align: center;
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: #6366f1;
        }

        .dashboard {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
            align-items: start;
            max-width: 1600px;
            margin: 0 auto;
        }

        @media (max-width: 1100px) {
            .dashboard {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .dashboard {
                grid-template-columns: 1fr;
            }
        }

        .glass-panel {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 15px;
            padding: 20px;
            height: 750px;
            display: flex;
            flex-direction: column;
        }

        /* LIVE CAMERA SECTION */
        #camera-wrapper {
            width: 100%;
            height: 250px;
            border-radius: 10px;
            overflow: hidden;
            background: #000;
            border: 2px solid #6366f1;
            margin-bottom: 15px;
        }

        video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* PAN-ABLE PREVIEW AT BOTTOM */
        #preview-section {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            border: 1px dashed #475569;
            border-radius: 10px;
            background: #000;
            overflow: hidden;
            position: relative;
        }

        #preview-container {
            width: 100%;
            height: 100%;
            cursor: grab;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #preview-img {
            max-width: 100%;
            transform-origin: center;
            transition: transform 0.1s ease-out;
            pointer-events: none;
            /* Let the container handle dragging */
        }

        .preview-controls {
            position: absolute;
            top: 5px;
            right: 5px;
            z-index: 10;
        }

        .preview-btn {
            background: rgba(99, 102, 241, 0.9);
            border: none;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 10px;
            font-weight: bold;
        }

        /* UI Elements */
        .controls {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 15px;
        }

        .mode-selector {
            background: #0f172a;
            padding: 5px;
            border-radius: 50px;
            display: flex;
            border: 1px solid #334155;
        }

        .mode-btn {
            background: transparent;
            border: none;
            color: #94a3b8;
            padding: 10px 20px;
            border-radius: 20px;
            cursor: pointer;
            flex: 1;
            font-weight: bold;
        }

        .mode-btn.active {
            background: #6366f1;
            color: white;
        }

        .main-scan {
            background: #6366f1;
            color: white;
            border: none;
            padding: 15px;
            font-weight: bold;
            border-radius: 10px;
            cursor: pointer;
        }

        #result-box {
            flex-grow: 1;
            background: #0f172a;
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #334155;
            white-space: pre-wrap;
            font-size: 13px;
            color: #cbd5e1;
            overflow-y: auto;
        }

        .form-group {
            margin-bottom: 10px;
        }

        label {
            display: block;
            font-size: 11px;
            color: #94a3b8;
            margin-bottom: 3px;
            text-transform: uppercase;
        }

        input,
        textarea {
            width: 100%;
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #334155;
            background: #0f172a;
            color: white;
            box-sizing: border-box;
            font-size: 13px;
        }

        .status {
            font-size: 14px;
            color: #94a3b8;
            margin: 10px 0;
            text-align: center;
        }

        canvas {
            display: none;
        }
    </style>
</head>

<body>

    <h1>Operator : {{ request()->segment(2) }}</h1>

    <div class="dashboard">
        <div class="glass-panel">
            <h3>Live Feed</h3>
            <div id="camera-wrapper">
                <video id="video" autoplay playsinline muted></video>
            </div>

            <h3>Captured Preview</h3>
            <div id="preview-section">
                <div class="preview-controls">
                    <button class="preview-btn" onclick="resetZoom()">RESET</button>
                </div>
                <div id="preview-container">
                    <img id="preview-img"
                        src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
                        alt="Preview">
                </div>
            </div>

            <div id="status" class="status">Initializing...</div>
            <p style="font-size: 10px; color: #64748b; text-align: center;">
                Zoom: Mouse Wheel | Pan: Click & Drag
            </p>
        </div>

        <div class="glass-panel">
            <h3>OCR Processing</h3>
            <div class="controls">
                <div class="mode-selector">
                    <button class="mode-btn active" id="btn-front" onclick="setMode('front')">FRONT</button>
                    <button class="mode-btn" id="btn-both" onclick="setMode('both')">FRONT & BACK</button>
                </div>
                <button id="scan-btn" class="main-scan" onclick="captureAndProcess()">SCAN FRONT</button>
            </div>
            <textarea id="result-box" placeholder="Waiting for scan..."
                style="flex-grow: 1; background: #0f172a; padding: 15px; border-radius: 10px; border: 1px solid #334155; color: #cbd5e1; font-size: 13px; font-family: monospace; resize: none;"></textarea>
        </div>

        <div class="glass-panel">
            <h3>Parsed Details</h3>
            <form id="data-form">
                @csrf
                <div class="form-group"><label>Company</label><input type="text" id="form-company" name="company_name">
                </div>
                <div class="form-group"><label>Name</label><input type="text" id="form-name" name="person_name"></div>
                <div class="form-group"><label>Designation</label><input type="text" id="form-designation"
                        name="designation"></div>
                <div class="form-group"><label>Mobile</label><textarea id="form-mobile" name="mobile"
                        rows="2"></textarea></div>
                <div class="form-group"><label>Email</label><textarea id="form-email" name="email" rows="2"></textarea>
                </div>
                <div class="form-group"><label>Address</label><input type="text" id="form-address" name="address"></div>

                <input type="hidden" name="operator" value="{{ request()->segment(2) }}">
                <input type="hidden" id="raw_ocr_text" name="raw_ocr_text">
                <button type="submit" id="save-btn"
                    style="width: 100%; background: #10b981; color: white; border: none; padding: 12px; border-radius: 8px; cursor: pointer; font-weight: bold; margin-top: 5px;">💾
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

        // Preview Elements
        const previewContainer = document.getElementById("preview-container");
        const previewImg = document.getElementById("preview-img");

        let currentMode = 'front';
        let step = 1;
        let frontText = "";

        // Zoom/Pan State
        let scale = 1;
        let pointX = 0;
        let pointY = 0;
        let start = { x: 0, y: 0 };
        let isDragging = false;

        async function startCamera() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment", width: 1280 } });
                video.srcObject = stream;
                status.innerText = "Camera Active ✅";
            } catch (err) { status.innerText = "Camera Error ❌"; }
        }

        function setMode(mode) {
            currentMode = mode;
            step = 1;
            scanBtn.innerText = "SCAN FRONT";
        }

        async function captureAndProcess() {
            scanBtn.disabled = true;
            status.innerText = "Processing OCR...";

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const ctx = canvas.getContext("2d");
            ctx.drawImage(video, 0, 0);

            const imageData = canvas.toDataURL("image/jpeg");

            // Set image and reset zoom
            previewImg.src = imageData;
            resetZoom();

            try {
                const { data: { text } } = await Tesseract.recognize(imageData, 'eng');
                const cleanText = text.trim();

                if (currentMode === 'front') {
                    processResults(cleanText);
                    status.innerText = "Scan Complete ✅";
                } else {
                    if (step === 1) {
                        frontText = cleanText;
                        resultBox.value = "--- FRONT SIDE ---\n" + frontText; status.innerText = "Flip to Back and Scan";
                        scanBtn.innerText = "SCAN BACK";
                        step = 2;
                    } else {
                        processResults(frontText + "\n\n--- BACK SIDE ---\n" + cleanText);
                        status.innerText = "Both Sides Scanned ✅";
                        scanBtn.innerText = "SCAN FRONT";
                        step = 1;
                    }
                }
            } catch (err) { status.innerText = "OCR Failed ❌"; }
            finally { scanBtn.disabled = false; }
        }

        function processResults(fullText) {
            resultBox.value = fullText; // Use .value instead of .innerText            document.getElementById('raw_ocr_text').value = fullText;
            parseTextToForm(fullText);
        }

        // --- ZOOM & PAN LOGIC ---
        function setTransform() {
            previewImg.style.transform = `translate(${pointX}px, ${pointY}px) scale(${scale})`;
        }

        previewContainer.onwheel = function (e) {
            e.preventDefault();
            const xs = (e.clientX - pointX) / scale;
            const ys = (e.clientY - pointY) / scale;
            const delta = (e.wheelDelta ? e.wheelDelta : -e.deltaY);
            (delta > 0) ? (scale *= 1.2) : (scale /= 1.2);
            if (scale < 0.5) scale = 0.5;
            pointX = e.clientX - xs * scale;
            pointY = e.clientY - ys * scale;
            setTransform();
        }

        const startDrag = (e) => {
            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
            const clientY = e.touches ? e.touches[0].clientY : e.clientY;
            start = { x: clientX - pointX, y: clientY - pointY };
            isDragging = true;
            previewContainer.style.cursor = "grabbing";
        };

        const moveDrag = (e) => {
            if (!isDragging) return;
            e.preventDefault();
            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
            const clientY = e.touches ? e.touches[0].clientY : e.clientY;
            pointX = (clientX - start.x);
            pointY = (clientY - start.y);
            setTransform();
        };

        const stopDrag = () => {
            isDragging = false;
            previewContainer.style.cursor = "grab";
        };

        previewContainer.addEventListener('mousedown', startDrag);
        previewContainer.addEventListener('touchstart', startDrag);
        window.addEventListener('mousemove', moveDrag);
        window.addEventListener('touchmove', moveDrag, { passive: false });
        window.addEventListener('mouseup', stopDrag);
        window.addEventListener('touchend', stopDrag);

        function resetZoom() {
            scale = 1;
            pointX = 0;
            pointY = 0;
            setTransform();
        }

        // --- PARSING LOGIC (Inherited) ---
        function parseTextToForm(rawText) {
            const lines = rawText.split('\n').map(l => l.trim()).filter(l => l.length > 2);
            const emailRegex = /[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}/gi;
            const phoneRegex = /(\+?\d[\d\s-]{7,15})/g;

            const allEmails = rawText.match(emailRegex);
            if (allEmails) document.getElementById("form-email").value = [...new Set(allEmails)].join(', ');

            const allPhones = rawText.match(phoneRegex);
            if (allPhones) document.getElementById("form-mobile").value = [...new Set(allPhones)].join(', ');

            if (lines.length > 0) document.getElementById("form-name").value = lines[0];

            const jobKeys = ["manager", "director", "engineer", "ceo", "developer", "founder"];
            const compKeys = ["ltd", "inc", "corp", "group", "solutions", "private", "limited"];
            const addrKeys = ["road", "street", "st.", "floor", "city", "zip", "building", "phase"];
            let addrLines = [];

            lines.forEach(line => {
                const lower = line.toLowerCase();
                if (jobKeys.some(k => lower.includes(k))) document.getElementById("form-designation").value = line;
                if (compKeys.some(k => lower.includes(k))) document.getElementById("form-company").value = line;
                if (addrKeys.some(k => lower.includes(k))) addrLines.push(line);
            });
            if (addrLines.length > 0) document.getElementById("form-address").value = addrLines.join(", ");
        }

        document.getElementById('data-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const saveBtn = document.getElementById('save-btn');
            saveBtn.disabled = true;
            saveBtn.innerText = "Saving...";
            try {
                const response = await fetch("{{ route('save.ocr') }}", {
                    method: "POST",
                    headers: { "X-Requested-With": "XMLHttpRequest", "Accept": "application/json" },
                    body: new FormData(e.target)
                });
                if (response.ok) {
                    status.innerText = "Saved Successfully! 💾";
                    e.target.reset();
                    previewImg.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7";
                    resetZoom();
                }
            } catch (err) { status.innerText = "Network Error"; }
            finally { saveBtn.disabled = false; saveBtn.innerText = "💾 Save Data"; }
        });

        startCamera();
    </script>
</body>

</html>