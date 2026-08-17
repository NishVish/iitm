<?php

include('stats.php');
include('pie.php');


?>


<div class="insight-box">
    <h3>💡 Key Strategic YoY Insights</h3>
    <p>
        <strong>Accelerated YoY Visitor Expansion:</strong> Trade visitor attendance experienced a massive
        surge in 2025 (+93.2% YoY to 4,250) and stabilized into sustained higher attendance in 2026 (+7.3%
        YoY to 4,560).
    </p>
    <p style="margin-top: 6px;">
        <strong>YoY ROI Improvement:</strong> The attendee-to-exhibitor density nearly doubled from 8.8:1
        (2024) to 16.2:1 (2025), maintaining high density at 16.5:1 (2026).
    </p>
</div>

</div>


<div class="footer">
    Brand Theme • <strong style="color:#AA2324;">#AA2324</strong>
</div>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    function downloadPageAsJPEG() {
        const target = document.body; // or a specific div, see note below

        html2canvas(target, {
            scale: 4,               // higher = sharper (2=normal, 4=very high quality)
            useCORS: true,          // allows external images/fonts to render
            backgroundColor: '#ffffff',
            logging: false
        }).then(canvas => {
            const link = document.createElement('a');
            link.download = 'strategic-report-' + Date.now() + '.jpg';
            link.href = canvas.toDataURL('image/jpeg', 1.0); // 1.0 = max quality
            link.click();
        });
    }
</script>

<button onclick="downloadPageAsJPEG()" style="padding:10px 20px; cursor:pointer;">
    Download as JPEG (High Quality)
</button>
</body>

</html>