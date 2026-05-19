<?php

namespace App\Services;

use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Mail;

class CentralMailService
{
    /** SMTP mailer name for Pinnacle / super-admin. */
    public function mailerName(): string
    {
        return (string) config('mail.central_mailer', 'central');
    }

    public function mailer(): Mailer
    {
        return Mail::mailer($this->mailerName());
    }

    public function fromAddress(): string
    {
        return (string) config('mail.central_from.address');
    }

    public function fromName(): string
    {
        return (string) config('mail.central_from.name', config('pinnacle.name', 'Pinnacle'));
    }

    public function superadminRecipient(): ?string
    {
        $email = config('mail.superadmin');

        return $email ? (string) $email : null;
    }

    public function send(Mailable $mailable, string|array $to): void
    {
        $mailable->from($this->fromAddress(), $this->fromName());

        $reply = config('mail.reply_to.address');
        if ($reply) {
            $mailable->replyTo($reply, config('mail.reply_to.name'));
        }

        $this->mailer()->to($to)->send($mailable);
    }
}
