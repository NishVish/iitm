<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OCR Camera Improved</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>
    <style>
        body {
            font-family: sans-serif;
            text-align: center;
            background: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        #video-container {
            max-width: 500px;
            margin: 0 auto;
            border-radius: 10px;
            overflow: hidden;
            background: #000;
        }

        video {
            width: 100%;
            height: auto;
        }

        .controls {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        button {
            padding: 15px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }

        .btn-capture {
            background: #6366f1;
            color: white;
        }

        .btn-ocr {
            background: #10b981;
            color: white;
        }

        #output {
            margin-top: 20px;
            padding: 15px;
            background: white;
            border-radius: 10px;
            text-align: left;
            min-height: 50px;
            border: 1px solid #ddd;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        .loading {
            color: #6366f1;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <h2>📷 Camera OCR Improved</h2>

    <div id="video-container">
        <video id="video" autoplay playsinline muted></video>
    </div>

    <div class="controls">
        <button class="btn-capture" onclick="capture()">📸 Capture Image</button>
        <button class="btn-ocr" onclick="runOCR()">🔍 Extract Text</button>
    </div>

    <canvas id="canvas" style="display:none;"></canvas>

    <h3>Extracted Text:</h3>
    <div id="output">No text extracted yet...</div>

    <script>
        let imageData = null;
        const video = document.getElementById('video');
        const output = document.getElementById('output');

        // 1️⃣ Initialize Camera
        async function initCamera() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({
                    video: { facingMode: "environment", width: { ideal: 1280 }, height: { ideal: 720 } }
                });
                video.srcObject = stream;
            } catch (err) {
                console.error(err);
                alert("Camera access denied or not available.");
            }
        }
        initCamera();

        // 2️⃣ Capture & preprocess image
        function capture() {
            const canvas = document.getElementById('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Preprocess image: grayscale + contrast
            const imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            const data = imgData.data;
            for (let i = 0; i < data.length; i += 4) {
                const gray = 0.299 * data[i] + 0.587 * data[i + 1] + 0.114 * data[i + 2];
                let c = ((gray - 128) * 1.5 + 128); // contrast
                c = Math.max(0, Math.min(255, c));
                data[i] = data[i + 1] = data[i + 2] = c;
            }
            ctx.putImageData(imgData, 0, 0);

            imageData = canvas.toDataURL('image/jpeg', 0.9);
            alert("Image captured! Click 'Extract Text'.");
        }

        // 3️⃣ Run OCR with Tesseract.js
        async function runOCR() {
            if (!imageData) { alert("Capture an image first!"); return; }

            output.innerHTML = '<span class="loading">⏳ Processing... Please wait</span>';

            try {
                const result = await Tesseract.recognize(imageData, 'eng', {
                    logger: m => {
                        output.innerText = `Processing: ${Math.floor(m.progress * 100)}%`;
                    }
                });

                const text = result.data.text.trim();
                output.innerText = text || "No text found.";

                // 4️⃣ Send to Laravel backend
                await fetch('/save-ocr', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ text })
                });

            } catch (err) {
                console.error(err);
                output.innerText = "Error processing image.";
            }
        }
    </script>
</body>

</html>