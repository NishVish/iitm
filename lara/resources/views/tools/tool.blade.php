<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $workDir = __DIR__ . DIRECTORY_SEPARATOR . 'ocr_temp' . DIRECTORY_SEPARATOR;

    if (!file_exists($workDir))
        mkdir($workDir, 0777, true);

    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data || !isset($data['image'])) {
        echo json_encode(['success' => false, 'error' => 'No image data received']);
        exit;
    }

    $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data['image']));
    $tempImage = $workDir . 'input.png';
    $outputBase = $workDir . 'output'; // Tesseract adds .txt automatically

    file_put_contents($tempImage, $imageData);

    // Use SHORT PATHS if possible, or very strict escaping
    $tesseract = '"C:\Program Files\Tesseract-OCR\tesseract.exe"';

    // Build command with 2>&1 to capture errors
    $cmd = "$tesseract \"$tempImage\" \"$outputBase\" -l eng --psm 6 2>&1";

    exec($cmd, $output, $returnVar);

    $resultFile = $outputBase . '.txt';
    if ($returnVar === 0 && file_exists($resultFile)) {
        $text = file_get_contents($resultFile);
        // Clean up files after processing
        unlink($tempImage);
        unlink($resultFile);
        echo json_encode(['success' => true, 'text' => trim($text)]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'OCR Failed',
            'debug' => [
                'return_code' => $returnVar,
                'shell_output' => $output,
                'command' => $cmd
            ]
        ]);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enterprise OCR Scanner</title>
    <style>
        body {
            font-family: system-ui;
            background: #0f172a;
            color: #fff;
            padding: 15px;
            margin: 0;
        }

        #scanner-viewport {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            border: 2px solid #334155;
            border-radius: 20px;
            overflow: hidden;
            position: relative;
        }

        video {
            width: 100%;
            display: block;
        }

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
            grid-template-columns: 1fr;
            gap: 10px;
            margin: 20px auto;
            max-width: 600px;
        }

        button {
            padding: 18px;
            border: none;
            border-radius: 14px;
            font-weight: 800;
            text-transform: uppercase;
            cursor: pointer;
            background: #6366f1;
            color: white;
        }

        #output-panel {
            margin: 10px auto;
            padding: 20px;
            background: #1e293b;
            border-radius: 15px;
            max-width: 560px;
            border-left: 5px solid #10b981;
        }

        #final-text {
            font-family: monospace;
            white-space: pre-wrap;
            word-break: break-all;
        }
    </style>
</head>

<body>
    <h3 style="text-align:center;">IITM Document AI</h3>
    <div id="scanner-viewport">
        <video id="video" autoplay playsinline muted></video>
        <div class="guide-box"></div>
    </div>
    <div class="controls">
        <button onclick="processAll()">🚀 Start Precision Scan</button>
    </div>
    <div id="output-panel">
        <div id="status" style="color: #10b981; font-weight: bold; margin-bottom: 10px;">System Ready</div>
        <div id="final-text">Results will appear here...</div>
    </div>
    <canvas id="c_orig" style="display:none;"></canvas>

    <script>
        const video = document.getElementById('video');
        const finalText = document.getElementById('final-text');
        const status = document.getElementById('status');

        async function init() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({
                    video: { facingMode: "environment", width: { ideal: 1280 } }
                });
                video.srcObject = stream;
            } catch (e) { status.innerText = "Camera error: " + e.message; }
        }
        init();

        async function processAll() {
            const c = document.getElementById('c_orig');
            const ctx = c.getContext('2d');
            c.width = video.videoWidth;
            c.height = video.videoHeight;
            ctx.drawImage(video, 0, 0);

            status.innerHTML = '⏳ Processing OCR...';
            const imageData = c.toDataURL('image/png');

            try {
                const response = await fetch('', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ image: imageData })
                });

                const result = await response.json();
                if (result.success) {
                    finalText.innerText = result.text;
                    status.innerHTML = `✅ OCR Complete`;
                } else {
                    finalText.innerText = result.error;
                    status.innerHTML = `❌ Failed`;
                    console.error("Debug CMD:", result.debug_cmd);
                }
            } catch (e) {
                finalText.innerText = "Fetch error: ".e.message;
            }
        }
    </script>
</body>

</html>