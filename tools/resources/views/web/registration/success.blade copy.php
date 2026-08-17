<td background="https://iitmindia.com/assets/creatives/1.jpg" bgcolor="#1e293b" width="600" height="400" valign="bottom"
    style="background-image: url('https://iitmindia.com/assets/creatives/1.jpg'); background-size: cover; background-position: center top; height: 400px;">


    <!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>IITM Invitation</title>

        <style>
            body,
            table,
            td,
            a {
                -webkit-text-size-adjust: 100%;
                -ms-text-size-adjust: 100%;
            }

            img {
                border: 0;
                height: auto;
                line-height: 100%;
                outline: none;
                text-decoration: none;
            }

            .main-card {
                border-radius: 16px !important;
                overflow: hidden !important;
            }

            @media only screen and (max-width: 600px) {
                .main-card {
                    width: 100% !important;
                    border-radius: 0 !important;
                }

                .hero-text {
                    font-size: 24px !important;
                }
            }
        </style>
    </head>

    <body style="margin:0; padding:0; background-color:#f1f5f9; font-family: Arial, sans-serif;">

        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0"
            style="background-color:#f1f5f9;">
            <tr>
                <td align="center" style="padding:20px 10px;">

                    <!-- MAIN CARD -->
                    <table class="main-card" role="presentation" width="600" cellspacing="0" cellpadding="0" border="0"
                        style="width:100%; max-width:600px; background:#ffffff; border-radius:16px; overflow:hidden;">

                        <!-- HERO IMAGE -->
                        <tr>
                            <td background="https://iitmindia.com/assets/creatives/1.jpg" bgcolor="#1e293b" style="background-image:url('https://iitmindia.com/assets/creatives/1.jpg');
            background-size:cover; background-position:center; height:400px;">

                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                        <td style="padding:40px; text-align:center;
                        background:linear-gradient(to bottom, rgba(0,0,0,0), rgba(0,0,0,0.85));">

                                            <img src="https://iitmindia.com/assets/iitm3.png" width="100" alt="logo"
                                                style="margin-bottom:20px; filter: brightness(0) invert(1);">

                                            <h1 class="hero-text"
                                                style="margin:0; font-size:32px; color:#fff; font-weight:bold;">
                                                You’re Invited to <br>
                                                <span style="color:#818cf8;">{{ $city ?? 'Bengaluru' }}</span>
                                            </h1>

                                            <p style="color:#e2e8f0; font-size:16px; margin-top:10px;">
                                                Registration Confirmed for {{ $eventName ?? 'IITM Event' }}
                                            </p>

                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <!-- DETAILS -->
                        <tr>
                            <td style="padding:40px;">

                                <div
                                    style="padding:20px; border:1px solid #e2e8f0; border-radius:12px; background:#f8fafc;">
                                    <p style="font-size:14px; color:#1e293b; line-height:1.8;">
                                        <strong>📍 Venue:</strong> {{ $venue ?? 'Bengaluru, India' }} <br>
                                        <strong>🗓️ Dates:</strong> {{ $eventDates ?? '23 - 25 JULY 2026' }} <br>
                                        <strong>⚡ Status:</strong>
                                        <span
                                            style="background:#dcfce7; color:#166534; padding:3px 8px; border-radius:6px;">
                                            {{ $status ?? 'CONFIRMED' }}
                                        </span>
                                    </p>
                                </div>

                            </td>
                        </tr>

                        <!-- MID IMAGE -->
                        <tr>
                            <td>
                                <img src="https://iitmindia.com/assets/creatives/2.jpg"
                                    style="width:100%; display:block;" alt="Mid Banner">
                            </td>
                        </tr>

                        <!-- MID CONTENT -->
                        <tr>
                            <td style="padding:35px 40px; text-align:center; background:#ffffff;">
                                <h2 style="margin:0; font-size:22px; color:#1e293b;">
                                    Event Highlights
                                </h2>

                                <p style="margin-top:10px; font-size:14px; color:#475569; line-height:1.6;">
                                    Join industry experts, networking sessions, workshops, and innovation showcases
                                    designed to boost your professional journey.
                                </p>
                            </td>
                        </tr>

                        <!-- SECOND IMAGE -->
                        <tr>
                            <td>
                                <img src="https://iitmindia.com/assets/creatives/3.jpg"
                                    style="width:100%; display:block;" alt="Second Banner">
                            </td>
                        </tr>

                        <!-- BUTTON -->
                        <tr>
                            <td align="center" style="padding:30px;">
                                <a href="#" style="background:#4f46e5; color:#fff; padding:14px 32px;
                text-decoration:none; border-radius:8px; font-weight:bold; display:inline-block;">
                                    DOWNLOAD ENTRY BADGE
                                </a>
                            </td>
                        </tr>

                        <!-- FOOTER NOTE -->
                        <tr>
                            <td align="center" style="padding:20px; border-top:1px solid #f1f5f9;">
                                <p style="font-size:12px; color:#94a3b8;">
                                    Ref ID: #{{ $refId ?? rand(100000, 999999) }} <br>
                                    Please show this email at the registration desk.
                                </p>
                            </td>
                        </tr>

                    </table>

                    <!-- FOOTER -->
                    <table width="600" style="max-width:600px;">
                        <tr>
                            <td align="center" style="padding:20px; font-size:11px; color:#94a3b8;">
                                © 2026 IITM India. All rights reserved.
                            </td>
                        </tr>
                    </table>

                </td>
            </tr>
        </table>

    </body>

    </html>