<?php

namespace App\Mail;

use App\Mail\Concerns\BuildsCiTenantEmail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TenantResetPasswordMail extends Mailable
{
    use BuildsCiTenantEmail, Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $resetLink,
    ) {}

    public function build(): static
    {
        return $this->buildCiTenantEmail('reset_password_link', [
            'USERNAME' => $this->user->name ?? $this->user->username ?? 'User',
            'RESET_LINK' => $this->resetLink,
        ]);
    }
}
