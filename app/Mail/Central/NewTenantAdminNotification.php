<?php

namespace App\Mail\Central;

use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewTenantAdminNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Tenant $tenant) {}

    public function build(): static
    {
        $company = $this->tenant->company_name ?? $this->tenant->name ?? 'New tenant';

        return $this->subject(config('pinnacle.name', 'Pinnacle').' — New tenant registered: '.$company)
            ->view('emails.central.new-tenant-admin', ['tenant' => $this->tenant]);
    }
}
