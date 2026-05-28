<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Paged.js Full Page Layout</title>

    <script src="https://unpkg.com/pagedjs/dist/paged.polyfill.js"></script>

    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }

        body {
            margin: 0;
            font-family: Arial;
            background: #eee;
        }

        .print-area {
            width: 100%;
        }

        /* FULL PAGE FIX */
        .page {
            width: 297mm;
            height: 210mm;
            box-sizing: border-box;
            background: white;
            overflow: hidden;

            /* important for perfect pagination */
            break-after: page;
            page-break-after: always;

            display: flex;
            flex-direction: column;
        }

        /* CONTENT SHOULD FILL FULL PAGE */
        .page-content {
            flex: 1;
            width: 100%;
            height: 100%;
            padding: 0;
            margin: 0;
        }

        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            z-index: 999999;
        }

        @media print {
            .print-btn {
                display: none !important;
            }
        }
    </style>
</head>

<body>

    @include('web.sponsorship.css')
    <button class="print-btn" onclick="window.print()">Download PDF</button>

    <div class="print-area">

        <div class="page">
            <div class="page-content">
                @include('web.sponsorship.page1')
            </div>
        </div>

        <div class="page">
            <div class="page-content">
                @include('web.sponsorship.page2')
            </div>
        </div>

        <div class="page">
            <div class="page-content">
                @include('web.sponsorship.page3')
            </div>
        </div>

        <div class="page">
            <div class="page-content">
                @include('web.sponsorship.page4')
            </div>
        </div>

        <div class="page">
            <div class="page-content">
                @include('web.sponsorship.page5')
            </div>
        </div>

        <div class="page">
            <div class="page-content">
                @include('web.sponsorship.page6')
            </div>
        </div>

        <div class="page">
            <div class="page-content">
                @include('web.sponsorship.page7')
            </div>
        </div>

        <div class="page">
            <div class="page-content">
                @include('web.sponsorship.page8')
            </div>
        </div>

        <div class="page">
            <div class="page-content">
                @include('web.sponsorship.page9')
            </div>
        </div>

        <div class="page">
            <div class="page-content">
                @include('web.sponsorship.page10')
            </div>
        </div>

        <div class="page">
            <div class="page-content">
                @include('web.sponsorship.page11')
            </div>
        </div>

        <div class="page">
            <div class="page-content">
                @include('web.sponsorship.page12')
            </div>
        </div>

    </div>

</body>

</html>