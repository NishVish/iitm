<h1>Operator : {{ request()->segment(2) }}</h1>

<div class="dashboard">
    <div class="glass-panel1">
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
                    src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" alt="Preview">
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
            <button id="scannew-btn" class="main-scan" onclick="scannew()">SCAN NEW</button>

            <button type="button" onclick="clearAllData()"
                style="background: #475569; color: white; border: none; padding: 10px; font-weight: bold; border-radius: 10px; cursor: pointer; margin-top: -5px; font-size: 12px;">
                🗑️ CLEAR ALL DETAILS
            </button>

        </div>
        <textarea id="result-box" placeholder="Waiting for scan..."
            style="flex-grow: 1; background: #0f172a; padding: 15px; border-radius: 10px; border: 1px solid #334155; color: #cbd5e1; font-size: 13px; font-family: monospace; resize: none;"></textarea>
    </div>

    <div class="glass-panel">
        <h3>Parsed Details</h3>
        <form id="data-form">
            @csrf

            <div class="form-group">
                <label>Company</label>
                <input type="text" id="form-company" name="company_name">
            </div>

            <div class="form-group">
                <label>Name</label>
                <input type="text" id="form-name" name="person_name">
            </div>

            <div class="form-group">
                <label>Designation</label>
                <input type="text" id="form-designation" name="designation">
            </div>

            <div class="form-group">
                <label>Mobile</label>
                <textarea id="form-mobile" name="mobile" rows="2"></textarea>
            </div>

            <div class="form-group">
                <label>Email</label>
                <textarea id="form-email" name="email" rows="2"></textarea>
            </div>

            <!-- ✅ NEW FIELD -->
            <div class="form-group">
                <label>Website</label>
                <textarea id="form-website" name="website" rows="2"></textarea>
            </div>

            <textarea id="form-address" name="address" rows="3"
                style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid #334155; background: #0f172a; color: white; font-size: 13px; resize: vertical;"></textarea>

            <script>
                // Select the textarea
                const addressTextarea = document.getElementById("form-address");

                // 1. Clean data only when the user stops interacting with the field
                addressTextarea.addEventListener("blur", () => {
                    addressTextarea.value = addressTextarea.value
                        .replace(/\r?\n/g, ' ')    // replace line breaks
                        .replace(/\s{2,}/g, ' ')   // collapse multiple spaces
                        .trim();                   // clean edges
                });

                // 2. Also clean it immediately if they PASTE a messy address
                addressTextarea.addEventListener("paste", () => {
                    // Timeout ensures we catch the text AFTER it hits the textarea
                    setTimeout(() => {
                        addressTextarea.value = addressTextarea.value
                            .replace(/\r?\n/g, ' ')
                            .replace(/\s{2,}/g, ' ');
                    }, 10);
                });
            </script>

            <input type="hidden" name="operator" value="{{ request()->segment(2) }}">
            <input type="hidden" id="raw_ocr_text" name="raw_ocr_text">

            <button type="submit" id="save-btn"
                style="width: 100%; background: #10b981; color: white; border: none; padding: 12px; border-radius: 8px; cursor: pointer; font-weight: bold; margin-top: 5px;">
                💾 Save Data
            </button>
        </form>
        <div id="stopwatch">
            ⏱ <span id="time-display">00:00.00</span>
        </div>
        <style>
            #stopwatch {
                font-size: 18px;
                font-weight: bold;
                color: #00ff88;
                margin: 10px 0;
                font-family: monospace;
            }
        </style>

    </div>
</div>

<canvas id="canvas"></canvas>
<!-- 
<script src="https://cdn.jsdelivr.net/npm/tesseract.js@4.1.1/dist/tesseract.min.js"></script>
<script>
    let startTime;
    let stopwatchInterval;

    function startStopwatch() {
        startTime = Date.now();

        clearInterval(stopwatchInterval);

        stopwatchInterval = setInterval(() => {
            let elapsed = Date.now() - startTime;

            let minutes = Math.floor(elapsed / 60000);
            let seconds = Math.floor((elapsed % 60000) / 1000);
            let ms = Math.floor((elapsed % 1000) / 10);

            document.getElementById("time-display").innerText =
                `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}.${String(ms).padStart(2, '0')}`;
        }, 50);
    }

    function stopStopwatch() {
        clearInterval(stopwatchInterval);
    }


    let finalTime = "";

    function stopStopwatch() {
        clearInterval(stopwatchInterval);

        finalTime = document.getElementById("time-display").innerText;
    }
