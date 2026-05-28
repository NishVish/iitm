<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>12 Page A4 Landscape Document</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        @page {
            size: A4 landscape;
            margin: 10mm;
        }

        body {
            margin: 0;
            padding: 0;
            background: #ccc;
            font-family: sans-serif;
        }

        .page {
            width: 297mm;
            height: 210mm;
            margin: 20px auto;
            background: white;
            page-break-after: always;
            position: relative;
            box-sizing: border-box;
            border: 1px solid #eee;
            overflow: visible;
        }

        .page:last-child {
            page-break-after: auto;
        }

        .no-print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 24px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            z-index: 1000;
            font-weight: bold;
        }

        .no-print-btn:hover {
            background: #0056b3;
        }

        @media print {
            .no-print-btn {
                display: none;
            }
        }
    </style>
</head>

<body>

    <button class="no-print-btn" onclick="generatePDF()">Download as PDF</button>

    <div id="content-to-export">
        <div class="page">@include('web.sponsorship.page1')</div>
        <div class="page">@include('web.sponsorship.page2')</div>
        <div class="page">@include('web.sponsorship.page3')</div>
        <div class="page">@include('web.sponsorship.page4')</div>
        <div class="page">@include('web.sponsorship.page5')</div>
        <div class="page">@include('web.sponsorship.page6')</div>
        <div class="page">@include('web.sponsorship.page7')</div>
        <div class="page">@include('web.sponsorship.page8')</div>
        <div class="page">@include('web.sponsorship.page9')</div>
        <div class="page">@include('web.sponsorship.page10')</div>
        <div class="page">@include('web.sponsorship.page11')</div>
        <div class="page">@include('web.sponsorship.page12')</div>
    </div>
    <script>
        async function generatePDF() {

            const element = document.getElementById('content-to-export');

            // 🔥 STEP 1: FORCE REMOVE BROKEN IMAGES
            element.querySelectorAll("img").forEach(img => {
                if (!img.naturalWidth || img.naturalWidth === 0) {
                    img.remove(); // IMPORTANT: remove instead of hide
                }
            });

            // 🔥 STEP 2: REMOVE EMPTY BACKGROUND IMAGES (very important fix)
            const all = element.querySelectorAll("*");
            all.forEach(el => {
                const bg = window.getComputedStyle(el).backgroundImage;
                if (bg && bg !== "none") {
                    if (bg.includes("url") && bg.includes("undefined")) {
                        el.style.backgroundImage = "none";
                    }
                }
            });

            // wait for DOM cleanup
            await new Promise(r => setTimeout(r, 300));

            const opt = {
                margin: 0,
                filename: 'sponsorship-document.pdf',
                image: { type: 'jpeg', quality: 1 },
                html2canvas: {
                    scale: 2,
                    useCORS: true,
                    allowTaint: true,
                    backgroundColor: "#ffffff",
                    ignoreElements: (el) => {
                        // 🔥 SAFETY: skip empty elements that break canvas
                        return el.tagName === "CANVAS" && (!el.width || !el.height);
                    }
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a4',
                    orientation: 'landscape'
                }
            };

            try {
                await html2pdf().set(opt).from(element).save();
            } catch (err) {
                console.log("PDF ERROR:", err);
                alert("PDF generation failed. Check console.");
            }
        }
    </script>
</body>

</html>