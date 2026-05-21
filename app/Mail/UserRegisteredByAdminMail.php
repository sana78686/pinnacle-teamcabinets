<?php

namespace App\Mail;

use App\Mail\Concerns\BuildsCiTenantEmail;
use App\Models\ManageEmailsContent;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegisteredByAdminMail extends Mailable
{
    use BuildsCiTenantEmail, Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $plainPassword,
        public ?string $loginUrl = null,
    ) {}

    public function build(): static
    {
        $tenantId = tenant('id') ?? $this->user->tenant_id;
        $loginUrl = $this->loginUrl ?? tenant_url((string) $tenantId, 'login');

        return $this->buildCiTenantEmail(ManageEmailsContent::SLUG_USER_REG_BY_ADMIN, [
            'USERNAME' => $this->user->username,
            'PASSWORD' => $this->plainPassword,
            'URL' => $loginUrl,
        ]);
    }
}
