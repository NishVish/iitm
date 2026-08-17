<?php

include('stats.php');
include('pie.php');


?>


<div class="insight-box">
    <h3>💡 Key Strategic YoY Insights</h3>

    <p>
        <strong>Steady Trade Visitor Growth:</strong> Trade visitor attendance increased consistently from
        <strong>7,900</strong> in 2024–2025 to <strong>8,710</strong> in 2025–2026
        (<strong>+10.3% YoY</strong>), followed by a further rise to
        <strong>9,160</strong> in 2026–2027 (<strong>+5.2% YoY</strong>), reflecting sustained market
        interest and expanding industry participation.
    </p>

    <p style="margin-top:6px;">
        <strong>Strong Exhibitor Expansion:</strong> Exhibitor participation grew from
        <strong>490</strong> to <strong>570</strong> (<strong>+16.3% YoY</strong>) and further to
        <strong>674</strong> (<strong>+18.2% YoY</strong>), while the exhibition area expanded from
        <strong>64,329 sq. ft.</strong> to <strong>76,205 sq. ft.</strong>, demonstrating increased demand
        for exhibition space and stronger industry confidence.
    </p>
</div>



</div>


<!-- <div class="footer">
    Brand Theme • <strong style="color:#AA2324;">#AA2324</strong>
</div> -->

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

<!-- <button onclick="downloadPageAsJPEG()" style="padding:10px 20px; cursor:pointer;">
    Download as JPEG (High Quality)
</button> -->
</body>

</html>