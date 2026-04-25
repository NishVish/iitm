<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Test Email</title>
</head>

<body style="margin:0; padding:0; font-family: Arial, sans-serif; background:#f5f5f5;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center" style="padding:40px 10px;">

                <table width="600" cellpadding="0" cellspacing="0" border="0"
                    style="background:#ffffff; border:1px solid #ddd; border-radius:8px;">

                    <tr>
                        <td style="padding:20px; text-align:center;">

                            <h2 style="color:#aa2324; margin:0;">
                                Test Email Works 🎉
                            </h2>

                            <p style="font-size:14px; color:#333; margin-top:15px;">
                                Hello <b>{{ $data['name'] ?? 'User' }}</b>,
                            </p>

                            <p style="font-size:14px; color:#555;">
                                If you are seeing this email, your Laravel renderer + mail system is working correctly.
                            </p>

                            <hr style="margin:20px 0; border:none; border-top:1px solid #eee;">

                            <p style="font-size:13px; color:#777;">
                                Email: {{ $data['email'] ?? 'not-provided' }}<br>
                                Mobile: {{ $data['mobile'] ?? 'not-provided' }}
                            </p>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>