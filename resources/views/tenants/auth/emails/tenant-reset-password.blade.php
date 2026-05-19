<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset Request</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f9f9f9; padding:20px; margin:0;">

    <table width="100%" cellpadding="0" cellspacing="0" 
           style="max-width:600px; margin:0 auto; background:#ffffff; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
        <tr>
            <td style="padding:20px; text-align:center; background:#4CAF50; color:#ffffff; border-top-left-radius:8px; border-top-right-radius:8px;">
                <h2 style="margin:0;">{{ config('app.name') }}</h2>
            </td>
        </tr>

        <tr>
            <td style="padding:30px;">
                <p style="font-size:16px; color:#333;">Hello {{ $user->name }},</p>

                <p style="font-size:14px; color:#555;">
                    We received a request to reset your password for your account on 
                    <strong>{{ parse_url($resetLink, PHP_URL_HOST) }}</strong>.
                </p>

                <p style="text-align:center; margin:30px 0;">
                    <a href="{{ $resetLink }}" 
                       style="background:#4CAF50; color:#ffffff; text-decoration:none; padding:12px 20px; border-radius:5px; font-weight:bold; display:inline-block;">
                        Reset Your Password
                    </a>
                </p>

                <p style="font-size:14px; color:#555;">
                    This password reset link will expire in <strong>60 minutes</strong>.
                    If you did not request a password reset, please ignore this email.
                </p>

                <p style="font-size:14px; color:#555;">
                    Thanks,<br>
                    The {{ config('app.name') }} Team
                </p>
            </td>
        </tr>

        <tr>
            <td style="padding:15px; text-align:center; font-size:12px; color:#999; background:#f1f1f1; border-bottom-left-radius:8px; border-bottom-right-radius:8px;">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </td>
        </tr>
    </table>

</body>
</html>
