<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>A4 Page with Two Divs + Instructions</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #eee;
        }

        /* A4 page */
        .a4 {
            width: 21cm;
            height: 29.7cm;
            padding: 1cm;
            box-sizing: border-box;
            overflow: hidden;
            background: white;
            margin: 0 auto;
        }

        /* top wrapper */
        .wrapper {
            display: flex;
            justify-content: center;
            gap: 0cm;
        }

        .box {
            width: 9.2cm;
            height: 13.4cm;
            border: 1px solid black;
            box-sizing: border-box;
        }



        @media print {
            body {
                background: none;
            }

            .a4 {
                margin: 0;
            }
        }
    </style>
</head>

<body>

    <div class="a4">

        <!-- Top section -->
        <div class="wrapper">
            <div class="box">
                @include('web.registrationold.badge.badgefront')
            </div>

            <div class="box">
                @include('web.registrationold.badge.badgeback')
            </div>
        </div>
        <!-- Instruction Box Styles -->
        <style>
            #instructionbox {
                border: 1px solid #d1d5db;
                background: #f9fafb;
                border-radius: 8px;
                padding: 12px 16px;
                margin: 12px;
                font-size: 12px;
                font-family: Arial, sans-serif;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            }

            #instructionbox h4 {
                margin: 0 0 8px 0;
                font-size: 13px;
                color: #111827;
                text-align: center;
                letter-spacing: 0.5px;
            }

            #instructionbox ul {
                padding-left: 18px;
                margin: 0;
                line-height: 1.6;
                color: #374151;
            }

            #instructionbox li {
                margin-bottom: 4px;
            }

            #instructionbox .note {
                margin-top: 10px;
                padding: 8px;
                border-top: 1px solid #e5e7eb;
                font-size: 11px;
                color: #b91c1c;
                text-align: center;
                font-weight: bold;
            }
        </style>

        <!-- Instruction Box -->
        <div id="instructionbox">
            <h4>Visitor Instructions</h4>
            <ul>
                <li>Carry your badge at all times.</li>
                <li>The badge is non-transferable.</li>
                <li>Photography is allowed only in designated areas.</li>
                <li>Please maintain venue decorum.</li>
                <li>Entry rights are reserved by Team IITM.</li>
                <li>Please bring your business card.</li>
                <li>Submit your business card at the registration desk to verify your badge.</li>
            </ul>

            <div class="note">
                Note: This event is strictly for B2B attendees only. No general public entry. A business card is
                required for
                verification.
            </div>
        </div>

        <!-- <script>
function downloadPDF() {
    const element = document.querySelector("#badge");

    const opt = {
        margin: 0,
        filename: 'iitm-entry-badge.pdf',
        image: { type: 'jpeg', quality: 1 },
        html2canvas: {
            scale: 2, // Start with 2 to ensure it works, increase to 4 once it's confirmed
            useCORS: true,
            allowTaint: true, // Helps with cross-origin images
            letterRendering: true,
            logging: true // Check console for errors if it's still blank
        },
        jsPDF: {
            unit: 'mm',
            format: 'a4',
            orientation: 'portrait'
        }
    };

    html2pdf().set(opt).from(element).save();
}

window.addEventListener("load", function () {
    // Check if the element exists and has content before running
    if(document.querySelector("#badge")) {
        setTimeout(downloadPDF, 2000); 
    }
});
</script> -->
</body>

</html>