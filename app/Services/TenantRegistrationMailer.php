<?php

namespace App\Services;

use App\Mail\Central\NewTenantAdminNotification;
use App\Mail\Central\NewTenantWelcome;
use App\Models\Tenant;
use Illuminate\Support\Facades\Log;

class TenantRegistrationMailer
{
    public static function send(Tenant $tenant): void
    {
        $central = app(CentralMailService::class);

        try {
            $superadminEmail = $central->superadminRecipient();

            if ($superadminEmail) {
                $central->send(new NewTenantAdminNotification($tenant), $superadminEmail);
                Log::info('Tenant registration admin email sent.', [
                    'tenant_id' => $tenant->id,
                    'to' => $superadminEmail,
                ]);
            } else {
                Log::warning('CENTRAL_MAIL is not set; super-admin tenant notification was skipped.');
            }

            if ($tenant->email) {
                $central->send(new NewTenantWelcome($tenant), $tenant->email);
                Log::info('Tenant registration welcome email sent.', [
                    'tenant_id' => $tenant->id,
                    'to' => $tenant->email,
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('Tenant registration emails failed: '.$e->getMessage(), [
                'tenant_id' => $tenant->id,
                'tenant_email' => $tenant->email,
                'exception' => $e::class,
            ]);
        }
    }
}
