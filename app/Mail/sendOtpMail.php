<?php

namespace App\Mail;

use App\Mail\Concerns\BuildsCiTenantEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendOtpMail extends Mailable
{
    use BuildsCiTenantEmail, Queueable, SerializesModels;

    public function __construct(
        public string $otp,
        public ?string $userName = null,
        public ?string $tenantName = null,
    ) {}

    public function build(): static
    {
        return $this->buildCiTenantEmail('login_otp', [
            'USERNAME' => $this->userName ?? 'User',
            'OTP' => $this->otp,
        ]);
    }
}
