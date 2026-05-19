<?php

namespace App\Mail;

use App\Mail\Concerns\BuildsCiTenantEmail;
use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TenantRegisteredMail extends Mailable
{
    use BuildsCiTenantEmail, Queueable, SerializesModels;

    public function __construct(public Tenant $tenant) {}

    public function build(): static
    {
        return $this->buildCiTenantEmail('tenant_registered', [
            'USERNAME' => $this->tenant->name ?? $this->tenant->company_name ?? 'User',
            'LOGIN_URL' => $this->tenant->domain_name ?? tenant_url($this->tenant->id, 'login'),
        ]);
    }
}
