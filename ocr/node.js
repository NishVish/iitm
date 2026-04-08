const express = require("express");
const bodyParser = require("body-parser");
const Tesseract = require("tesseract.js");
const cors = require("cors");

const app = express();
const PORT = 5000;

app.use(cors());
app.use(bodyParser.json({ limit: "10mb" })); // increase limit if images are large

// Serve static HTML
app.get("/", (req, res) => {
    res.send(`
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AI Document Scanner</title>
<style>
body { font-family: sans-serif; background: #0f172a; color: white; text-align:center; margin:0; padding:20px; }
#camera-wrapper { position: relative; width:100%; max-width:500px; margin:auto; border:3px solid #6366f1; border-radius:15px; overflow:hidden; }
video { width:100%; display:block; background:#000; }
.controls { margin:20px 0; }
button { background:#6366f1; color:white; border:none; padding:15px 40px; font-size:18px; font-weight:bold; border-radius:10px; cursor:pointer; }
button:active { transform: scale(0.95); background:#4f46e5; }
#result-box { background:#1e293b; padding:15px; border-radius:10px; margin-top:20px; min-height:100px; text-align:left; border:1px solid #334155; white-space:pre-wrap; }
.status { font-size:14px; color:#94a3b8; margin-top:10px; }
</style>
</head>
<body>
<h2>📷 AI Document Scanner</h2>
<div id="camera-wrapper">
<video id="video" autoplay playsinline muted></video>
</div>
<div class="controls">
<button onclick="captureAndProcess()">SCAN TEXT</button>
<div id="status" class="status">Camera Ready</div>
</div>
<div id="result-box">Extracted text will appear here...</div>
<canvas id="canvas" style="display:none;"></canvas>
<script>
const video = document.getElementById("video");
const canvas = document.getElementById("canvas");
const status = document.getElementById("status");
const resultBox = document.getElementById("result-box");

async function startCamera() {
    try {
        const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode:"environment", width:1280 } });
        video.srcObject = stream;
        status.innerText = "Camera Active";
    } catch(err) {
        status.innerText = "Error: " + err.message;
        console.error(err);
    }
}

async function captureAndProcess() {
    status.innerText = "Capturing...";
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    const ctx = canvas.getContext("2d");
    ctx.drawImage(video, 0, 0);

    const base64Image = canvas.toDataURL("image/jpeg", 0.6);
    status.innerText = "AI Processing...";

    try {
        const response = await fetch("/process", {
            method:"POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ image: base64Image })
        });

        if(!response.ok) throw new Error("Server Error " + response.status);
        const data = await response.json();
        resultBox.innerText = data.text || "No text detected. Try closer/better light.";
        status.innerText = "Analysis Complete";

    } catch(err) {
        status.innerText = "Request Failed";
        resultBox.innerText = "Error: " + err.message;
    }
}

startCamera();
</script>
</body>
</html>
  `);
});

// OCR processing endpoint
app.post("/process", async (req, res) => {
    try {
        const { image } = req.body;
        if (!image) return res.status(400).json({ text: "No image data received" });

        const base64Data = image.split(",")[1];
        const buffer = Buffer.from(base64Data, "base64");

        const { data: { text } } = await Tesseract.recognize(buffer, "eng", { logger: m => console.log(m) });

        res.json({ text: text.trim() });

    } catch (err) {
        console.error(err);
        res.status(500).json({ text: "Backend Error: " + err.message });
    }
});

app.listen(PORT, () => console.log(`OCR server running on http://0.0.0.0:${PORT}`));