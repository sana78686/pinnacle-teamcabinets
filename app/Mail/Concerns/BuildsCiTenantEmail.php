<?php

namespace App\Mail\Concerns;

use App\Services\TenantEmailService;

trait BuildsCiTenantEmail
{
    protected function buildCiTenantEmail(string $slug, array $macros, ?string $partial = null, array $partialData = []): static
    {
        $service = app(TenantEmailService::class);
        $rendered = $service->render($slug, $macros, $partial, $partialData);
        $mailable = $service->buildMailable($rendered['subject'], $rendered['html'], $rendered['branding']);

        $smtp = app(\App\Services\TenantSmtpService::class);
        if ($smtp->isConfigured()) {
            $smtp->registerMailer();

            return $this->mailer(\App\Services\TenantSmtpService::MAILER_NAME)
                ->subject($rendered['subject'])
                ->html($rendered['html'])
                ->from($mailable->fromAddress->address, $mailable->fromAddress->name)
                ->replyTo($mailable->replyToAddress->address, $mailable->replyToAddress->name);
        }

        return $this->mailer(config('mail.default'))
            ->subject($rendered['subject'])
            ->html($rendered['html'])
            ->from($mailable->fromAddress->address, $mailable->fromAddress->name)
            ->replyTo($mailable->replyToAddress->address, $mailable->replyToAddress->name);
    }
}
