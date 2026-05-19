<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TenantResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $resetLink;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $resetLink)
    {
        $this->user = $user;   // ✅ fixed $this->$user bug
        $this->resetLink = $resetLink;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset Your Password',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.tenant.reset-password',
            with: [
                'user' => $this->user,
                'resetLink' => $this->resetLink,
                'tenantName' => tenant('company_name') ?? tenant('name') ?? $this->user->company_name ?? config('app.name'),
            ],
        );
    }

    /**
     * Attachments (if any).
     */
    public function attachments(): array
    {
        return [];
    }
}
