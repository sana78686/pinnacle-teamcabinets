<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }} - Account Deactivated</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 40px;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 6px; overflow: hidden;">

                    {{-- Header --}}
                    <tr>
                        <td align="center" style="background-color: #dc3545; padding: 20px;">
                            <img src="{{ asset('logo/pinnacle-tenant.png') }}" alt="Pinnacle Logo" height="40">
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding: 30px;">
                            <h2 style="color: #333;">Hello {{ $user->name }},</h2>

                            <p style="font-size: 16px; color: #333;">
                                We wanted to inform you that your account on <strong>{{ config('app.name') }}</strong> has been <strong>deactivated</strong> by the administrator.
                            </p>

                            <p style="font-size: 16px; color: #333;">
                                This means you will no longer be able to log in or access your account until it is reactivated.
                            </p>

                            <p style="font-size: 16px; color: #333;">
                                If you believe this was a mistake or wish to appeal this decision, please contact our support team for assistance.
                            </p>

                            <p style="text-align: center; margin: 30px 0;">
                                <a href="{{ url('/') }}" style="background-color: #dc3545; color: white; padding: 12px 24px; text-decoration: none; border-radius: 4px; display: inline-block;">
                                    Contact Support
                                </a>
                            </p>

                            <p style="font-size: 16px; color: #333;">
                                Thank you for your understanding,<br>
                                The <strong>{{ config('app.name') }}</strong> Team
                            </p>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="padding: 20px; font-size: 12px; color: #666; text-align: center; background-color: #f9f9f9;">
                            This is an automated message from {{ config('app.name') }}. Please do not reply.<br><br>
                            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
