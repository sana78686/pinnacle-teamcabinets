<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account Verified Successfully</title>
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
            text-align: center;
            padding: 10px 0 20px 0;
        }
        .content {
            background-color: #ffffff;
            padding: 30px;
            border: 1px solid #e9ecef;
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
            background-color: #1e758d;
            color: white !important;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
        }
        .logo {
            max-width: 180px;
            height: auto;
        }
        p { margin: 0 0 14px 0; }
    </style>
</head>
<body>
    <div class="header">
        {{-- <img src="{{ asset('assets/images/l23-no-reply.png') }}" alt="Locker23" class="logo"> --}}
    </div>

    <div class="content">
        <h2>Congratulations {{ $user->name }} !</h2>

        <p><strong>Great News!</strong></p>

        <p>Your account has been successfully verified by our admin team.</p>

        <p>You can now log in to your account and access all the features of our platform.</p>

        <p>Remember to click the toggle to “live” on your dashboard home page to let all members see your profile.</p>

        <p>We're excited to have you as part of our community and look forward to seeing what you'll accomplish!</p>

        <div style="text-align: center;">
            {{-- <a href="http://3.8.192.174/login" class="btn text-white">Login to Your Account</a> --}}
            <div>
                {{-- <small>Or copy and paste this link into your browser:<br>http://3.8.192.174/login</small> --}}
            </div>
        </div>

        <p>If you have any questions or need assistance, please don't hesitate to contact our support team via the support ticket function once you log in.</p>

        <p>Best regards,<br>
        {{-- The Locker23 Team<br>
        www.locker23.com</p> --}}
    </div>

    <div class="footer">
        <p>This is an automated message. Please do not reply to this email.</p>
        <p>&copy; {{ date('Y') }} Locker23. All rights reserved.</p>
    </div>
</body>
</html>
