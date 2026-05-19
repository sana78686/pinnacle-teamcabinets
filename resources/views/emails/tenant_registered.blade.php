<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Welcome to Pinnacle</title>
</head>
<body style="font-family: system-ui, sans-serif; font-size: 16px; line-height: 1.6; color: #334155;">
    <h1 style="color: #0c2340;">Welcome to Pinnacle</h1>
    <p>Dear {{ $tenant->name ?? $tenant->company_name }},</p>
    <p>Your cabinets business tenant has been created successfully. You can sign in to your management panel using the link below.</p>
    <ul>
        <li><strong>Company:</strong> {{ $tenant->company_name }}</li>
        <li><strong>Email:</strong> {{ $tenant->email }}</li>
        <li><strong>Your site:</strong> <a href="{{ $loginUrl }}">{{ $tenant->domain_name ?? $loginUrl }}</a></li>
    </ul>
    <p><a href="{{ $loginUrl }}" style="display:inline-block;padding:10px 20px;background:#0c2340;color:#fff;text-decoration:none;border-radius:999px;">Sign in to your tenant</a></p>
    <p>If you have any questions, contact our support team.</p>
    <p>Best regards,<br>The Pinnacle Team</p>
</body>
</html>
