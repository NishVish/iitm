<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IITM Sponsorship Prospectus</title>

    <style>
        * {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        @include('web.sponsorship.css')
        .page-image {
            height: 550px;
            width: 100%;
        }

        .content-row {
            display: flex;
            gap: 20px;
            align-items: flex-start;
        }

        .image-box {
            flex: 1;
        }

        .text-box {
            flex: 1;
        }

        .page-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 6px;
        }

        .side-description {
            font-size: 14px;
            line-height: 1.6;
        }
    </style>


    <style>
        /* --- LAST PAGE CONTAINER --- */
        .last-page {
            width: 297mm;
            height: 210mm;
            position: relative;
            overflow: hidden;
            background-color: var(--iitm-maroon);
            /* Fallback color */
        }

        /* --- BACKGROUND IMAGE HANDLING --- */
        .lastpage-bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
            opacity: 0.4;
            /* Softens the image to make text pop */
            filter: grayscale(20%);
            /* Adds a professional touch */
        }

        /* --- CONTENT OVERLAY --- */
        .lastpage-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 2;
            padding: 25mm;
            /* Precise print padding */
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            /* Centers the Thank You content */
            align-items: center;
            text-align: center;
        }

        /* --- LOGO ALIGNMENT --- */
        .logos {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 40px;
            margin-bottom: 40px;
        }

        .logo {
            height: 90px;
            width: auto;
            /* Forces logos to pure white for dark BG */
        }

        /* --- ORGANIZER BOX (IITM BRANDING) --- */
        .organizer-box {
            background: rgba(170, 45, 44, 0.85);
            /* IITM Maroon with transparency */
            padding: 30px 50px;
            border-radius: 15px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            max-width: 700px;
            backdrop-filter: blur(5px);
            /* Modern "glass" effect */
        }

        .organizer-box h2 {
            color: white;
            margin-bottom: 10px;
            font-size: 28px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .organizer-box p {
            margin: 5px 0;
            font-size: 16px;
            line-height: 1.6;
            opacity: 0.9;
        }

        /* --- THANK YOU TEXT --- */
        .thank-you {
            font-size: 80px;
            font-weight: 900;
            text-transform: uppercase;
            margin-bottom: 20px;
            letter-spacing: 10px;
            text-shadow: 2px 4px 10px rgba(0, 0, 0, 0.3);
        }
    </style>


    <style>
        /* ─── COVER PAGE ───────────────────────────────────────── */
        .cover-page {
            background: url('public/assets/3.jpg') center/cover no-repeat;
            color: white;
            justify-content: center;
            align-items: center;
        }

        .cover-box {
            border: 5px solid rgba(255, 255, 255, 0.8);
            padding: 48px 60px;
            text-align: center;
            width: 75%;
        }

        .cover-box h1 {
            font-size: 56px;
            margin: 0 0 16px;
            line-height: 1.1;
            letter-spacing: -1px;
        }

        .cover-box .event-name {
            font-size: 22px;
            margin: 0 0 8px;
            opacity: 0.95;
        }

        .cover-box .website {
            font-size: 15px;
            opacity: 0.75;
            margin: 0;
        }

        .cover-logo-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.18);
            padding: 10px 20mm;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            opacity: 0.9;
        }

        .coverlogo {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            margin-bottom: 80px;
        }

        /* IMAGE */
        .coverlogo img,
        img.coverlogo {
            width: 250px;
            height: 250px;
            object-fit: contain;
            display: block;
        }
    </style>
</head>

<body>
    <script>
        const FOOTER_HTML = `{!! view('web.sponsorship.footer')->render() !!}`;
    </script>
    <!-- TOOLBAR -->
    <div id="toolbar">
        <button class="btn" id="pdf-btn" onclick="window.print()" disabled>⬇ Generate PDF</button>
        <span id="toolbar-status">Loading data…</span>
    </div>

    <!-- PAGES CONTAINER -->
    <div id="pages-wrapper">
        <div id="status-box">⏳ Fetching sponsor data from server…</div>
        <div id="pages"></div>
    </div>

    <script>
        const pagesContainer = document.getElementById('pages');
        const statusBox = document.getElementById('status-box');
        const toolbarStatus = document.getElementById('toolbar-status');
        const pdfBtn = document.getElementById('pdf-btn');

        /* ── helpers ── */
        function setError(msg) {
            statusBox.textContent = '⚠ ' + msg;
            statusBox.classList.add('error');
            statusBox.style.display = 'block';
            toolbarStatus.textContent = 'Error loading data';
            console.error('[Prospectus]', msg);
        }

        function setStatus(msg) {
            toolbarStatus.textContent = msg;
        }


        @include('web.sponsorship.pagecomponents.index');


        @include('web.sponsorship.mainfunction')

    </script>



</body>

</html>