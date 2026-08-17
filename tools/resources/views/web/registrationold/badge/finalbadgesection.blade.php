@if ($data['emailpage'])
    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Registration Success</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    </head>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
    </style>

    <body style="margin:0; padding:0; background-color:#333333; font-family:Arial, sans-serif;">

        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td align="center"
                    style="background:#333333 url('https://iitmindia.com/assets/creatives/1.jpg') no-repeat center/cover; padding:60px 0;">

                    <table width="70%" cellpadding="0" cellspacing="0"
                        style="background:#ffffff; border-radius:14px; overflow:hidden;">

                        <!-- Logo -->
                        <tr>
                            <td align="center" style="padding:30px 0 20px;">
                                <img src="https://iitmindia.com/assets/iitm3.png" width="150" />
                            </td>
                        </tr>

                        <!-- Content -->
                        <tr>
                            <td style="padding:20px 40px 40px;">

                                <table width="100%" cellpadding="0" cellspacing="0">

                                    <tr>
                                        <td style="font-size:22px; font-weight:bold; text-align:center; color:#111;">
                                            You’re Invited to {{ $data['eventname'] ?? 'the Event' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="padding:15px 0; text-align:center; color:#555; font-size:15px;">
                                            {{ $data['message'] ?? 'We are pleased to confirm your registration.' }}
                                        </td>
                                    </tr>

                                    <!-- Info Box -->
                                    <tr>
                                        <td style="background:#f3f4f6; padding:20px; border-radius:10px;">

                                            <table width="100%" cellpadding="0" cellspacing="0"
                                                style="font-size:14px; color:#333;">

                                                <tr>
                                                    <td style="padding-bottom:10px;">
                                                        <strong>👤 Name:</strong> {{ $data['contactName'] ?? 'N/A' }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td
                                                        style="padding-top:10px; line-height:22px; font-family: Arial, sans-serif;">

                                                        <p>Dear <strong>{{ $data['contactName'] ?? 'Guest' }}</strong>,</p>

                                                        <p>
                                                            We are delighted to inform you that your registration for the
                                                            <strong>IITM Bengaluru</strong> event has been successfully
                                                            received.
                                                        </p>

                                                        <p>
                                                            This email serves as an official confirmation of your
                                                            participation in the event scheduled
                                                            from
                                                            <strong>23 – 25 July 2026</strong>.
                                                        </p>

                                                        <p>
                                                            Please find your event badge attached. Kindly print and wear it
                                                            during the event.
                                                        </p>

                                                        <p>
                                                            <strong>Note:</strong> This event is strictly for <strong>B2B
                                                                participants</strong>.
                                                        </p>

                                                        <!-- <p>
                                </p> -->

                                                        <p>
                                                            We look forward to welcoming you.
                                                        </p>

                                                        <br>

                                                        <p>
                                                            Best Regards,<br>
                                                            <strong>Team IITM</strong>
                                                        </p>

                                                    </td>
                                                </tr>

                                            </table>
                                        </td>
                                    </tr>

                                    <!-- Button -->
                                    <tr>
                                        <td align="center" style="padding-top:30px;">
                                            <a href="{{ url('generatebadge/' . $data['company_id'] . '/' . $data['contact_id'] . '/' . $data['databasename']) }}"
                                                style="background:#4f46e5; color:#ffffff; padding:14px 25px; text-decoration:none; border-radius:8px; font-weight:bold; display:inline-block;">
                                                DOWNLOAD ENTRY BADGE
                                            </a>
                                        </td>
                                    </tr>

                                </table>
                            </td>
                        </tr>

                        <!-- Footer -->
                        <tr>
                            <td style="padding:20px; text-align:center; font-size:11px; color:#999; background:#f9fafb;">
                                © 2026 IITM India. All rights reserved.
                            </td>
                        </tr>

                    </table>

                </td>
            </tr>
        </table>
@endif



    @if ($data['preview'])
        <style>
            body {
                margin: 0;
                padding: 0;
            }
        </style>
        <div id="preview">
            @include('web.registration.successpage.badge')
        </div>
    @endif

    @if ($data['print'])
        <style>
            body {
                margin: 0;
                padding: 0;
            }
        </style>
        <div id="print-wrapper" style="position: fixed; left: -9999px; top: 0;">
            <div id="badge" style="width:210mm; background:#fff; color:#000;">
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
                        useCORS: true
                    },
                    jsPDF: {
                        unit: 'mm',
                        format: 'a4',
                        orientation: 'portrait'
                    }
                };

                html2pdf().set(opt).from(element).save();
            }

            @if ($data['print'])
                window.addEventListener("load", function () {
                    setTimeout(downloadPDF, 500);
                });
            @endif
        </script>
    @endif

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

</body>



</html>