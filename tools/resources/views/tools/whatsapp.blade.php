<style>
    .wa-qr-box {
        max-width: 520px;
        margin: auto;
        background: #111827;
        color: #e5e7eb;
        padding: 24px;
        border-radius: 14px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        font-family: Arial, sans-serif;
    }

    .wa-qr-box h2 {
        margin-bottom: 16px;
        color: #fff;
    }

    .wa-qr-box input {
        width: 100%;
        padding: 12px;
        font-size: 15px;
        border-radius: 8px;
        border: 1px solid #374151;
        background: #1f2937;
        color: #fff;
        outline: none;
    }

    .wa-qr-box input::placeholder {
        color: #9ca3af;
    }

    .wa-qr-box .link {
        margin-top: 12px;
        font-size: 13px;
        color: #93c5fd;
        word-break: break-all;
    }

    .wa-qr-box img {
        margin-top: 18px;
        border-radius: 10px;
        display: none;
        /* Centers the image within the container */
        margin-left: auto;
        margin-right: auto;
    }

    .hint {
        font-size: 12px;
        color: #9ca3af;
        margin-top: 8px;
    }
</style>

<div class="wa-qr-box">
    <h2>WhatsApp QR Generator</h2>
    <input type="text" id="number" placeholder="Enter number e.g. 919876543210" oninput="generateQR()" />
    <div class="hint">Live QR updates as you type</div>
    <div class="link" id="link"></div>
    <img id="qr" alt="WhatsApp QR Code" />
</div>

<script>
    function generateQR() {
        let input = document.getElementById("number").value;
        let clean = input.replace(/[^0-9]/g, "");

        if (!clean) {
            document.getElementById("qr").style.display = "none";
            document.getElementById("link").innerHTML = "";
            return;
        }

        let url = "https://wa.me/91" + clean;
        document.getElementById("link").innerText = url;

        // FIXED: Switched from the deprecated Google Charts API to goqr.me API
        let qr = "https://api.qrserver.com/v1/create-qr-code/?size=280x280&data=" + encodeURIComponent(url);

        let img = document.getElementById("qr");
        img.src = qr;
        img.style.display = "block";
    }
</script>