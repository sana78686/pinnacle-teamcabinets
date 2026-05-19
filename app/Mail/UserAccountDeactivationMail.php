<?php

namespace App\Mail;

use App\Mail\Concerns\BuildsCiTenantEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserAccountDeactivationMail extends Mailable
{
    use BuildsCiTenantEmail, Queueable, SerializesModels;

    public function __construct(public $user) {}

    public function build(): static
    {
        return $this->buildCiTenantEmail('user_deactivated', [
            'USERNAME' => $this->user->name ?? $this->user->username ?? 'User',
        ]);
    }
}
