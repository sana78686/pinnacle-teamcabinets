<?php

namespace App\Mail;

use App\Mail\Concerns\BuildsCiTenantEmail;
use App\Models\ManageEmailsContent;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuoteSavedMail extends Mailable
{
    use BuildsCiTenantEmail, Queueable, SerializesModels;

    public function __construct(
        public string $userName,
        public string $quoteName,
    ) {}

    public function build(): static
    {
        return $this->buildCiTenantEmail(ManageEmailsContent::SLUG_ORDER_USER, [
            'USERNAME' => $this->userName,
            'CONTENT' => 'Your quote <strong>'.e($this->quoteName).'</strong> has been saved.',
        ]);
    }
}
