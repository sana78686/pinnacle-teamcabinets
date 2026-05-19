<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Password Changed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9fafb;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        h2 {
            color: #111827;
        }
        p {
            color: #374151;
            line-height: 1.5;
        }
        .btn {
            display: inline-block;
            background: #2563eb;
            color: #ffffff !important;
            padding: 10px 20px;
            margin-top: 15px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
        }
        .footer {
            margin-top: 20px;
            font-size: 13px;
            color: #6b7280;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Password Changed Successfully</h2>
        <p>Hi {{ $user->name }},</p>
        <p>Your password was successfully changed on <strong>{{ $changedAt }}</strong>.</p>
        <p>If this was you, no further action is required.</p>
        <p>If you didn’t make this change, please reset your password immediately:</p>
        <a href="{{ url('/forgot-password') }}" class="btn">Reset Password</a>
        <p class="footer">Thanks,<br>{{ config('app.name') }}</p>
    </div>
</body>
</html>
