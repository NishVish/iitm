<div style="width:100%; max-width:400px; margin:auto; font-family: sans-serif;">

    <div id="reader" style="border-radius:8px;"></div>

    <textarea id="result" style="width:100%; margin-top:10px; padding:10px;" rows="4" readonly></textarea>

    <button id="printBtn" disabled style="width:100%; margin-top:10px; padding:10px; background:#28a745; color:#fff;">
        Print Badge
    </button>

    <div id="printSection" style="margin-top:20px;">
        <strong id="nameBox">---</strong><br>
        <span id="companyBox">---</span><br>
        <span id="mobileBox">---</span>
    </div>

</div>

<script src="https://unpkg.com/html5-qrcode"></script>

<script>
    let lastScan = "";
    let scanCooldown = false;
    let matchedData = null;

    /* ================= PRINT ================= */
    function printBadge() {
        if (!matchedData?.db_match) {
            alert("No valid match");
            return;
        }

        window.print();
    }

    /* ================= SCAN ================= */
    function onScanSuccess(decodedText) {

        console.log("QR:", decodedText);

        if (scanCooldown || decodedText === lastScan) return;

        scanCooldown = true;
        lastScan = decodedText;

        document.getElementById("result").value = decodedText;

        const lastsegment = "{{ request()->segment(2) }}";

        const url = `/decodeqr/${lastsegment}`;

        console.log("FETCH:", url);

        fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ qr: decodedText })
        })
            .then(res => res.json())
            .then(data => {

                console.log("RESPONSE:", data);

                matchedData = data;

                if (data.db_match) {

                    document.getElementById("printBtn").disabled = false;

                    document.getElementById("nameBox").innerText = data.db_match.name;
                    document.getElementById("companyBox").innerText = data.db_match.company;
                    document.getElementById("mobileBox").innerText = data.db_match.mobile;

                } else {
                    document.getElementById("printBtn").disabled = true;
                    alert("No Match Found");
                }

            })
            .catch(err => {
                console.error("FETCH ERROR:", err);
            })
            .finally(() => {
                setTimeout(() => {
                    scanCooldown = false;
                    lastScan = "";
                }, 1000);
            });
    }

    /* ================= INIT CAMERA (FIXED) ================= */
    const qr = new Html5Qrcode("reader");

    Html5Qrcode.getCameras().then(devices => {

        if (!devices.length) {
            alert("No camera found");
            return;
        }

        qr.start(
            devices[0].id,
            {
                fps: 10,
                qrbox: 250
            },
            onScanSuccess
        );

    }).catch(err => {
        console.error("CAMERA ERROR:", err);
    });

    /* ================= PRINT EVENT ================= */
    document.getElementById("printBtn").addEventListener("click", printBadge);
</script>