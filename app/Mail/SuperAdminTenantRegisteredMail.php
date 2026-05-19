<?php

namespace App\Mail;

use App\Mail\Concerns\BuildsCiTenantEmail;
use App\Models\ManageEmailsContent;
use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SuperAdminTenantRegisteredMail extends Mailable
{
    use BuildsCiTenantEmail, Queueable, SerializesModels;

    public function __construct(public Tenant $tenant) {}

    public function build(): static
    {
        return $this->buildCiTenantEmail(ManageEmailsContent::SLUG_REGISTER_ADMIN, [
            'USERNAME' => $this->tenant->name ?? $this->tenant->company_name ?? 'New tenant',
        ]);
    }
}
