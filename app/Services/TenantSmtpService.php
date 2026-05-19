<?php

namespace App\Services;

use App\Models\SiteSetting;
use App\Models\TenantSmtpSetting;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;

class TenantSmtpService
{
    public const MAILER_NAME = 'tenant_smtp';

    public function settings(): ?TenantSmtpSetting
    {
        if (! tenant()) {
            return null;
        }

        return TenantSmtpSetting::query()->first();
    }

    public function isConfigured(): bool
    {
        $s = $this->settings();

        return $s
            && $s->smtp_host
            && $s->smtp_username
            && $s->smtp_password
            && $s->from_email;
    }

    public function isVerified(): bool
    {
        return (bool) $this->settings()?->is_verified;
    }

    /** Admin inbox for contact form, order alerts, etc. */
    public function adminInbox(): ?string
    {
        $site = SiteSetting::query()->first();

        return $site?->newuser_email
            ?? $site?->contactus_email
            ?? $site?->email;
    }

    public function mailerConfig(?array $overrides = null): array
    {
        $s = $this->settings();
        $data = $overrides ?? ($s ? [
            'smtp_host' => $s->smtp_host,
            'smtp_port' => $s->smtp_port,
            'smtp_encryption' => $s->smtp_encryption,
            'smtp_username' => $s->smtp_username,
            'smtp_password' => $overrides['smtp_password'] ?? $s->smtp_password,
            'from_email' => $s->from_email,
            'from_name' => $s->from_name,
        ] : []);

        $encryption = ($data['smtp_encryption'] ?? 'tls') === 'none' ? null : ($data['smtp_encryption'] ?? 'tls');

        return [
            'transport' => 'smtp',
            'host' => $data['smtp_host'] ?? '',
            'port' => (int) ($data['smtp_port'] ?? 587),
            'encryption' => $encryption,
            'username' => $data['smtp_username'] ?? '',
            'password' => $data['smtp_password'] ?? '',
            'timeout' => null,
            'local_domain' => parse_url((string) config('app.url'), PHP_URL_HOST),
        ];
    }

    public function registerMailer(?array $overrides = null): void
    {
        Config::set('mail.mailers.'.self::MAILER_NAME, $this->mailerConfig($overrides));
    }

    public function mailer(?array $overrides = null): Mailer
    {
        $this->registerMailer($overrides);

        return Mail::mailer(self::MAILER_NAME);
    }

    public function fromAddress(): string
    {
        return (string) ($this->settings()?->from_email ?? config('mail.from.address'));
    }

    public function fromName(): string
    {
        return (string) ($this->settings()?->from_name
            ?? tenant('company_name')
            ?? tenant('name')
            ?? 'Team Cabinets');
    }

    /**
     * Test SMTP using form input or saved settings. Does not send a real email unless $sendTestMail is true.
     */
    public function testConnection(array $input, bool $sendTestMail = false): array
    {
        $host = $input['smtp_host'] ?? '';
        $port = (int) ($input['smtp_port'] ?? 587);
        $encryption = ($input['smtp_encryption'] ?? 'tls') === 'none' ? null : ($input['smtp_encryption'] ?? 'tls');
        $username = $input['smtp_username'] ?? '';
        $password = $input['smtp_password'] ?? $this->settings()?->smtp_password ?? '';

        if ($password === '' || $password === null) {
            return ['success' => false, 'message' => 'SMTP password is required.'];
        }

        try {
            $transport = new EsmtpTransport($host, $port, $encryption === 'ssl');
            $transport->setUsername($username);
            $transport->setPassword($password);
            $transport->start();

            if ($sendTestMail && ! empty($input['from_email'])) {
                $this->registerMailer([
                    'smtp_host' => $host,
                    'smtp_port' => $port,
                    'smtp_encryption' => $input['smtp_encryption'] ?? 'tls',
                    'smtp_username' => $username,
                    'smtp_password' => $password,
                    'from_email' => $input['from_email'],
                    'from_name' => $input['from_name'] ?? 'SMTP Test',
                ]);

                $to = $input['test_recipient'] ?? $input['from_email'];
                $this->mailer()->raw('SMTP connection test successful for '.(tenant('name') ?? 'tenant').'.', function ($message) use ($input, $to) {
                    $message->from($input['from_email'], $input['from_name'] ?? 'Team Cabinets')
                        ->to($to)
                        ->subject('SMTP test — connection verified');
                });
            }

            return ['success' => true, 'message' => 'SMTP connection verified successfully.'];
        } catch (TransportExceptionInterface $e) {
            return ['success' => false, 'message' => 'SMTP failed: '.$e->getMessage()];
        } catch (\Throwable $e) {
            return ['success' => false, 'message' => 'Could not connect: '.$e->getMessage()];
        }
    }

    public function markVerified(): void
    {
        $s = $this->settings();
        if ($s) {
            $s->update(['is_verified' => true, 'verified_at' => now()]);
        }
    }
}
