<?php

namespace App\Services;

use App\Mail\SuperAdminTenantRegisteredMail;
use App\Mail\TenantRegisteredMail;
use App\Models\Tenant;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TenantRegistrationMailer
{
    public static function send(Tenant $tenant): void
    {
        $superadminEmail = config('mail.superadmin');

        try {
            if ($superadminEmail) {
                Mail::to($superadminEmail)->send(new SuperAdminTenantRegisteredMail($tenant));
            } else {
                Log::warning('SUPERADMIN_EMAIL is not set; super-admin tenant notification was skipped.');
            }

            Mail::to($tenant->email)->send(new TenantRegisteredMail($tenant));
        } catch (\Throwable $e) {
            Log::error('Tenant registration emails failed: '.$e->getMessage(), [
                'tenant_id' => $tenant->id,
                'tenant_email' => $tenant->email,
            ]);
        }
    }
}
