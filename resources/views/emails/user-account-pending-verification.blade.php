<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account Pending Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #ffffff;
            padding: 30px;
            border: 1px solid #e9ecef;
        }
        .logo {
            display: block;
            max-width: 160px;
            height: auto;
            margin: 0 auto;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-radius: 0 0 8px 8px;
            font-size: 14px;
            color: #6c757d;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
        }
        .alert {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        {{-- <img class="logo" src="{{ asset('assets/images/l23-no-reply.png') }}" alt="{{ config('app.name') }} Logo"> --}}
    </div>

    <div class="content">
        <h2>Welcome {{ $user->name }}!</h2>

        <p>Your account has been successfully created. We're excited to have you join our community!</p>

        <div class="alert">
            <strong>Important:</strong> Your account is currently pending admin verification. You will not be able to log in until an administrator reviews and approves your account.
        </div>

        <p>Once your account is verified by our admin team, you will receive a confirmation email and will be able to access all features of the platform.</p>

        <p>We appreciate your patience during this verification process.</p>

        {{-- <p>If you did not sign up for this registration, please ignore this email and let us know by contacting on <a href="mailto:contact@locker23.com">contact@locker23.com</a>.</p> --}}

        <p>Best regards,<br>
        The Locker23 Team<br>
        {{-- <a href="https://www.locker23.com" target="_blank" rel="noopener">www.locker23.com</a></p> --}}
    </div>

    <div class="footer">
        <p>This is an automated message. Please do not reply to this email.</p>
        {{-- <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p> --}}
    </div>
</body>
</html>
