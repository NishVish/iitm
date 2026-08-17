<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Registration Success</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body style="margin:0; padding:0; background:#1a1a1a; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center"
                style="padding:40px 0; background:#1a1a1a url('https://iitmindia.com/assets/creatives/1.jpg') center/cover no-repeat;">

                <table width="600" cellpadding="0" cellspacing="0" border="0"
                    style="background:#ffffff; border-radius:16px; overflow:hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">

                    <tr>
                        <td align="center" style="padding:40px 0 20px;">
                            <img src="https://iitmindia.com/assets/iitm3.png" width="140"
                                style="display:block; margin-bottom: 15px;" alt="Logo" />
                            <hr style="width:90%; height:1px; background-color:#aa2324; border:none; margin:6px auto;">
                            <div
                                style="font-size:11px; letter-spacing:4px; color:#aa2324; font-weight:bold; text-transform: uppercase;">
                                Official Invitation
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:0 25px 10px;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">



                                <table width="90%" border="0" cellpadding="0" cellspacing="0" align="center"
                                    style="margin: 0 auto; border: 1px solid #f0f0f0; border-radius: 8px; font-family: 'Georgia', serif; color: #333333;">
                                    <tr>
                                        <td style="padding: 25px;">
                                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td width="60%" valign="top" style="text-align: left;">
                                                        <h2
                                                            style="margin: 0 0 15px 0; color: #aa2324; font-size: 22px; text-transform: uppercase; letter-spacing: 1px; font-weight: bold;">
                                                            {{ $data['select2'] }}
                                                        </h2>

                                                        <table width="100%" border="0" cellpadding="0" cellspacing="0"
                                                            style="font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; line-height: 20px; color: #555555;">
                                                            <tr>
                                                                <td style="padding-bottom: 4px;">
                                                                    <strong
                                                                        style="color: #aa2324; text-transform: uppercase; font-size: 10px; letter-spacing: 1px;">Email:</strong>
                                                                    {{ $data['email'] }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding-bottom: 4px;">
                                                                    <strong
                                                                        style="color: #aa2324; text-transform: uppercase; font-size: 10px; letter-spacing: 1px;">Mobile:</strong>
                                                                    {{ $data['mobile'] }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding-bottom: 4px;">
                                                                    <strong
                                                                        style="color: #aa2324; text-transform: uppercase; font-size: 10px; letter-spacing: 1px;">Company:</strong>
                                                                    {{ $data['companyName'] }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding-top: 15px; padding-bottom: 15px;">
                                                                    <div
                                                                        style="width: 100%; height: 2px; background-color: #aa2324; font-size: 1px; line-height: 1px;">
                                                                        &nbsp;</div>
                                                                </td>
                                                            </tr>
                                                            <tr>

                                                            </tr>
                                                        </table>
                                                    </td>

                                                    <td width="40" style="width: 40px;">&nbsp;</td>

                                                    <td width="160" valign="middle" align="center"
                                                        style="border-left: 1px solid #eeeeee; padding-left: 20px; text-align: center;">
                                                        <table border="0" cellpadding="0" cellspacing="0"
                                                            align="center">
                                                            <tr>
                                                                <td
                                                                    style="padding: 10px; border: 1px solid #aa2324; border-radius: 4px; background-color: #ffffff;">
                                                                    @include('web.registration.successpage.badgecomponent.qr')



                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td
                                                                    style="padding-top: 10px; font-family: 'Helvetica', 'Arial', sans-serif; font-size: 9px; text-transform: uppercase; letter-spacing: 2px; color: #aa2324; font-weight: bold; text-align: center;">
                                                                    Registration Pass
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>



                                <tr>
                                    <td align="center" style="padding:10px 0 25px;">
                                        <div
                                            style="font-family: Georgia, serif; font-size: 32px; color: #111; line-height: 1.2; font-weight: normal;">
                                            {{ $data['eventname'] ?? 'The Event' }}
                                        </div>

                                        <div style="width:50px; border-bottom:3px solid #aa2324; margin:3px auto;">
                                        </div>

                                        <div style="font-size: 16px; color: #555; line-height: 1.6;">
                                            <span
                                                style="color: #aa2324; font-weight: bold; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; display: block; margin-bottom: 4px;"></span>
                                            {{ $data['venue'] }}
                                        </div>

                                        @php
                                            // echo "<pre>";
                                            // print_r($data['all_dates']);
                                            // echo "</pre>";
                                            use Carbon\Carbon;
                                            $start = Carbon::parse($data['all_dates'][0] ?? null);
                                            $end = Carbon::parse($data['all_dates'][1] ?? null);
                                            $formattedDate = '';

                                            if ($start && $end) {
                                                if ($start->format('F Y') === $end->format('F Y')) {
                                                    $formattedDate = $start->format('d') . '–' . $end->format('d F Y');
                                                } else {
                                                    $formattedDate = $start->format('d M Y') . ' – ' . $end->format('d M Y');
                                                }
                                            }
                                        @endphp

                                        <p style="margin: 5px 0 0; font-size: 15px; color: #666;">
                                            Event dates: <b
                                                style="color:#111;">{{ $formattedDate ?: 'To Be Announced' }}</b>
                                        </p>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding: 20px 0;">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                            style="background:#fdf2f2; border-left:4px solid #aa2324; border-radius: 4px;">
                                            <tr>
                                                <td
                                                    style="padding:15px 20px; font-size:13px; color:#444; line-height: 1.5;">
                                                    <b style="color:#7a191a;">Entry Policy:</b> B2B participants only.
                                                    <br />
                                                    You may print your badge or show this <b
                                                        style="color:#aa2324;">Digital Pass</b> at the registration desk
                                                    for seamless entry.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td align="center" style="padding:10px 0 30px;">
                                        <p style="margin:0; font-size: 15px; color: #444;">We look forward to welcoming
                                            you.</p>
                                        <div style="margin-top: 25px;">
                                            <div style="font-size:13px; color:#888;">Best Regards,</div>
                                            <div
                                                style="font-family:Georgia,serif; font-size:20px; color:#aa2324; font-weight:bold; margin-top: 5px;">
                                                Team IITM
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td align="center" style="padding-bottom:10px;">
                                        @php

                                            $data['databasename'] = strtolower(trim($data['databasename']));
                                            $data['databasename'] = preg_replace('/[^a-z0-9]+/', '-', $data['databasename']);
                                            $data['databasename'] = trim($data['databasename'], '-');
                                        @endphp


                                        <a href="">DOWNLOAD ENTRY BADGE
                                        </a>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td align="center"
                            style="padding:25px; font-size:11px; color:#999; background:#f9f9f9; border-top:1px solid #eeeeee;">
                            © 2026 <strong>IITM India</strong>. All rights reserved. <br />
                            <span style="display: block; margin-top: 5px;">You are receiving this email because you
                                registered for an IITM event.</span>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>