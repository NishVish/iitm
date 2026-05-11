@if ($data['emailpage'])
    @include('web.registration.successpage.emailsection')
@endif

@if ($data['preview'])
    <div id="preview">
        @include('web.registration.successpage.badge')
    </div>
@endif

@if ($data['print'])
    <div id="print-wrapper" style="position: fixed; left: -9999px; top: 0;">

        <!-- A4 EXACT SIZE -->
        <div id="badge" style="width:210mm; height:297mm; margin:0; padding:0; background:#fff; color:#000;">
            @include('web.registration.successpage.badge')
        </div>

    </div>

    <script>
        function downloadPDF() {
            const element = document.getElementById("badge");
            if (!element) return;

            const opt = {
                margin: 0,
                filename: 'iitm-entry-badge.pdf',
                image: { type: 'jpeg', quality: 1 },
                html2canvas: {
                    scale: 2,
                    useCORS: true,
                    scrollY: 0
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a4',
                    orientation: 'portrait'
                },
                pagebreak: { mode: ['avoid-all'] }
            };

            html2pdf().set(opt).from(element).save();
        }

        window.addEventListener("load", function () {
            setTimeout(downloadPDF, 500);
        });
    </script>
@endif

<!-- LIBRARY -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<!-- GLOBAL RESET -->
<style>
    body {
        margin: 0;
        padding: 0;
    }

    #badge {
        box-sizing: border-box;
        overflow: hidden;
    }
</style>