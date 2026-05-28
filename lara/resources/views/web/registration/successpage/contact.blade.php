<table width="90%" border="0" cellpadding="0" cellspacing="0" align="center"
    style="margin: 0 auto; border: 1px solid #f0f0f0; border-radius: 8px; font-family: 'Georgia', serif; color: #333333;">
    <tr>
        <td style="padding: 25px;">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="60%" valign="top" style="text-align: left;">
                        <h2
                            style="margin: 0 0 15px 0; color: #aa2324; font-size: 22px; text-transform: uppercase; letter-spacing: 1px; font-weight: bold;">
                            {{ $data['contactName'] }}
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
                        <table border="0" cellpadding="0" cellspacing="0" align="center">
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