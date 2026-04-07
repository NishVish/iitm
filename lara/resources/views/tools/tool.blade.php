<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>OCR Camera</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>

    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            text-align: center;
            background: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        #video-container {
            position: relative;
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            border-radius: 15px;
            overflow: hidden;
            background: #000;
            line-height: 0;
        }

        video {
            width: 100%;
            height: auto;
            /* Mirroring is usually for front cam, but back cam shouldn't be mirrored */
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
            transition: opacity 0.2s;
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

    <h2>📷 Camera OCR</h2>

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

        // Start camera with Back Camera preference
        async function initCamera() {
            const constraints = {
                video: {
                    // 'environment' forces the back camera on mobile
                    facingMode: { ideal: "environment" },
                    width: { ideal: 1280 },
                    height: { ideal: 720 }
                }
            };

            try {
                const stream = await navigator.mediaDevices.getUserMedia(constraints);
                video.srcObject = stream;
            } catch (err) {
                console.error(err);
                alert("Camera access denied or not available. Please ensure you are using HTTPS.");
            }
        }

        function capture() {
            const canvas = document.getElementById('canvas');
            // Set canvas size to match the actual video stream resolution
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            imageData = canvas.toDataURL('image/jpeg', 0.8); // Use JPEG for better mobile performance
            alert("Image captured! Now click 'Extract Text'.");
        }

        async function runOCR() {
            if (!imageData) {
                alert("Please capture an image first!");
                return;
            }

            output.innerHTML = '<span class="loading">⏳ Processing... (this may take a moment)</span>';

            try {
                const result = await Tesseract.recognize(
                    imageData,
                    'eng',
                    { logger: m => console.log(m) }
                );

                const text = result.data.text;
                output.innerText = text || "No text found.";

                // Send to Laravel
                fetch('/save-ocr', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ text: text })
                });

            } catch (err) {
                console.error(err);
                output.innerText = "Error processing image.";
            }
        }

        // Initialize on load
        initCamera();
    </script>
</body>

</html>