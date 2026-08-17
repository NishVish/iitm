<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Registration Success</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <meta name="color-scheme" content="light only">
    <meta name="supported-color-schemes" content="light only">
</head>

<body style="margin:0; padding:0; background:#1a1a1a !important; color-scheme:light only;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center"
                style="padding:40px 0; background:#1a1a1a url('https://iitmindia.com/assets/creatives/1.jpg') center/cover no-repeat;">

                <table width="600" cellpadding="0" cellspacing="0" border="0"
                    style="background:#ffffff !important; color:#111111 !important; border-radius:16px; overflow:hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">

                    <tr>
                        <td align="center" style="padding:40px 0 20px; color:#111111 !important;">
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
                        <td style="padding:0 25px 10px; color:#111111 !important;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">

                                @include('mail.templates.registration.contact')

                                <tr>
                                    <td align="center" style="padding:10px 0 25px; color:#111111 !important;">
                                        <div
                                            style="font-family: Georgia, serif; font-size: 32px; color: #111111 !important; line-height: 1.2;">
                                            {{ $data['eventname'] ?? 'The Event' }}
                                        </div>

                                        <div style="width:50px; border-bottom:3px solid #aa2324; margin:3px auto;">
                                        </div>

                                        <div style="font-size: 16px; color: #555555 !important; line-height: 1.6;">
                                            {{ $data['venue'] }}
                                        </div>

                                        @php
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

                                        <p style="margin: 5px 0 0; font-size: 15px; color: #666666 !important;">
                                            Event dates:
                                            <b
                                                style="color:#111111 !important;">{{ $formattedDate ?: 'To Be Announced' }}</b>
                                        </p>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding: 20px 0;">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                            style="background:#fdf2f2; border-left:4px solid #aa2324; border-radius: 4px;">
                                            <tr>
                                                <td
                                                    style="padding:15px 20px; font-size:13px; color:#444444 !important; line-height: 1.5;">
                                                    <b style="color:#7a191a;">Entry Policy:</b> B2B participants only.
                                                    <br />
                                                    You may print your badge or show this
                                                    <b style="color:#aa2324;">Digital Pass</b> at the registration desk
                                                    for seamless entry.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td align="center" style="padding:10px 0 30px;">
                                        <p style="margin:0; font-size: 15px; color: #444444 !important;">
                                            We look forward to welcoming you.
                                        </p>
                                        <div style="margin-top: 25px;">
                                            <div style="font-size:13px; color:#888888 !important;">Best Regards,</div>
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

                                        <a href="{{ url('generatebadge/' . $data['company_id'] . '/' . $data['contact_id'] . '/' . $data['databasename']) }}"
                                            style="background:#aa2324; color:#ffffff; padding:16px 32px; font-size:14px; font-weight:bold;
                                            text-decoration:none; border-radius:6px; display:inline-block; letter-spacing:1px; box-shadow:0 4px 12px rgba(170, 35, 36, 0.3);">
                                            DOWNLOAD ENTRY BADGE
                                        </a>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td align="center"
                            style="padding:25px; font-size:11px; color:#999999 !important; background:#f9f9f9; border-top:1px solid #eeeeee;">
                            © 2026 <strong>IITM India</strong>. All rights reserved. <br />
                            <span style="display:block; margin-top:5px;">
                                You are receiving this email because you registered for an IITM event.
                            </span>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>