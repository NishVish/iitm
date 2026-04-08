from PIL import Image
import pytesseract
from flask import Flask, request, jsonify, render_template_string
import io
import base64

app = Flask(__name__)

# Set the path to Tesseract executable
pytesseract.pytesseract.tesseract_cmd = "/usr/bin/tesseract"

HTML_PAGE = """
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>AI Precision OCR</title>
    <style>
        body { font-family: -apple-system, sans-serif; background: #0f172a; color: white; text-align: center; margin: 0; padding: 20px; }
        #camera-wrapper { 
            position: relative; width: 100%; max-width: 500px; margin: auto; 
            border: 3px solid #6366f1; border-radius: 15px; overflow: hidden; 
        }
        video { width: 100%; display: block; background: #000; }
        .controls { margin: 20px 0; }
        button { 
            background: #6366f1; color: white; border: none; padding: 15px 40px; 
            font-size: 18px; font-weight: bold; border-radius: 10px; cursor: pointer; 
        }
        button:active { transform: scale(0.95); background: #4f46e5; }
        #result-box { 
            background: #1e293b; padding: 15px; border-radius: 10px; margin-top: 20px; 
            min-height: 100px; text-align: left; border: 1px solid #334155; white-space: pre-wrap;
        }
        .status { font-size: 14px; color: #94a3b8; margin-top: 10px; }
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
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const status = document.getElementById('status');
        const resultBox = document.getElementById('result-box');

        async function startCamera() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { facingMode: "environment", width: { ideal: 1280 } } 
                });
                video.srcObject = stream;
                status.innerText = "Camera Active";
            } catch (err) {
                status.innerText = "Error: " + err.message;
                console.error(err);
            }
        }

        async function captureAndProcess() {
            status.innerText = "Capturing...";
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0);

            const base64Image = canvas.toDataURL('image/jpeg', 0.6);
            status.innerText = "AI Processing...";

            try {
                const response = await fetch('/process', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ image: base64Image })
                });

                if (!response.ok) throw new Error("Server Error " + response.status);
                const data = await response.json();
                resultBox.innerText = data.text || "No text detected. Try closer/better light.";
                status.innerText = "Analysis Complete";

            } catch (err) {
                status.innerText = "Request Failed";
                resultBox.innerText = "Error: " + err.message;
            }
        }

        startCamera();
    </script>
</body>
</html>
"""
@app.route("/")
def home():
    return render_template_string(HTML_PAGE)

@app.route("/process", methods=["POST"])
def process():
    try:
        data = request.json.get("image")
        if not data:
            return jsonify({"text": "No image data received"}), 400

        encoded_data = data.split(",")[1]
        image_bytes = base64.b64decode(encoded_data)
        img = Image.open(io.BytesIO(image_bytes)).convert("L")  # grayscale for better OCR

        text = pytesseract.image_to_string(img)
        return jsonify({"text": text.strip()})

    except Exception as e:
        print(f"Error: {e}")
        return jsonify({"text": f"Backend Error: {str(e)}"}), 500

if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000, debug=False)