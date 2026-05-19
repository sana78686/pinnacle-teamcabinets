@php
    $emailService = app(\App\Services\TenantEmailService::class);
    $branding = $branding ?? $emailService->branding();
    $brand = $branding['brand_name'];
    $tenantName = $brand;
@endphp
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{{ $title ?? $tenantName }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin:0;padding:0;font-family:Arial,sans-serif;font-size:14px;color:#333;">
@if(!empty($preheader))
    <div style="display:none;max-height:0;overflow:hidden;mso-hide:all;">{{ \Illuminate\Support\Str::limit(strip_tags($preheader), 120) }}</div>
@endif
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td style="padding:10px 0 30px 0;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="max-width:100%;border:1px solid #cccccc;border-top:3px solid #398ebd;border-collapse:collapse;">
                <tr>
                    <td bgcolor="#ffffff" style="padding:20px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="width:35%;vertical-align:top;">
                                    <p style="margin:0 0 8px;font-size:18px;font-weight:bold;color:#000;">{{ $brand }}</p>
                                    <p style="margin:0;font-size:13px;line-height:20px;color:#153643;">
                                        {!! nl2br(e($branding['address_line'])) !!}<br>
                                        {{ $branding['phone'] }}
                                    </p>
                                </td>
                                <td style="width:30%;text-align:center;vertical-align:top;">
                                    <img src="{{ $emailService->logoUrl($branding['logo']) }}" alt="{{ $tenantName }}" width="130" style="max-width:130px;height:auto;" />
                                </td>
                                <td style="width:35%;vertical-align:top;text-align:right;font-size:13px;line-height:20px;color:#153643;">
                                    <p style="margin:0 0 8px;"><a href="mailto:{{ $branding['email'] }}" style="color:#222;">{{ $branding['email'] }}</a></p>
                                    <p style="margin:0;"><a href="{{ $branding['website'] }}" style="color:#222;">{{ parse_url($branding['website'], PHP_URL_HOST) ?: $branding['website'] }}</a></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="padding-top:20px;font-size:14px;line-height:1.6;color:#333;">
                                    {!! $bodyHtml !!}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding:12px 20px;background:#f5f5f5;border-top:1px solid #e2e8f0;font-size:12px;color:#666;text-align:center;">
                        &copy; {{ now()->year }} {{ $tenantName }}. All rights reserved.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
