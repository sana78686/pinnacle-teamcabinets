<?php

namespace App\Mail\Central;

use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewTenantWelcome extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Tenant $tenant) {}

    public function build(): static
    {
        $loginUrl = $this->tenant->domain_name
            ? (str_starts_with($this->tenant->domain_name, 'http') ? $this->tenant->domain_name : 'http://'.$this->tenant->domain_name.'/login')
            : tenant_url($this->tenant->id, 'login');

        return $this->subject('Welcome to '.config('pinnacle.name', 'Pinnacle'))
            ->view('emails.central.new-tenant-welcome', [
                'tenant' => $this->tenant,
                'loginUrl' => $loginUrl,
            ]);
    }
}
