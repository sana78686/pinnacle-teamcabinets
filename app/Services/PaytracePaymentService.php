<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaytracePaymentService
{
    /**
     * @param  array<string, mixed>  $input
     * @return array{success: bool, transaction_id?: string, check_transaction_id?: string, status_message: string}
     */
    public function charge(string $type, float $amount, array $input): array
    {
        [$username, $password] = $this->resolveCredentials();

        if ($username === '' || $password === '') {
            return [
                'success' => false,
                'status_message' => 'Paytrace is not configured for this tenant. Use Cash/Wire Transfer, or add Paytrace API credentials under Settings → Taxes & fees → Paytrace.',
            ];
        }

        try {
            $token = $this->oauthToken($username, $password);
            if (! $token) {
                return [
                    'success' => false,
                    'status_message' => $this->authFailureMessage(),
                ];
            }

            return $this->submitTransaction($token, $type, $amount, $input);
        } catch (\Throwable $e) {
            Log::warning('Paytrace charge failed: '.$e->getMessage());

            return ['success' => false, 'status_message' => 'Payment processing failed. Please try again or choose another method.'];
        }
    }

    /**
     * @return array{0: string, 1: string}
     */
    protected function resolveCredentials(): array
    {
        $envUser = trim((string) config('paytrace.username', ''));
        $envPass = (string) config('paytrace.password', '');
        $tenantUser = trim((string) (tax_value('paytrace_username', '') ?? ''));
        $tenantPass = (string) (tax_value('paytrace_password', '') ?? '');

        $preferEnv = (bool) config('paytrace.prefer_env_credentials', false)
            || config('paytrace.env') === 'sandbox';

        if ($preferEnv && $envUser !== '') {
            return [$envUser, $envPass];
        }

        if ($tenantUser !== '') {
            return [$tenantUser, $tenantPass];
        }

        return [$envUser, $envPass];
    }

    protected function baseUrl(): string
    {
        return rtrim((string) config('paytrace.base_url', 'https://api.paytrace.com'), '/');
    }

    protected function isSandbox(): bool
    {
        return config('paytrace.env') === 'sandbox'
            || str_contains($this->baseUrl(), 'sandbox.paytrace.com');
    }

    protected function oauthTokenUrl(): string
    {
        return $this->isSandbox()
            ? $this->baseUrl().'/v3/token/'
            : $this->baseUrl().'/oauth/token';
    }

    protected function oauthToken(string $username, string $password): ?string
    {
        $response = Http::asForm()
            ->withBasicAuth($username, $password)
            ->post($this->oauthTokenUrl(), [
                'grant_type' => 'client_credentials',
            ]);

        if (! $response->successful()) {
            Log::warning('Paytrace OAuth failed', [
                'status' => $response->status(),
                'url' => $this->oauthTokenUrl(),
                'sandbox' => $this->isSandbox(),
                'body' => $response->json() ?? $response->body(),
            ]);

            return null;
        }

        return $response->json('access_token');
    }

    protected function authFailureMessage(): string
    {
        $hint = $this->isSandbox()
            ? 'Use your PayTrace sandbox API user (not your web login email). Credentials come from .env when PAYTRACE_ENV=sandbox.'
            : 'Use your PayTrace API user credentials in Settings → Taxes & fees → Paytrace (not your PayTrace web login).';

        return 'Could not authenticate with Paytrace. '.$hint;
    }

    /**
     * @param  array<string, mixed>  $input
     * @return array{success: bool, transaction_id?: string, check_transaction_id?: string, status_message: string}
     */
    protected function submitTransaction(string $token, string $type, float $amount, array $input): array
    {
        $integratorId = (string) config('paytrace.integrator_id', '92371rHTLxWk');
        $billing = [
            'name' => $input['billing_name'] ?? '',
            'street_address' => $input['billing_address'] ?? '',
            'city' => $input['billing_city'] ?? '',
            'state' => $input['billing_state'] ?? '',
            'zip' => $input['billing_zip'] ?? '',
        ];

        if ($type === 'ach') {
            $payload = [
                'amount' => round($amount, 2),
                'check_type' => 'SALE',
                'check' => [
                    'account_number' => $input['account_number'] ?? '',
                    'routing_number' => $input['routing_number'] ?? '',
                ],
                'integrator_id' => $integratorId,
                'billing_address' => $billing,
            ];
            $url = $this->baseUrl().'/v1/checks/sale/keyed';
        } else {
            $exp = explode('/', (string) ($input['expiry_date'] ?? ''));
            $payload = [
                'amount' => round($amount, 2),
                'credit_card' => [
                    'number' => preg_replace('/\D/', '', (string) ($input['card_number'] ?? '')),
                    'expiration_month' => $exp[0] ?? '',
                    'expiration_year' => $exp[1] ?? '',
                ],
                'integrator_id' => $integratorId,
                'csc' => $input['cvv_number'] ?? '',
                'billing_address' => $billing,
            ];
            $url = $this->baseUrl().'/v1/transactions/sale/keyed';
        }

        $response = Http::withToken($token)->post($url, $payload);
        $body = $response->json() ?? [];

        if ($response->successful() && ! empty($body['success'])) {
            return [
                'success' => true,
                'transaction_id' => (string) ($body['transaction_id'] ?? $body['id'] ?? ''),
                'check_transaction_id' => (string) ($body['check_transaction_id'] ?? ''),
                'status_message' => 'Approved',
            ];
        }

        $message = $body['errors'][0]['message'] ?? $body['status_message'] ?? 'Transaction declined.';
        Log::warning('Paytrace transaction declined', [
            'status' => $response->status(),
            'url' => $url,
            'body' => $body,
        ]);

        return ['success' => false, 'status_message' => (string) $message];
    }
}
