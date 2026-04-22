<div style="background-color: #f8fafc; padding: 40px 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
    <div
        style="max-width: 600px; margin: 0 auto; background-image: url('https://iitmindia.com/assets/creatives/1.jpg'); background-size: cover; background-position: center; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">

        <div
            style="background: rgba(255, 255, 255, 0.96); margin: 20px; border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.3);">

            <div
                style="background: linear-gradient(135deg, #1e1b4b 0%, #4338ca 100%); padding: 40px 30px; text-align: center;">
                <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt="IITM Logo"
                    style="width: 140px; margin-bottom: 20px; filter: brightness(0) invert(1);">
                <h1
                    style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 800; letter-spacing: -0.5px; text-transform: uppercase;">
                    Registration Confirmed
                </h1>
                <p style="margin: 10px 0 0; color: #c7d2fe; font-size: 14px; letter-spacing: 2px; font-weight: 600;">
                    INDIA INTERNATIONAL TRAVEL MART
                </p>
            </div>

            <div style="padding: 40px 35px; color: #1e293b;">
                <h3 style="margin: 0 0 20px; font-size: 20px; color: #0f172a;">
                    Dear <span style="color: #4338ca;">{{ $dbData->name ?? 'Participant' }}</span>,
                </h3>

                <p style="font-size: 16px; line-height: 1.6; color: #475569; margin-bottom: 25px;">
                    We are pleased to confirm your participation in the **{{ $eventName }}**. Your profile has been
                    successfully processed for our upcoming event.
                </p>

                <div
                    style="background: #f1f5f9; border-radius: 12px; padding: 25px; margin-bottom: 25px; border: 1px solid #e2e8f0;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td
                                style="padding-bottom: 10px; font-size: 13px; color: #64748b; text-transform: uppercase; font-weight: 700; letter-spacing: 1px;">
                                Event Details</td>
                        </tr>
                        <tr>
                            <td style="font-size: 15px; color: #1e293b; line-height: 24px;">
                                <strong style="color: #4338ca;">📍 Venue:</strong> Bengaluru, India<br>
                                <strong style="color: #4338ca;">🗓️ Dates:</strong> 23 - 25 JULY 2026<br>
                                <strong style="color: #4338ca;">⚡ Status:</strong>
                                <span
                                    style="background: #dcfce7; color: #166534; padding: 2px 8px; border-radius: 4px; font-size: 12px; font-weight: 700; text-transform: uppercase;">
                                    {{ $status }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>

                <div style="text-align: center; margin: 35px 0;">
                    <a href="#"
                        style="background: #4338ca; color: #ffffff; padding: 16px 32px; text-decoration: none; border-radius: 8px; display: inline-block; font-weight: 700; font-size: 15px; box-shadow: 0 10px 15px -3px rgba(67, 56, 202, 0.4);">
                        DOWNLOAD ENTRY BADGE
                    </a>
                </div>

                <div
                    style="border-top: 1px solid #e2e8f0; padding-top: 25px; font-size: 14px; color: #64748b; line-height: 1.6;">
                    <p style="margin: 0 0 10px;"><strong>Important Notice:</strong> This is a strictly B2B event. Please
                        carry your business card and the printed badge for seamless entry.</p>
                    <p style="margin: 0;"><strong>Ref ID:</strong> #{{ rand(100000, 999999) }} | <strong>QR:</strong>
                        Syncing...</p>
                </div>

                <div style="margin-top: 40px; padding-top: 20px; border-top: 2px solid #f1f5f9;">
                    <p style="margin: 0; font-size: 14px; color: #1e293b;">
                        Best Regards,<br>
                        <strong style="font-size: 16px; color: #4338ca;">The IITM Organizing Team</strong>
                    </p>
                </div>
            </div>
        </div>

        <div style="text-align: center; padding: 0 20px 30px; color: #64748b; font-size: 12px;">
            <p>Need help? Contact us at support@iitmindia.com</p>
            <p style="margin-top: 10px;">&copy; 2026 India International Travel Mart. All rights reserved.</p>
        </div>
    </div>
</div>