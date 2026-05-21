<?php

namespace App\Services;

use App\Models\TenantQuickBooksSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class QuickBooksOAuthService
{
    public function isConfigured(): bool
    {
        return (bool) config('services.quickbooks.client_id')
            && (bool) config('services.quickbooks.client_secret')
            && (bool) config('services.quickbooks.redirect_uri');
    }

    public function authorizationUrl(): string
    {
        $state = Str::random(40);
        session(['quickbooks_oauth_state' => $state]);

        $query = http_build_query([
            'client_id' => config('services.quickbooks.client_id'),
            'redirect_uri' => config('services.quickbooks.redirect_uri'),
            'response_type' => 'code',
            'scope' => config('services.quickbooks.scope'),
            'state' => $state,
        ]);

        return 'https://appcenter.intuit.com/connect/oauth2?'.$query;
    }

    public function exchangeCode(string $code, string $realmId): TenantQuickBooksSetting
    {
        $response = Http::asForm()
            ->withBasicAuth(
                config('services.quickbooks.client_id'),
                config('services.quickbooks.client_secret')
            )
            ->post('https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer', [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => config('services.quickbooks.redirect_uri'),
            ]);

        if (! $response->successful()) {
            throw new \RuntimeException('QuickBooks token exchange failed: '.$response->body());
        }

        $data = $response->json();
        $expiresIn = (int) ($data['expires_in'] ?? 3600);

        $record = TenantQuickBooksSetting::query()->firstOrNew(['tenant_id' => tenant('id')]);
        $record->fill([
            'realm_id' => $realmId,
            'access_token' => $data['access_token'] ?? null,
            'refresh_token' => $data['refresh_token'] ?? null,
            'token_expires_at' => now()->addSeconds($expiresIn),
            'environment' => config('services.quickbooks.environment', 'sandbox'),
            'connected_at' => now(),
        ]);
        $record->save();

        return $record;
    }

    public function disconnect(): void
    {
        $record = TenantQuickBooksSetting::query()->first();
        if ($record) {
            $record->update([
                'realm_id' => null,
                'access_token' => null,
                'refresh_token' => null,
                'token_expires_at' => null,
                'connected_at' => null,
            ]);
        }
    }
}
