<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TenantForgotUsernameMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $tenantName,
        public ?string $tenantId = null,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your '.$this->tenantName.' username',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.tenant.forgot-username',
            with: [
                'user' => $this->user,
                'tenantName' => $this->tenantName,
                'loginUrl' => tenant_url($this->tenantId ?? tenant('id') ?? $this->user->tenant_id, 'login'),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
