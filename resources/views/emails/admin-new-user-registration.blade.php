<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }} - New User Registration</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 40px;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 6px; overflow: hidden;">

                    {{-- Header --}}
                    <tr>
                        <td align="center" style="background-color: #dc3545; padding: 20px;">
                            @php
                                $settings = \App\Models\Setting::first();
                            @endphp
                            @if($settings && $settings->logo)
                                <img src="{{ asset($settings->logo) }}" alt="{{ config('app.name') }} Logo" height="40">
                            @else
                                <h2 style="color: #ffffff; margin: 0;">{{ config('app.name') }}</h2>
                            @endif
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding: 30px;">
                            <h2 style="color: #333; margin-top: 0;">New User Registration Awaiting Approval</h2>

                            <p style="font-size: 16px; color: #333;">
                                A new user has just registered on <strong>{{ config('app.name') }}</strong> and is currently pending admin verification.
                            </p>

                            <table width="100%" cellpadding="8" cellspacing="0" style="background-color: #f9f9f9; border-radius: 4px; margin: 20px 0;">
                                <tr>
                                    <td><strong>Name:</strong></td>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>User Type:</strong></td>
                                    <td>{{ ucfirst($user->role) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Registration Date:</strong></td>
                                    <td>{{ $user->created_at->format('M d, Y H:i:s') }}</td>
                                </tr>
                            </table>

                            <p style="font-size: 16px; color: #333;">
                                Please review this user's details and verify their account to grant them access to the platform.
                            </p>

                            <p style="text-align: center; margin: 30px 0;">
                                <a href="{{ url('/admin/users') }}" style="background-color: #007bff; color: white; padding: 12px 24px; text-decoration: none; border-radius: 4px; display: inline-block;">
                                    Review User
                                </a>
                            </p>

                            <p style="font-size: 16px; color: #333;">
                                Best regards,<br>
                                The <strong>{{ config('app.name') }}</strong> System
                            </p>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="padding: 20px; font-size: 12px; color: #666; text-align: center; background-color: #f9f9f9;">
                            This is an automated notification from {{ config('app.name') }}. Please do not reply.<br><br>
                            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
