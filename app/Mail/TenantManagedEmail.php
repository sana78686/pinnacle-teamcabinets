<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;

class TenantManagedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $mailSubject,
        public string $htmlBody,
        public ?Address $fromAddress = null,
        public ?Address $replyToAddress = null,
    ) {}

    public function envelope(): Envelope
    {
        $envelope = new Envelope(
            subject: $this->mailSubject,
            from: $this->fromAddress,
        );

        if ($this->replyToAddress) {
            $envelope->replyTo = [$this->replyToAddress];
        }

        return $envelope;
    }

    public function headers(): Headers
    {
        return new Headers(
            text: [
                'X-Priority' => '3',
                'X-MSMail-Priority' => 'Normal',
            ],
        );
    }

    public function content(): Content
    {
        return new Content(htmlString: $this->htmlBody);
    }
}
