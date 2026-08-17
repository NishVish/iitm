@if ($data['emailpage'])
    @include('web.registrationold.email.trade')
@endif




@if ($data['preview'])

    <div id="preview">
        @include('web.registrationold.badge.index')
    </div>
@endif

@if ($data['print'])
    <div id="print-wrapper" style="position: fixed; left: -9999px; top: 0;">

        <!-- FIXED A4 CONTAINER -->
        <div id="badge">
            @include('web.registrationold.badge.index')
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
                    scale: 4,
                    useCORS: true,
                    scrollY: 0,
                    letterRendering: true
                },

                jsPDF: {
                    unit: 'mm',
                    format: 'a4',
                    orientation: 'portrait'
                },

                pagebreak: { mode: [] }
            };

            html2pdf().set(opt).from(element).save();
        }

        window.addEventListener("load", async function () {

            // wait for fonts
            if (document.fonts) {
                await document.fonts.ready;
            }

            // wait for layout paint cycle
            await new Promise(requestAnimationFrame);
            await new Promise(requestAnimationFrame);

            setTimeout(() => {
                downloadPDF();
            }, 1000);
        });
    </script>
@endif

<!-- LIBRARY -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<style>
    body {
        margin: 0;
        padding: 0;
    }

    /* FIX: DO NOT LOCK HEIGHT TO 297mm */
    #badge {
        width: 210mm;

        /* FIX: do NOT force full page height */
        height: 980px;

        /* IMPORTANT: avoid extra canvas space */
        min-height: unset;

        margin: 0;
        padding: 0;
        box-sizing: border-box;

        background: #fff;
        color: #000;

        /* safer for html2canvas */
        overflow: visible;
    }

    /* Prevent internal shifting */
    * {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
</style>