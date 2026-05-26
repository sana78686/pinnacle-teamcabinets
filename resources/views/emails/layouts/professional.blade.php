@php
    $emailService = app(\App\Services\TenantEmailService::class);
    $branding = $branding ?? (tenant() ? $emailService->branding() : $emailService->centralBranding());
    $logoUrl = $logoUrl ?? $branding['logo_url'] ?? $emailService->logoUrl($branding['logo'] ?? null);
    $displayName = $branding['brand_name'] ?? config('pinnacle.name', config('app.name'));
    $businessName = $branding['tenant_business_name'] ?? $displayName;
    $accent = $accentColor ?? '#398ebd';
    $pageTitle = $title ?? $heading ?? $businessName;
    $footerName = $footerBrand ?? $businessName;
    $showPoweredBy = $showPoweredBy ?? ! empty($branding['uses_pinnacle_logo']);
    $simpleHeader = $simpleHeader ?? ! empty($heading);
@endphp
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{ $pageTitle }}</title>
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
</head>
<body style="margin:0;padding:0;background-color:#f4f6f8;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;font-size:15px;line-height:1.6;color:#1e293b;-webkit-text-size-adjust:100%;">
@if(!empty($preheader))
    <div style="display:none;max-height:0;overflow:hidden;mso-hide:all;font-size:1px;line-height:1px;color:#f4f6f8;">{{ \Illuminate\Support\Str::limit(strip_tags($preheader), 140) }}</div>
@endif
<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#f4f6f8;">
    <tr>
        <td align="center" style="padding:24px 12px;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" style="max-width:600px;width:100%;border-collapse:collapse;background-color:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 1px 3px rgba(15,23,42,0.08);">
                {{-- Top accent bar --}}
                <tr>
                    <td height="4" style="background-color:{{ $accent }};font-size:0;line-height:0;">&nbsp;</td>
                </tr>
                @if($simpleHeader)
                    <tr>
                        <td style="padding:28px 32px 8px;background-color:#ffffff;">
                            <p style="margin:0;font-size:22px;font-weight:700;color:#0f172a;line-height:1.3;">{{ $heading }}</p>
                            @if(!empty($subheading))
                                <p style="margin:8px 0 0;font-size:14px;color:#64748b;">{{ $subheading }}</p>
                            @endif
                        </td>
                    </tr>
                @else
                    <tr>
                        <td style="padding:24px 28px 16px;background-color:#ffffff;border-bottom:1px solid #e2e8f0;">
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td valign="top" style="width:38%;padding-right:12px;">
                                        <p style="margin:0 0 4px;font-size:17px;font-weight:700;color:#0f172a;">{{ $displayName }}</p>
                                        @if(!empty($branding['tagline']))
                                            <p style="margin:0 0 10px;font-size:12px;line-height:1.45;color:#64748b;">{{ $branding['tagline'] }}</p>
                                        @endif
                                        @if(!empty($branding['address_line']))
                                            <p style="margin:0;font-size:12px;line-height:1.5;color:#475569;">{!! nl2br(e($branding['address_line'])) !!}</p>
                                        @endif
                                        @if(!empty($branding['phone']))
                                            <p style="margin:6px 0 0;font-size:12px;color:#475569;">{{ $branding['phone'] }}</p>
                                        @endif
                                    </td>
                                    <td valign="middle" align="center" style="width:24%;padding:0 8px;">
                                        <img src="{{ $logoUrl }}" alt="{{ $businessName }}" width="120" style="display:block;max-width:120px;width:120px;height:auto;margin:0 auto;border:0;" />
                                    </td>
                                    <td valign="top" align="right" style="width:38%;padding-left:12px;font-size:12px;line-height:1.5;color:#475569;">
                                        @if(!empty($branding['email']))
                                            <p style="margin:0 0 6px;"><a href="mailto:{{ $branding['email'] }}" style="color:{{ $accent }};text-decoration:none;">{{ $branding['email'] }}</a></p>
                                        @endif
                                        @if(!empty($branding['website']))
                                            <p style="margin:0;"><a href="{{ $branding['website'] }}" style="color:{{ $accent }};text-decoration:none;">{{ $branding['website_label'] ?? $branding['website'] }}</a></p>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                @endif
                <tr>
                    <td class="email-content" style="padding:{{ $simpleHeader ? '8px 32px 32px' : '24px 28px 28px' }};font-size:15px;line-height:1.65;color:#334155;">
                        @isset($bodyHtml)
                            {!! $bodyHtml !!}
                        @else
                            @yield('content')
                        @endisset
                    </td>
                </tr>
                <tr>
                    <td style="padding:16px 28px;background-color:#f8fafc;border-top:1px solid #e2e8f0;text-align:center;">
                        <p style="margin:0;font-size:12px;line-height:1.5;color:#64748b;">
                            &copy; {{ now()->year }} {{ $footerName }}. All rights reserved.
                        </p>
                        @if($showPoweredBy)
                            <p style="margin:6px 0 0;font-size:11px;color:#94a3b8;">
                                Powered by {{ config('pinnacle.name', 'Pinnacle') }}
                            </p>
                        @endif
                        @if(!empty($footerNote))
                            <p style="margin:8px 0 0;font-size:11px;color:#94a3b8;">{{ $footerNote }}</p>
                        @endif
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
