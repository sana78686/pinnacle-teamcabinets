<?php

namespace App\Mail;

use App\Mail\Concerns\BuildsCiTenantEmail;
use App\Models\ManageEmailsContent;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ShippingQuoteRequestMail extends Mailable
{
    use BuildsCiTenantEmail, Queueable, SerializesModels;

    public function __construct(
        public string $userName,
        public string $jobName,
    ) {}

    public function build(): static
    {
        return $this->buildCiTenantEmail(ManageEmailsContent::SLUG_SHIPPING_USER, [
            'USERNAME' => $this->userName,
            'CONTENT' => 'Your shipping quote request for job <strong>'.e($this->jobName).'</strong> was received.',
        ]);
    }
}
