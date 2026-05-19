@php
    $brandName = $tenantName ?? tenant('company_name') ?? tenant('name') ?? config('app.name');
    $heading = $heading ?? $brandName;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $subjectLine ?? $heading }}</title>
</head>
<body style="margin:0;padding:0;font-family:system-ui,-apple-system,'Segoe UI',Roboto,sans-serif;font-size:16px;line-height:1.6;color:#334155;background:#f7f5f0;">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;margin:24px auto;background:#ffffff;border-radius:12px;border:1px solid #e2e8f0;overflow:hidden;">
        <tr>
            <td style="padding:24px 28px;background:#0c2340;color:#ffffff;">
                <h1 style="margin:0;font-size:20px;font-weight:700;">{{ $heading }}</h1>
                @if(!empty($subheading))
                    <p style="margin:8px 0 0;font-size:14px;opacity:0.9;">{{ $subheading }}</p>
                @endif
            </td>
        </tr>
        <tr>
            <td style="padding:28px;">
                @yield('body')
            </td>
        </tr>
        <tr>
            <td style="padding:16px 28px;background:#f8fafc;border-top:1px solid #e2e8f0;font-size:14px;color:#64748b;text-align:center;">
                &copy; {{ now()->year }} {{ $brandName }}. All rights reserved.
            </td>
        </tr>
    </table>
</body>
</html>