</script>
<script>

    function clearAllData() {
        if (confirm("Are you sure you want to clear all scanned data?")) {
            // 1. Reset the main form (Company, Name, etc.)
            document.getElementById('data-form').reset();

            // 2. Clear the OCR textarea
            document.getElementById('result-box').value = "";
            document.getElementById('raw_ocr_text').value = "";

            // 3. Clear the Preview Image (set back to blank 1x1 gif)
            document.getElementById('preview-img').src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7";

            // 4. Reset zoom/pan position
            resetZoom();

            // 5. Update Status
            document.getElementById('status').innerText = "Form Cleared 🧹";

            // 6. Reset Scan Step (if in Front/Back mode)
            step = 1;
            document.getElementById('scan-btn').innerText = "SCAN FRONT";
        }
    }

    function scannew() {

        startStopwatch();

        // Clear all captured data before scanning
        document.getElementById('data-form').reset();

        // 2. Clear the OCR textarea
        document.getElementById('result-box').value = "";
        document.getElementById('raw_ocr_text').value = "";

        // 3. Clear the Preview Image (set back to blank 1x1 gif)
        document.getElementById('preview-img').src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7";

        // 4. Reset zoom/pan position
        resetZoom();

        // 5. Update Status
        document.getElementById('status').innerText = "Form Cleared 🧹";

        // 6. Reset Scan Step (if in Front/Back mode)
        step = 1;
        document.getElementById('scan-btn').innerText = "SCAN FRONT";
        // Then start your capture process
        captureAndProcess();
    }

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

        // Update button visuals
        document.querySelectorAll('.mode-btn').forEach(btn => btn.classList.remove('active'));
        if (mode === 'front') {
            document.getElementById('btn-front').classList.add('active');
            scanBtn.innerText = "SCAN FRONT";
        } else {
            document.getElementById('btn-both').classList.add('active');
            scanBtn.innerText = "SCAN FRONT (Step 1)";
        }
        status.innerText = `Mode: ${mode === 'front' ? 'Single Side' : 'Front & Back'}`;
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

        // 1. Multiple Emails & Phones
        const emailRegex = /[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}/gi;
        const phoneRegex = /(\+?\d[\d\s-]{7,15})/g;

        const allEmails = rawText.match(emailRegex);
        if (allEmails) document.getElementById("form-email").value = [...new Set(allEmails)].join(', ');

        const allPhones = rawText.match(phoneRegex);
        if (allPhones) {
            const validPhones = allPhones.filter(p => p.replace(/\D/g, '').length >= 10);
            document.getElementById("form-mobile").value = [...new Set(validPhones)].join(', ');
        }

        // Website Regex
        const websiteRegex = /\b((https?:\/\/)?(www\.)?[a-z0-9-]+\.(com|in|org|net|co|io)[^\s]*)\b/gi;

        // Strict website regex (only valid TLDs)
        // const websiteRegex = /\b((https?:\/\/)?(www\.)?[a-z0-9-]+\.(com|in|org|net|co|io))\b/gi;

        let allWebsites = rawText.match(websiteRegex);

        if (allWebsites) {
            // Normalize + clean
            const cleanWebsites = [...new Set(allWebsites.map(w => {
                w = w.toLowerCase().trim();

                // Fix common OCR mistakes
                w = w.replace('cofn', 'com')
                    .replace('ecom', 'com')
                    .replace('c0m', 'com');

                if (!w.startsWith('http')) return 'https://' + w;
                return w;
            }))];

            document.getElementById("form-website").value = cleanWebsites.join(', ');
        }



        // 3. Keywords
        const jobKeys = ["manager", "director", "engineer", "ceo", "developer", "founder", "sales", "executive"];
        const compKeys = ["ltd", "inc", "corp", "group", "solutions", "private", "limited", "builders", "developers pvt"];
        const addrKeys = ["road", "street", "st.", "floor", "city", "zip", "building", "airport", "kolkata"];
        const invalidNameKeys = [
            "hotel", "resort", "restaurant", "cafe", "bar", "suite",
            "solutions", "technologies", "group", "company", "services",
            "pvt", "ltd", "inc", "corp", "builders", "developers"
        ];

        // Name Cleanup
        if (lines.length > 0) {
            let possibleName = lines[0].length < 3 && lines[1] ? lines[1] : lines[0];

            // Clean OCR garbage
            possibleName = possibleName
                .replace(/(\+?\d[\d\s\-().]{7,20})/g, '')
                .replace(/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}/gi, '')
                .replace(/\b((https?:\/\/)?(www\.)?[a-z0-9-]+\.(com|in|org|net|co|io))\b/gi, '')
                .replace(/^[^a-zA-Z]+/, '')
                .replace(/[^a-zA-Z\s'-]+$/g, '')
                .replace(/[\s\-_]{2,}/g, ' ');

            let parts = possibleName.split(/\s+/).filter(p => p.length > 1);
            possibleName = parts.join(' ');

            const lowerName = possibleName.toLowerCase();

            // --- NEW: Business Keywords Filter ---
            const businessKeys = [
                'holidays', 'travels', 'pvt', 'ltd', 'limited', 'solutions', 'services',
                'tours', 'enterprise', 'global', 'group', 'associates', 'agency', 'logistics'
            ];

            let isInvalidName = false;

            // Check against business keywords
            if (businessKeys.some(k => lowerName.includes(k))) isInvalidName = true;

            // Existing constraints
            const emailValue = (document.getElementById("form-email").value || "").toLowerCase();
            const phoneValue = (document.getElementById("form-mobile").value || "").toLowerCase();

            if (emailValue && lowerName.includes(emailValue)) isInvalidName = true;
            if (phoneValue && lowerName.replace(/\D/g, '').includes(phoneValue.replace(/\D/g, ''))) isInvalidName = true;
            if (jobKeys.some(k => lowerName.includes(k))) isInvalidName = true;
            if (invalidNameKeys.some(k => lowerName.includes(k))) isInvalidName = true;
            if (/\.(com|in|org|net|co|io)/i.test(lowerName)) isInvalidName = true;
            if (/\d/.test(possibleName)) isInvalidName = true;

            // --- FINAL ACTION ---
            if (!isInvalidName) {
                possibleName = possibleName.split(' ').map(w => w.charAt(0).toUpperCase() + w.slice(1).toLowerCase()).join(' ');
                document.getElementById("form-name").value = possibleName;
            } else {
                // If it's a holiday company, the name field should probably be cleared 
                // or we should look for the name in other lines.
                document.getElementById("form-name").value = "";
            }
        }
        let addrLines = [];
        let detectedCompany = "";
        let detectedDesignation = "";

        lines.forEach(line => {
            let cleanLine = line.trim();

            // --- FIX COMMON OCR MISREADS BEFORE LOWERCASE ---
            cleanLine = cleanLine
                .replace(/\bLid\b\.?/gi, 'Ltd')
                .replace(/\bLlt\b\.?/gi, 'Ltd')
                .replace(/\bPvt\b\.?/gi, 'Pvt')
                .replace(/“|”/g, '') // remove fancy quotes
                .replace(/¥|¥/g, '') // remove random symbols
                .replace(/\s{2,}/g, ' '); // collapse spaces

            const lower = cleanLine.toLowerCase();

            // Skip trivial / email / web / too short
            if (
                lower.includes('@') ||
                /\b(www\.|https?:\/\/|\.com|\.in|\.org|\.net)\b/i.test(lower) ||
                lower.length < 3
            ) return;

            const isCompany = compKeys.some(k => lower.includes(k));
            const isJob = jobKeys.some(k => lower.includes(k));

            if (isCompany) {
                // CLEAN COMPANY
                let detected = cleanLine.replace(/[^a-zA-Z0-9\s&.,-]/g, '').trim();
                detectedCompany = detected;
            } else if (isJob) {
                let cleanDesignation = cleanLine;
                cleanDesignation = cleanDesignation.replace(/^[^a-zA-Z]+/, '').trim();
                cleanDesignation = cleanDesignation.replace(/[\d:|+–-]+$/g, '').trim();
                cleanDesignation = cleanDesignation.replace(/[\s|]{2,}/g, ' ');
                cleanDesignation = cleanDesignation
                    .split(' ')
                    .map(w => w.charAt(0).toUpperCase() + w.slice(1).toLowerCase())
                    .join(' ');
                detectedDesignation = cleanDesignation;
            }
        });
        // Final Constraint: Ensure Company and Designation are not identical
        if (detectedCompany === detectedDesignation) {
            detectedDesignation = ""; // Clear it so user can manually fix or we pick the next best
        }

        document.getElementById("form-company").value = detectedCompany;
        document.getElementById("form-designation").value = detectedDesignation;
        document.getElementById("form-address").value = addrLines.join(", ");
    }
    document.getElementById('data-form').addEventListener('submit', async (e) => {

        stopStopwatch();

        e.preventDefault();

        const saveBtn = document.getElementById('save-btn');
        const status = document.getElementById('status'); // Ensure you have an id="status" element

        // 1. Safety Check: CSRF Token
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            console.error("CSRF token meta tag not found!");
            if (status) status.innerText = "Error: Security Token Missing ❌";
            return;
        }

        // 2. UI State: Disable buttonad
        saveBtn.disabled = true;
        const originalBtnText = saveBtn.innerText;
        const originalBg = saveBtn.style.background;
        saveBtn.innerText = "Saving...";

        try {
            const response = await fetch("{{ route('ocr.save') }}", {
                method: "POST",
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": csrfToken.getAttribute("content")
                },
                body: new FormData(e.target)
            });

            // 3. Handle response safely
            let result;
            const contentType = response.headers.get("content-type");

            if (contentType && contentType.includes("application/json")) {
                result = await response.json();
                console.log("Server Response JSON:", result);
            } else {
                // If server crashed and returned HTML, this avoids the "Network Error"
                const rawText = await response.text();
                console.error("Server returned non-JSON response:", rawText);
                throw new Error("Invalid Server Response");
            }

            if (response.ok) {
                if (status) status.innerText = "Saved Successfully! 💾";

                // Visual Feedback
                saveBtn.style.background = "#059669";
                saveBtn.innerText = "SAVED! ✅";

                setTimeout(() => {
                    saveBtn.style.background = originalBg;
                    saveBtn.innerText = originalBtnText;
                    saveBtn.disabled = false;
                }, 2000);
            } else {
                if (status) status.innerText = "Error: " + (result.message || "Server Error ❌");
                saveBtn.disabled = false;
                saveBtn.innerText = originalBtnText;
            }

        } catch (err) {
            // This catches actual network failures OR parsing failures
            console.error("Fetch/Network Error:", err);
            if (status) status.innerText = "Network Error ❌";
            saveBtn.disabled = false;
            saveBtn.innerText = originalBtnText;
        }
    });

    startCamera();

    // Sync manual edits in the OCR box to the hidden form field
    resultBox.addEventListener('input', (e) => {
        document.getElementById('raw_ocr_text').value = e.target.value;
        // Optional: Re-parse the form fields as you type
        parseTextToForm(e.target.value);
    });
