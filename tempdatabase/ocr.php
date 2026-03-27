<?php
// Handle OCR request
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['image'])) {
        exit("No image received");
    }

    // Decode base64 image
    $imageData = str_replace("data:image/png;base64,", "", $data['image']);
    $imageData = base64_decode($imageData);

    // Save image
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $filePath = $uploadDir . "capture.png";
    file_put_contents($filePath, $imageData);

    // Run OCR
    $outputFile = $uploadDir . "output";
    exec("tesseract " . escapeshellarg($filePath) . " " . escapeshellarg($outputFile) . " -l eng");

    $text = file_exists($outputFile . ".txt") ? file_get_contents($outputFile . ".txt") : "OCR failed";

    echo $text;
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Live Webcam OCR</title>

<style>
body { font-family: Arial; text-align: center; background:#f4f4f4; }
.container { background:white; padding:20px; margin:30px auto; width:520px; border-radius:10px; }
video { width: 100%; border-radius: 10px; }
textarea { width:100%; height:150px; margin-top:15px; }
button { padding:10px 15px; margin-top:10px; cursor:pointer; }
</style>
</head>

<body>

<div class="container">
    <h2>Live Webcam Feed + OCR</h2>

    <!-- Live webcam feed -->
    <video id="video" autoplay playsinline></video>

    <br>
    <button onclick="capture()">Capture & Extract Text</button>

    <canvas id="canvas" style="display:none;"></canvas>

    <h3>OCR Result:</h3>
    <textarea id="result" readonly></textarea>
</div>

<script>
// Start webcam live feed
const video = document.getElementById("video");

navigator.mediaDevices.getUserMedia({ video: true })
.then(stream => {
    video.srcObject = stream;
})
.catch(err => {
    alert("Camera access denied: " + err);
});

// Capture frame from live feed
function capture() {
    const canvas = document.getElementById("canvas");
    const context = canvas.getContext("2d");

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    const imageData = canvas.toDataURL("image/png");

    fetch("", {
        method: "POST",
        body: JSON.stringify({ image: imageData }),
        headers: { "Content-Type": "application/json" }
    })
    .then(res => res.text())
    .then(text => {
        document.getElementById("result").value = text;
    });
}
</script>

</body>
</html>