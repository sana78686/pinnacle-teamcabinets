<?php

namespace App\Mail;

use App\Mail\Concerns\BuildsCiTenantEmail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TenantForgotUsernameMail extends Mailable
{
    use BuildsCiTenantEmail, Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $tenantName,
        public ?string $tenantId = null,
    ) {}

    public function build(): static
    {
        $loginUrl = tenant_url($this->tenantId ?? tenant('id') ?? $this->user->tenant_id, 'login');

        return $this->buildCiTenantEmail('forgot_username', [
            'USERNAME' => $this->user->name ?? 'User',
            'LOGIN' => $this->user->username ?? $this->user->email,
            'LOGIN_URL' => $loginUrl,
        ]);
    }
}
