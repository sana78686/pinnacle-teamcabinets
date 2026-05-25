<?php

namespace App\Services;

use App\Mail\TenantManagedEmail;
use App\Models\ManageEmailsContent;
use App\Models\SiteSetting;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class TenantEmailService
{
    /**
     * Branding for tenant emails: logo + name from Site Settings, else static Pinnacle logo.
     */
    public function branding(): array
    {
        $settings = tenant() ? SiteSetting::query()->first() : null;
        $tenantId = tenant('id');
        $business = $this->tenantBusinessName();
        $pinnacleName = (string) config('pinnacle.name', 'Pinnacle');

        $hasTenantLogo = filled($settings?->logo);
        $logoPath = $hasTenantLogo
            ? $settings->logo
            : (string) config('pinnacle.email.logo', 'assets/logo/pinnacle-tenant.png');

        $usesPinnacleLogo = ! $hasTenantLogo;
        $brandName = $usesPinnacleLogo ? $pinnacleName : $business;
        $websiteUrl = $tenantId ? tenant_url($tenantId) : central_url();
        $websiteHost = parse_url($websiteUrl, PHP_URL_HOST) ?: $websiteUrl;

        $replyEmail = $settings?->email
            ?? $settings?->contactus_email
            ?? config('mail.from.address');

        return [
            'brand_name' => $brandName,
            'tenant_business_name' => $business,
            'tagline' => $usesPinnacleLogo
                ? 'Your cabinets website — '.$business
                : $business,
            'address_line' => $settings?->address,
            'phone' => $settings?->phone,
            'email' => $replyEmail,
            'website' => $websiteUrl,
            'website_label' => $websiteHost,
            'logo' => $logoPath,
            'logo_url' => $this->logoUrl($logoPath),
            'uses_pinnacle_logo' => $usesPinnacleLogo,
        ];
    }

    /** @return array<string, string> */
    public function defaultMacros(?array $branding = null): array
    {
        $branding ??= $this->branding();

        return [
            'TENANT_NAME' => $branding['tenant_business_name'] ?? '',
            'COMPANY_NAME' => $branding['tenant_business_name'] ?? '',
            'BRAND_TAGLINE' => $branding['tagline'] ?? '',
            'WEBSITE' => $branding['website_label'] ?? '',
            'WEBSITE_URL' => $branding['website'] ?? '',
        ];
    }

    public function render(string $slug, array $macros = [], ?string $partial = null, array $partialData = []): array
    {
        $template = ManageEmailsContent::findBySlug($slug);

        if (! $template) {
            throw new \InvalidArgumentException("Email template not found: {$slug}");
        }

        $branding = $this->branding();
        $macros = array_merge($this->defaultMacros($branding), $macros);

        $contentHtml = $this->replaceMacros($template->email_content, $macros);

        if ($partial) {
            $partialKey = config("tenant_email.partials.{$partial}", $partial);
            $partialHtml = View::make($partialKey, $partialData)->render();
            $contentHtml = $this->replaceMacros($contentHtml, array_merge($macros, ['CONTENT' => $partialHtml]));
        }

        $subject = $this->replaceMacros($template->email_subject, $macros);

        $html = View::make('emails.tenant.ci.layout', [
            'bodyHtml' => $contentHtml,
            'title' => $subject,
            'branding' => $branding,
            'preheader' => $this->replaceMacros(strip_tags($contentHtml), $macros),
        ])->render();

        return [
            'subject' => $subject,
            'html' => $html,
            'template' => $template,
            'branding' => $branding,
        ];
    }

    public function send(string $slug, string $to, array $macros = [], ?string $partial = null, array $partialData = []): void
    {
        $rendered = $this->render($slug, $macros, $partial, $partialData);
        $mailable = $this->buildMailable($rendered['subject'], $rendered['html'], $rendered['branding']);

        $this->dispatch($mailable, $to);
    }

    public function sendToAdmin(string $slug, array $macros = [], ?string $partial = null, array $partialData = []): void
    {
        $adminEmail = app(TenantSmtpService::class)->adminInbox();
        if ($adminEmail) {
            $this->send($slug, $adminEmail, $macros, $partial, $partialData);
        }
    }

    public function tenantBusinessName(): string
    {
        return (string) (tenant('company_name') ?? tenant('name') ?? 'Team Cabinets');
    }

    /**
     * From display name: tenant SMTP → business name only; platform mail → "Pinnacle - {business}".
     */
    public function fromSenderName(bool $viaTenantSmtp): string
    {
        $business = $this->tenantBusinessName();

        if ($viaTenantSmtp) {
            return $business;
        }

        $pinnacle = (string) config('pinnacle.name', 'Pinnacle');

        return $pinnacle.' - '.$business;
    }

    /**
     * From: tenant SMTP if configured, else platform no-reply (MAIL_FROM_*).
     * Reply-To: tenant contact email (reduces spam flags vs bare no-reply).
     */
    public function buildMailable(string $subject, string $html, ?array $branding = null): TenantManagedEmail
    {
        $branding ??= $this->branding();
        $smtp = app(TenantSmtpService::class);
        $business = $branding['tenant_business_name'] ?? $this->tenantBusinessName();

        if ($smtp->isConfigured()) {
            $smtp->registerMailer();
            $from = new Address($smtp->fromAddress(), $this->fromSenderName(true));
        } else {
            $from = new Address(
                (string) config('mail.from.address'),
                $this->fromSenderName(false)
            );
        }

        $replyTo = new Address(
            $branding['email'],
            $business
        );

        return new TenantManagedEmail($subject, $html, $from, $replyTo);
    }

    protected function dispatch(TenantManagedEmail $mailable, string|array $to): void
    {
        $smtp = app(TenantSmtpService::class);

        if ($smtp->isConfigured()) {
            $smtp->mailer()->to($to)->send($mailable);
        } else {
            Mail::mailer(config('mail.default'))->to($to)->send($mailable);
        }
    }

    public function replaceMacros(string $text, array $macros): string
    {
        foreach ($macros as $key => $value) {
            $placeholder = str_starts_with((string) $key, '{') ? $key : '{'.$key.'}';
            $text = str_replace($placeholder, (string) $value, $text);
        }

        return $text;
    }

    /** Absolute URL so email clients load the logo (required for deliverability). */
    public function logoUrl(?string $logoPath = null): string
    {
        if ($logoPath === null && tenant() && function_exists('tenant_brand_logo_url')) {
            return tenant_brand_logo_url();
        }

        $path = $logoPath ?? $this->branding()['logo'];

        if (str_starts_with((string) $path, 'http://') || str_starts_with((string) $path, 'https://')) {
            return $path;
        }

        $relative = function_exists('dynamic_url')
            ? dynamic_url(ltrim((string) $path, '/'))
            : asset(ltrim((string) $path, '/'));

        if (str_starts_with($relative, 'http://') || str_starts_with($relative, 'https://')) {
            return $relative;
        }

        return url($relative);
    }
}
