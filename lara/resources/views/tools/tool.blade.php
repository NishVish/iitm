<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Enterprise OCR Scanner</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>
    <style>
        :root {
            --primary: #6366f1;
            --success: #10b981;
            --bg: #0f172a;
        }

        body {
            font-family: system-ui, -apple-system, sans-serif;
            background: var(--bg);
            color: #fff;
            margin: 0;
            padding: 15px;
        }

        #scanner-viewport {
            position: relative;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            border: 2px solid #334155;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
        }

        video {
            width: 100%;
            display: block;
            filter: contrast(1.1);
        }

        /* Guide Overlay */
        .guide-box {
            position: absolute;
            top: 20%;
            left: 10%;
            right: 10%;
            bottom: 20%;
            border: 2px dashed rgba(16, 185, 129, 0.5);
            border-radius: 10px;
            pointer-events: none;
        }

        .controls {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 20px;
            max-width: 600px;
            margin-inline: auto;
        }

        button {
            padding: 18px;
            border: none;
            border-radius: 14px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-scan {
            background: var(--primary);
            color: white;
            grid-column: span 2;
        }

        .btn-secondary {
            background: #334155;
            color: #94a3b8;
            font-size: 12px;
        }

        #output-panel {
            margin-top: 20px;
            padding: 20px;
            background: #1e293b;
            border-radius: 15px;
            text-align: left;
            border-left: 5px solid var(--success);
            min-height: 100px;
        }

        .status-badge {
            font-size: 11px;
            padding: 4px 8px;
            border-radius: 5px;
            background: #334155;
            margin-bottom: 10px;
            display: inline-block;
        }

        .loading-ring {
            border: 3px solid #f3f3f3;
            border-top: 3px solid var(--success);
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
            display: inline-block;
            vertical-align: middle;
            margin-right: 10px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>

    <h3 style="text-align:center; margin-bottom:10px;">IITM Document AI</h3>

    <div id="scanner-viewport">
        <video id="video" autoplay playsinline muted></video>
        <div class="guide-box"></div>
    </div>

    <div class="controls">
        <button class="btn-scan" onclick="processAll()">🚀 Start Precision Scan</button>
        <button class="btn-secondary" onclick="location.reload()">Reset Camera</button>
        <button class="btn-secondary">Settings</button>
    </div>

    <div id="output-panel">
        <div id="status"><span class="status-badge">System Ready</span></div>
        <div id="final-text" style="font-family: monospace; line-height: 1.5; color: #e2e8f0;">
            Position text inside the box for better results.
        </div>
    </div>

    <canvas id="c_orig" style="display:none;"></canvas>
    <canvas id="c_binarized" style="display:none;"></canvas>

    <script>
        const video = document.getElementById('video');
        const finalText = document.getElementById('final-text');
        const status = document.getElementById('status');

        async function init() {
            const stream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: "environment", width: { ideal: 1920 }, height: { ideal: 1080 } }
            });
            video.srcObject = stream;
        }
        init();

        async function processAll() {
            const c = document.getElementById('c_orig');
            const ctx = c.getContext('2d');
            c.width = video.videoWidth;
            c.height = video.videoHeight;
            ctx.drawImage(video, 0, 0);

            status.innerHTML = '<div class="loading-ring"></div><span class="status-badge">Synthesizing Variations...</span>';

            // Create Binary Variation
            const binarizedData = createVariation(ctx, c.width, c.height, 'binary');

            // Run Tesseract
            await runPrecisionOCR(binarizedData);
        }

        function createVariation(ctx, w, h, type) {
            const imgData = ctx.getImageData(0, 0, w, h);
            const data = imgData.data;

            for (let i = 0; i < data.length; i += 4) {
                const gray = 0.21 * data[i] + 0.72 * data[i + 1] + 0.07 * data[i + 2];
                // High Contrast Thresholding
                const v = gray < 120 ? 0 : 255;
                data[i] = data[i + 1] = data[i + 2] = v;
            }

            ctx.putImageData(imgData, 0, 0);
            return document.getElementById('c_orig').toDataURL('image/png');
        }

        async function runPrecisionOCR(imgSource) {
            try {
                const worker = await Tesseract.createWorker('eng');

                // CRITICAL: Set parameters for accuracy
                await worker.setParameters({
                    tessedit_char_whitelist: '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ.,-/: ',
                    tessedit_pageseg_mode: Tesseract.PSM.SINGLE_BLOCK,
                });

                const { data: { text, confidence } } = await worker.recognize(imgSource);

                status.innerHTML = `<span class="status-badge" style="background:var(--success)">Confidence: ${confidence}%</span>`;
                finalText.innerText = text.trim() || "No text detected. Try closer.";

                // Send to Laravel
                fetch('/save-ocr', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ text: text, conf: confidence })
                });

                await worker.terminate();
            } catch (e) {
                finalText.innerText = "Error: " + e.message;
            }
        }
    </script>
</body>

</html>