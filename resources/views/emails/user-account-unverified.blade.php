<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 40px;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 6px; overflow: hidden;">
                    {{-- Header --}}
                    <tr>
                        <td align="center" style="background-color: #dc3545; padding: 20px;">
                            <img src="{{ asset('assets/logo/pinnacle-tenant.png') }}" alt="Pinnacle Logo" height="40">
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding: 30px;">
                            <h2 style="color: #333;">Hello {{ $user->name }},</h2>

                            <p style="font-size: 16px; color: #333;">
                                Thank you for registering on <strong>{{ config('app.name') }}</strong>.
                            </p>

                            <p style="font-size: 16px; color: #333;">
                                Your account is currently <strong>unverified</strong> and requires administrator approval before you can access the platform.
                            </p>

                            <p style="font-size: 16px; color: #333;">
                                We will notify you once your account is verified. If you have any questions or believe this is a mistake, please reach out to our support team.
                            </p>

                            <p style="text-align: center; margin: 30px 0;">
                                <a href="{{ url('/') }}" style="background-color: #dc3545; color: white; padding: 12px 24px; text-decoration: none; border-radius: 4px; display: inline-block;">
                                    Visit {{ config('app.name') }}
                                </a>
                            </p>

                            <p style="font-size: 16px; color: #333;">
                                Thank you for your patience,<br>
                                The {{ config('app.name') }} Team
                            </p>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="padding: 20px; font-size: 12px; color: #666; text-align: center; background-color: #f9f9f9;">
                            This is an automated message from {{ config('app.name') }}. Please do not reply.
                            <br><br>
                            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
