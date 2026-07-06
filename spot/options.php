<div style="display:flex; gap:20px; align-items:flex-start; margin-bottom:15px;">

    <!-- Image Visibility -->
    <div style="border:1px solid #ddd; border-radius:8px; padding:12px 15px; background:#f8f9fa;">
        <div style="font-weight:600; margin-bottom:10px;">
            Image Visibility
        </div>

        <label style="display:inline-flex; align-items:center; margin-right:20px; cursor:pointer;">
            <input type="radio" name="opacityToggle" id="enableOpacity" onchange="toggleOpacity(true)"
                style="margin-right:6px;">
            Show Image
        </label>

        <label style="display:inline-flex; align-items:center; cursor:pointer;">
            <input type="radio" name="opacityToggle" id="disableOpacity" onchange="toggleOpacity(false)" checked
                style="margin-right:6px;">
            Hide Image
        </label>
    </div>

    <!-- QR Visibility -->
    <div style="border:1px solid #ddd; border-radius:8px; padding:12px 15px; background:#f8f9fa;">
        <div style="font-weight:600; margin-bottom:10px;">
            QR Visibility
        </div>

        <label style="display:inline-flex; align-items:center; margin-right:20px; cursor:pointer;">
            <input type="radio" id="showQr" name="qrVisibility" onchange="toggleQrVisibility(true)"
                style="margin-right:6px;">
            Show QR
        </label>

        <label style="display:inline-flex; align-items:center; cursor:pointer;">
            <input type="radio" id="hideQr" name="qrVisibility" onchange="toggleQrVisibility(false)"
                style="margin-right:6px;">
            Hide QR
        </label>


    </div>

</div>



<script>
    function toggleQrVisibility(show) {
        const qr = document.querySelector(".contactqr");
        if (!qr) return;

        qr.style.display = show ? "block" : "none";

        // Remember selection
        localStorage.setItem("showQr", show ? "1" : "0");
    }

    // Restore on page load
    window.addEventListener("load", function () {
        const show = localStorage.getItem("showQr") === "1";

        document.getElementById("showQr").checked = show;
        document.getElementById("hideQr").checked = !show;

        toggleQrVisibility(show);
    });

</script>