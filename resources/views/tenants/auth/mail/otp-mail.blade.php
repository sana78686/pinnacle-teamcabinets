<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
</head>
<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color:#f4f4f4;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" 
           style="border-collapse: collapse; background-color:#ffffff; box-shadow:0 4px 8px rgba(0,0,0,0.1);">
        <tr>
            <td align="center" bgcolor="#4a90e2" style="padding: 30px 20px;">
                <h1 style="margin:0; font-size:24px; color:#ffffff;">Your OTP Code</h1>
            </td>
        </tr>
        <tr>
            <td style="padding: 40px 30px; color:#333333; font-size:16px; line-height:1.5;">
                <p>Hello,</p>
                <p>We received a request to verify your login. Please use the OTP code below to complete the process:</p>

                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin:20px 0;">
                    <tr>
                        <td align="center" 
                            style="font-size:24px; font-weight:bold; color:#4a90e2; border:2px dashed #4a90e2; padding:15px;">
                            {{ $otp }}
                        </td>
                    </tr>
                </table>

                <p>This OTP will expire in <strong>10 minutes</strong>. If you did not request this, you can ignore this email.</p>
                <p>Thank you,<br>The Support Team</p>
            </td>
        </tr>
        <tr>
            <td align="center" bgcolor="#f4f4f4" style="padding: 20px; font-size:12px; color:#777777;">
                © {{ date('Y') }} Your Company. All rights reserved.
            </td>
        </tr>
    </table>
</body>
</html>
