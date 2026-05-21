<?php

namespace App\Services;

use App\Models\TenantQuickBooksSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class QuickBooksOAuthService
{
    /** @return array{client_id: ?string, client_secret: ?string, redirect_uri: ?string, environment: string} */
    public function credentials(): array
    {
        $record = TenantQuickBooksSetting::query()->first();

        if ($record?->hasApiCredentials()) {
            return [
                'client_id' => $record->client_id,
                'client_secret' => $record->client_secret,
                'redirect_uri' => $record->redirect_uri,
                'environment' => $record->qb_environment ?: $record->environment ?: 'sandbox',
            ];
        }

        return [
            'client_id' => config('services.quickbooks.client_id'),
            'client_secret' => config('services.quickbooks.client_secret'),
            'redirect_uri' => config('services.quickbooks.redirect_uri'),
            'environment' => config('services.quickbooks.environment', 'sandbox'),
        ];
    }

    public function isConfigured(): bool
    {
        $c = $this->credentials();

        return filled($c['client_id']) && filled($c['client_secret']) && filled($c['redirect_uri']);
    }

    public function defaultRedirectUri(): string
    {
        return url(route('tenant_quickbooks_callback', [], false));
    }

    public function saveCredentials(array $data): TenantQuickBooksSetting
    {
        $record = TenantQuickBooksSetting::query()->firstOrNew(['tenant_id' => tenant('id')]);

        $record->fill([
            'client_id' => trim((string) ($data['client_id'] ?? '')),
            'client_secret' => trim((string) ($data['client_secret'] ?? '')),
            'redirect_uri' => trim((string) ($data['redirect_uri'] ?? $this->defaultRedirectUri())),
            'qb_environment' => in_array($data['qb_environment'] ?? '', ['sandbox', 'production'], true)
                ? $data['qb_environment']
                : 'sandbox',
        ]);

        if (empty($record->environment)) {
            $record->environment = $record->qb_environment;
        }

        $record->save();

        return $record;
    }

    /** @return array{ok: bool, message: string} */
    public function testConnection(): array
    {
        if (! $this->isConfigured()) {
            return ['ok' => false, 'message' => 'Enter Client ID, Client Secret, and Redirect URI first.'];
        }

        $setting = TenantQuickBooksSetting::query()->first();

        if ($setting?->isConnected()) {
            return $this->testConnectedApi($setting);
        }

        $c = $this->credentials();
        $response = Http::asForm()
            ->withBasicAuth($c['client_id'], $c['client_secret'])
            ->post('https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer', [
                'grant_type' => 'client_credentials',
            ]);

        if ($response->status() === 401 || $response->status() === 400) {
            return [
                'ok' => true,
                'message' => 'API credentials look valid. Click “Connect QuickBooks” to complete OAuth authorization.',
            ];
        }

        if ($response->successful()) {
            return [
                'ok' => true,
                'message' => 'Credentials accepted by Intuit. Click “Connect QuickBooks” to authorize this tenant.',
            ];
        }

        return [
            'ok' => false,
            'message' => 'Could not verify credentials with Intuit (HTTP '.$response->status().'). Check Client ID and Secret.',
        ];
    }

    /** @return array{ok: bool, message: string} */
    protected function testConnectedApi(TenantQuickBooksSetting $setting): array
    {
        $base = ($setting->environment === 'production' || $setting->qb_environment === 'production')
            ? 'https://quickbooks.api.intuit.com'
            : 'https://sandbox-quickbooks.api.intuit.com';

        $realm = $setting->realm_id;
        $url = "{$base}/v3/company/{$realm}/companyinfo/{$realm}";

        $response = Http::withToken($setting->access_token)->acceptJson()->get($url);

        if ($response->successful()) {
            $name = $response->json('CompanyInfo.CompanyName') ?? 'QuickBooks company';

            return ['ok' => true, 'message' => "Connected to {$name} (realm {$realm})."];
        }

        return [
            'ok' => false,
            'message' => 'OAuth tokens exist but API call failed. Try disconnecting and connecting again.',
        ];
    }

    public function authorizationUrl(): string
    {
        $c = $this->credentials();
        $state = Str::random(40);
        session(['quickbooks_oauth_state' => $state]);

        $query = http_build_query([
            'client_id' => $c['client_id'],
            'redirect_uri' => $c['redirect_uri'],
            'response_type' => 'code',
            'scope' => config('services.quickbooks.scope'),
            'state' => $state,
        ]);

        return 'https://appcenter.intuit.com/connect/oauth2?'.$query;
    }

    public function exchangeCode(string $code, string $realmId): TenantQuickBooksSetting
    {
        $c = $this->credentials();

        $response = Http::asForm()
            ->withBasicAuth($c['client_id'], $c['client_secret'])
            ->post('https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer', [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => $c['redirect_uri'],
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
            'environment' => $c['environment'],
            'qb_environment' => $c['environment'],
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