</script> -->
<!-- Replace your current Tesseract/JavaScript section with this -->

<script src="https://cdn.jsdelivr.net/npm/tesseract.js@4.1.1/dist/tesseract.min.js"></script>

<script>
    let startTime;
    let stopwatchInterval;
    let finalTime = "";

    function startStopwatch() {
        startTime = Date.now();

        clearInterval(stopwatchInterval);

        stopwatchInterval = setInterval(() => {

            const elapsed = Date.now() - startTime;

            const minutes = Math.floor(elapsed / 60000);
            const seconds = Math.floor((elapsed % 60000) / 1000);
            const ms = Math.floor((elapsed % 1000) / 10);

            document.getElementById("time-display").innerText =
                `${String(minutes).padStart(2, '0')}:` +
                `${String(seconds).padStart(2, '0')}.` +
                `${String(ms).padStart(2, '0')}`;

        }, 50);
    }

    function stopStopwatch() {
        clearInterval(stopwatchInterval);

        finalTime =
            document.getElementById("time-display").innerText;
    }

    function clearAllData() {

        if (!confirm("Are you sure you want to clear all scanned data?")) {
            return;
        }

        document.getElementById('data-form').reset();

        document.getElementById('result-box').value = "";

        document.getElementById('raw_ocr_text').value = "";

        document.getElementById('preview-img').src =
            "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7";

        resetZoom();

        document.getElementById('status').innerText =
            "Form Cleared 🧹";

        step = 1;
        frontText = "";

        document.getElementById('scan-btn').innerText =
            currentMode === 'front'
                ? "SCAN FRONT"
                : "SCAN FRONT (Step 1)";
    }

    function scannew() {

        startStopwatch();

        document.getElementById('data-form').reset();

        document.getElementById('result-box').value = "";

        document.getElementById('raw_ocr_text').value = "";

        document.getElementById('preview-img').src =
            "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7";

        resetZoom();

        document.getElementById('status').innerText =
            "Starting New Scan...";

        step = 1;
        frontText = "";

        document.getElementById('scan-btn').innerText =
            currentMode === 'front'
                ? "SCAN FRONT"
                : "SCAN FRONT (Step 1)";

        captureAndProcess();
    }


    const video = document.getElementById("video");
    const canvas = document.getElementById("canvas");
    const status = document.getElementById("status");
    const resultBox = document.getElementById("result-box");
    const scanBtn = document.getElementById("scan-btn");

    const previewContainer =
        document.getElementById("preview-container");

    const previewImg =
        document.getElementById("preview-img");


    let currentMode = "front";
    let step = 1;
    let frontText = "";


    let scale = 1;
    let pointX = 0;
    let pointY = 0;

    let start = {
        x: 0,
        y: 0
    };

    let isDragging = false;


    async function startCamera() {

        try {

            const stream =
                await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: "environment",
                        width: {
                            ideal: 1280
                        },
                        height: {
                            ideal: 720
                        }
                    }
                });

            video.srcObject = stream;

            status.innerText =
                "Camera Active ✅";

            status.style.color =
                "#10b981";

        } catch (err) {

            console.error(err);

            status.innerText =
                "Camera Error ❌";

            status.style.color =
                "#ef4444";
        }
    }


    function setMode(mode) {

        currentMode = mode;
        step = 1;
        frontText = "";

        document
            .querySelectorAll('.mode-btn')
            .forEach(btn => {
                btn.classList.remove('active');
            });

        if (mode === 'front') {

            document
                .getElementById('btn-front')
                .classList.add('active');

            scanBtn.innerText =
                "SCAN FRONT";

        } else {

            document
                .getElementById('btn-both')
                .classList.add('active');

            scanBtn.innerText =
                "SCAN FRONT (Step 1)";
        }

        status.innerText =
            mode === 'front'
                ? "Mode: Single Side"
                : "Mode: Front & Back";
    }


    async function captureAndProcess() {

        scanBtn.disabled = true;

        status.innerText =
            "Capturing image...";

        status.style.color =
            "#fbbf24";


        if (!video.videoWidth || !video.videoHeight) {

            status.innerText =
                "Camera not ready ❌";

            scanBtn.disabled = false;

            return;
        }


        canvas.width =
            video.videoWidth;

        canvas.height =
            video.videoHeight;


        const ctx =
            canvas.getContext("2d");

        ctx.drawImage(
            video,
            0,
            0,
            canvas.width,
            canvas.height
        );


        const imageData =
            canvas.toDataURL(
                "image/jpeg",
                0.95
            );


        previewImg.src =
            imageData;

        resetZoom();


        try {

            status.innerText =
                "Running OCR...";


            const result =
                await Tesseract.recognize(
                    imageData,
                    'eng'
                );


            const cleanText =
                result.data.text.trim();


            if (!cleanText) {

                status.innerText =
                    "No text detected ❌";

                return;
            }


            if (currentMode === 'front') {

                processResults(cleanText);

                status.innerText =
                    "OCR Complete → Ollama Processing... 🤖";

            } else {

                if (step === 1) {

                    frontText =
                        cleanText;

                    resultBox.value =
                        "--- FRONT SIDE ---\n" +
                        frontText;

                    document
                        .getElementById('raw_ocr_text')
                        .value = frontText;

                    status.innerText =
                        "Flip to Back and Scan";

                    scanBtn.innerText =
                        "SCAN BACK";

                    step = 2;

                } else {

                    const combinedText =
                        frontText +
                        "\n\n--- BACK SIDE ---\n" +
                        cleanText;

                    processResults(combinedText);

                    status.innerText =
                        "Both Sides OCR Complete → Ollama Processing... 🤖";

                    scanBtn.innerText =
                        "SCAN FRONT";

                    step = 1;
                }
            }

        } catch (err) {

            console.error(
                "OCR Error:",
                err
            );

            status.innerText =
                "OCR Failed ❌";

            status.style.color =
                "#ef4444";

        } finally {

            scanBtn.disabled = false;
        }
    }


    function processResults(fullText) {

        resultBox.value =
            fullText;

        document
            .getElementById('raw_ocr_text')
            .value = fullText;

        parseTextToForm(fullText);
    }


    async function parseTextToForm(rawText) {

        if (!rawText || rawText.trim().length < 3) {

            status.innerText =
                "No OCR text detected ❌";

            return;
        }


        status.innerText =
            "Sending OCR to Ollama... 🤖";

        status.style.color =
            "#fbbf24";


        try {

            const csrf =
                document.querySelector(
                    'meta[name="csrf-token"]'
                );


            if (!csrf) {

                throw new Error(
                    "CSRF token not found"
                );
            }


            const response =
                await fetch(
                    "{{ route('ocr.parse-ollama') }}",
                    {
                        method: "POST",

                        headers: {
                            "Content-Type":
                                "application/json",

                            "Accept":
                                "application/json",

                            "X-Requested-With":
                                "XMLHttpRequest",

                            "X-CSRF-TOKEN":
                                csrf.getAttribute(
                                    "content"
                                )
                        },

                        body: JSON.stringify({
                            text: rawText
                        })
                    }
                );


            const result =
                await response.json();


            console.log(
                "Ollama Response:",
                result
            );


            if (!response.ok) {

                throw new Error(
                    result.message ||
                    "Ollama request failed"
                );
            }


            if (!result.success) {

                throw new Error(
                    result.message ||
                    "Ollama parsing failed"
                );
            }


            const d =
                result.data || {};


            document.getElementById(
                "form-company"
            ).value =
                d.company_name || "";


            document.getElementById(
                "form-name"
            ).value =
                d.person_name || "";


            document.getElementById(
                "form-designation"
            ).value =
                d.designation || "";


            document.getElementById(
                "form-mobile"
            ).value =
                d.mobile || "";


            document.getElementById(
                "form-email"
            ).value =
                d.email || "";


            document.getElementById(
                "form-website"
            ).value =
                d.website || "";


            document.getElementById(
                "form-address"
            ).value =
                d.address || "";


            document.getElementById(
                "raw_ocr_text"
            ).value =
                rawText;


            status.innerText =
                "Ollama Parsing Complete ✅";

            status.style.color =
                "#10b981";


        } catch (error) {

            console.error(
                "Ollama Error:",
                error
            );

            status.innerText =
                "Ollama Parsing Failed ❌";

            status.style.color =
                "#ef4444";

            alert(
                "Ollama Error:\n" +
                error.message
            );
        }
    }


    function setTransform() {

        previewImg.style.transform =
            `translate(${pointX}px, ${pointY}px) scale(${scale})`;
    }


    previewContainer.onwheel =
        function (e) {

            e.preventDefault();

            const xs =
                (e.clientX - pointX) / scale;

            const ys =
                (e.clientY - pointY) / scale;


            const delta =
                e.wheelDelta
                    ? e.wheelDelta
                    : -e.deltaY;


            if (delta > 0) {
                scale *= 1.2;
            } else {
                scale /= 1.2;
            }


            if (scale < 0.5) {
                scale = 0.5;
            }

            if (scale > 8) {
                scale = 8;
            }


            pointX =
                e.clientX -
                xs * scale;

            pointY =
                e.clientY -
                ys * scale;


            setTransform();
        };


    const startDrag =
        (e) => {

            const clientX =
                e.touches
                    ? e.touches[0].clientX
                    : e.clientX;

            const clientY =
                e.touches
                    ? e.touches[0].clientY
                    : e.clientY;


            start = {
                x: clientX - pointX,
                y: clientY - pointY
            };


            isDragging = true;

            previewContainer.style.cursor =
                "grabbing";
        };


    const moveDrag =
        (e) => {

            if (!isDragging) {
                return;
            }

            e.preventDefault();


            const clientX =
                e.touches
                    ? e.touches[0].clientX
                    : e.clientX;

            const clientY =
                e.touches
                    ? e.touches[0].clientY
                    : e.clientY;


            pointX =
                clientX - start.x;

            pointY =
                clientY - start.y;


            setTransform();
        };


    const stopDrag =
        () => {

            isDragging = false;

            previewContainer.style.cursor =
                "grab";
        };


    previewContainer.addEventListener(
        'mousedown',
        startDrag
    );

    previewContainer.addEventListener(
        'touchstart',
        startDrag,
        { passive: true }
    );

    window.addEventListener(
        'mousemove',
        moveDrag
    );

    window.addEventListener(
        'touchmove',
        moveDrag,
        { passive: false }
    );

    window.addEventListener(
        'mouseup',
        stopDrag
    );

    window.addEventListener(
        'touchend',
        stopDrag
    );


    function resetZoom() {

        scale = 1;
        pointX = 0;
        pointY = 0;

        setTransform();
    }


    document
        .getElementById('data-form')
        .addEventListener(
            'submit',
            async function (e) {

                stopStopwatch();

                e.preventDefault();


                const saveBtn =
                    document.getElementById(
                        'save-btn'
                    );


                const csrf =
                    document.querySelector(
                        'meta[name="csrf-token"]'
                    );


                if (!csrf) {

                    status.innerText =
                        "Security Token Missing ❌";

                    return;
                }


                saveBtn.disabled = true;

                const originalText =
                    saveBtn.innerText;

                const originalBg =
                    saveBtn.style.background;


                saveBtn.innerText =
                    "Saving...";


                try {

                    const response =
                        await fetch(
                            "{{ route('ocr.save') }}",
                            {
                                method: "POST",

                                headers: {
                                    "X-Requested-With":
                                        "XMLHttpRequest",

                                    "Accept":
                                        "application/json",

                                    "X-CSRF-TOKEN":
                                        csrf.getAttribute(
                                            "content"
                                        )
                                },

                                body:
                                    new FormData(
                                        e.target
                                    )
                            }
                        );


                    const contentType =
                        response.headers.get(
                            "content-type"
                        );


                    let result;


                    if (
                        contentType &&
                        contentType.includes(
                            "application/json"
                        )
                    ) {

                        result =
                            await response.json();

                    } else {

                        const raw =
                            await response.text();

                        console.error(
                            raw
                        );

                        throw new Error(
                            "Invalid server response"
                        );
                    }


                    if (!response.ok) {

                        throw new Error(
                            result.message ||
                            "Server Error"
                        );
                    }


                    status.innerText =
                        "Saved Successfully! 💾";

                    status.style.color =
                        "#10b981";


                    saveBtn.style.background =
                        "#059669";

                    saveBtn.innerText =
                        "SAVED! ✅";


                    setTimeout(
                        () => {

                            saveBtn.style.background =
                                originalBg;

                            saveBtn.innerText =
                                originalText;

                            saveBtn.disabled =
                                false;

                        },
                        2000
                    );


                } catch (err) {

                    console.error(
                        "Save Error:",
                        err
                    );

                    status.innerText =
                        "Save Failed ❌";

                    status.style.color =
                        "#ef4444";

                    saveBtn.disabled =
                        false;

                    saveBtn.innerText =
                        originalText;
                }
            }
        );


    resultBox.addEventListener(
        'input',
        function (e) {

            document
                .getElementById(
                    'raw_ocr_text'
                )
                .value =
                e.target.value;
        }
    );


    const addressTextarea =
        document.getElementById(
            "form-address"
        );


    addressTextarea.addEventListener(
        "blur",
        () => {

            addressTextarea.value =
                addressTextarea.value
                    .replace(/\r?\n/g, ' ')
                    .replace(/\s{2,}/g, ' ')
                    .trim();
        }
    );


    addressTextarea.addEventListener(
        "paste",
        () => {

            setTimeout(
                () => {

                    addressTextarea.value =
                        addressTextarea.value
                            .replace(/\r?\n/g, ' ')
                            .replace(/\s{2,}/g, ' ')
                            .trim();

                },
                10
            );
        }
    );


    startCamera();

</script>

</body>

</html>