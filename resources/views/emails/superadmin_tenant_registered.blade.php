<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>New tenant registered</title>
</head>
<body style="font-family: system-ui, sans-serif; font-size: 16px; line-height: 1.6; color: #334155;">
    <h1 style="color: #0c2340;">New tenant registered</h1>
    <p>Hello,</p>
    <p>A new tenant has registered on the Pinnacle platform:</p>
    <ul>
        <li><strong>Company:</strong> {{ $tenant->company_name }}</li>
        <li><strong>Contact:</strong> {{ $tenant->name }}</li>
        <li><strong>Email:</strong> {{ $tenant->email }}</li>
        <li><strong>Username:</strong> {{ $tenant->username }}</li>
        <li><strong>Domain:</strong> {{ $tenant->domain_name }}</li>
        <li><strong>Phone:</strong> {{ $tenant->phone ?? '—' }}</li>
    </ul>
    <p><a href="{{ $loginUrl }}">Open tenant login</a></p>
    <p>— Pinnacle System</p>
</body>
</html>
