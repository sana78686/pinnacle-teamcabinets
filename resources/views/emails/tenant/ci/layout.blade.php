@php
    $emailService = app(\App\Services\TenantEmailService::class);
    $branding = $branding ?? $emailService->branding();
    $logoUrl = $branding['logo_url'] ?? $emailService->logoUrl($branding['logo'] ?? null);
    $displayName = $branding['brand_name'] ?? config('app.name');
    $businessName = $branding['tenant_business_name'] ?? $displayName;
@endphp
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{{ $title ?? $businessName }}</title>
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
                                    <p style="margin:0 0 4px;font-size:18px;font-weight:bold;color:#000;">{{ $displayName }}</p>
                                    @if(!empty($branding['uses_pinnacle_logo']) && !empty($branding['tagline']))
                                        <p style="margin:0 0 8px;font-size:12px;line-height:1.4;color:#64748b;">{{ $branding['tagline'] }}</p>
                                    @elseif(!empty($branding['uses_pinnacle_logo']))
                                        <p style="margin:0 0 8px;font-size:12px;line-height:1.4;color:#64748b;">Your cabinets website — {{ $businessName }}</p>
                                    @endif
                                    @if(!empty($branding['address_line']))
                                        <p style="margin:0;font-size:13px;line-height:20px;color:#153643;">
                                            {!! nl2br(e($branding['address_line'])) !!}
                                        </p>
                                    @endif
                                    @if(!empty($branding['phone']))
                                        <p style="margin:4px 0 0;font-size:13px;color:#153643;">{{ $branding['phone'] }}</p>
                                    @endif
                                </td>
                                <td style="width:30%;text-align:center;vertical-align:top;">
                                    <img src="{{ $logoUrl }}" alt="{{ $businessName }}" width="130" style="max-width:130px;height:auto;display:block;margin:0 auto;" />
                                </td>
                                <td style="width:35%;vertical-align:top;text-align:right;font-size:13px;line-height:20px;color:#153643;">
                                    @if(!empty($branding['email']))
                                        <p style="margin:0 0 8px;"><a href="mailto:{{ $branding['email'] }}" style="color:#222;">{{ $branding['email'] }}</a></p>
                                    @endif
                                    @if(!empty($branding['website']))
                                        <p style="margin:0;"><a href="{{ $branding['website'] }}" style="color:#222;">{{ $branding['website_label'] ?? $branding['website'] }}</a></p>
                                    @endif
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
                        &copy; {{ now()->year }} {{ $businessName }}. All rights reserved.
                        @if(!empty($branding['uses_pinnacle_logo']))
                            <span style="display:block;margin-top:4px;font-size:11px;color:#94a3b8;">Powered by {{ config('pinnacle.name', 'Pinnacle') }}</span>
                        @endif
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
