<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }} - Account Activated</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 40px;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 6px; overflow: hidden;">

                    {{-- Header --}}
                    <tr>
                        <td align="center" style="background-color: #28a745; padding: 20px;">
                            <img src="{{ asset('assets/logo/pinnacle-tenant.png') }}" alt="Pinnacle Logo" height="40">
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding: 30px;">
                            <h2 style="color: #333;">Welcome, {{ $user->name }}!</h2>

                            <p style="font-size: 16px; color: #333;">
                                Great news — your account on <strong>{{ config('app.name') }}</strong> has been <strong>activated and verified</strong> by our team.
                            </p>

                            <p style="font-size: 16px; color: #333;">
                                You can now log in and start using all the features available to your account.
                            </p>

                            <p style="text-align: center; margin: 30px 0;">
                                <a href="{{ route('tenant_login') }}" style="background-color: #28a745; color: white; padding: 12px 24px; text-decoration: none; border-radius: 4px; display: inline-block;">
                                    Login to Your Account
                                </a>
                            </p>

                            <p style="font-size: 16px; color: #333;">
                                If you didn’t request this account or believe this was sent in error, please contact our support team immediately.
                            </p>

                            <p style="font-size: 16px; color: #333;">
                                Welcome aboard,<br>
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
