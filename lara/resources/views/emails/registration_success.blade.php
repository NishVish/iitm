<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Registration Successful</title>
</head>

<body style="margin:0; padding:0; background:#f4f6f9; font-family:Arial, sans-serif;">

    <!-- Container -->
    <div
        style="max-width:600px; margin:40px auto; background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 6px 18px rgba(0,0,0,0.1);">

        <!-- Header -->
        <div style="background:linear-gradient(135deg,#4f46e5,#06b6d4); padding:20px; text-align:center; color:#fff;">
            <h2 style="margin:0;">🎉 Registration Successful</h2>
            <p style="margin:5px 0 0;">Welcome to the event</p>
        </div>

        <!-- Body -->
        <div style="padding:30px; color:#333;">

            <h3 style="margin-top:0;">Hi {{ $data['company_name'] ?? 'User' }},</h3>

            <p style="font-size:15px; line-height:1.6;">
                Your registration has been successfully completed. We’re excited to have you onboard!
            </p>

            <!-- Event Box -->
            <div
                style="margin:20px 0; padding:15px; background:#f0f9ff; border-left:5px solid #06b6d4; border-radius:6px;">
                <strong>Event:</strong>
                <span style="color:#0f172a;">
                    {{ $data['eventname'] ?? 'N/A' }}
                </span>
            </div>

            <!-- CTA Button -->
            <div style="text-align:center; margin:30px 0;">
                <a href="#"
                    style="background:#4f46e5; color:#fff; padding:12px 25px; text-decoration:none; border-radius:6px; display:inline-block;">
                    View Details
                </a>
            </div>

            <p style="font-size:14px; color:#666;">
                If you have any questions, feel free to contact our support team.
            </p>

            <p style="margin-top:30px;">
                Regards,<br>
                <strong>IITM Team</strong>
            </p>

        </div>

        <!-- Footer -->
        <div style="background:#f9fafb; text-align:center; padding:15px; font-size:12px; color:#888;">
            © {{ date('Y') }} IITM. All rights reserved.
        </div>

    </div>

</body>

</html>