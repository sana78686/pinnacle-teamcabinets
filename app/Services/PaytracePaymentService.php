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
        $config = $this->tenantConfig();

        if ($config['username'] === '' || $config['password'] === '') {
            return [
                'success' => false,
                'status_message' => 'Paytrace is not configured for this tenant. Use Cash/Wire Transfer, or add Paytrace settings under Settings → Taxes & fees → Paytrace.',
            ];
        }

        try {
            $token = $this->oauthToken($config);
            if (! $token) {
                return [
                    'success' => false,
                    'status_message' => $this->authFailureMessage($config),
                ];
            }

            return $this->submitTransaction($token, $config, $type, $amount, $input);
        } catch (\Throwable $e) {
            Log::warning('Paytrace charge failed: '.$e->getMessage());

            return ['success' => false, 'status_message' => 'Payment processing failed. Please try again or choose another method.'];
        }
    }

    /**
     * @return array{username: string, password: string, env: string, base_url: string, integrator_id: string, sandbox: bool}
     */
    public function tenantConfig(): array
    {
        $env = strtolower(trim((string) (tax_value('paytrace_env', 'production') ?? 'production')));
        if (! in_array($env, ['sandbox', 'production'], true)) {
            $env = 'production';
        }

        $baseUrl = trim((string) (tax_value('paytrace_base_url', '') ?? ''));
        if ($baseUrl === '') {
            $baseUrl = $env === 'sandbox'
                ? 'https://api.sandbox.paytrace.com'
                : 'https://api.paytrace.com';
        }

        $integratorId = trim((string) (tax_value('paytrace_integrator_id', '') ?? ''));
        if ($integratorId === '') {
            $integratorId = (string) config('paytrace.integrator_id', '92371rHTLxWk');
        }

        return [
            'username' => trim((string) (tax_value('paytrace_username', '') ?? '')),
            'password' => (string) (tax_value('paytrace_password', '') ?? ''),
            'env' => $env,
            'base_url' => rtrim($baseUrl, '/'),
            'integrator_id' => $integratorId,
            'sandbox' => $env === 'sandbox' || str_contains(strtolower($baseUrl), 'sandbox.paytrace.com'),
        ];
    }

    /**
     * @param  array{username: string, password: string, base_url: string, sandbox: bool}  $config
     */
    protected function oauthTokenUrl(array $config): string
    {
        return $config['sandbox']
            ? $config['base_url'].'/v3/token/'
            : $config['base_url'].'/oauth/token';
    }

    /**
     * @param  array{username: string, password: string, sandbox: bool, base_url: string}  $config
     */
    protected function oauthToken(array $config): ?string
    {
        $response = Http::asForm()
            ->withBasicAuth($config['username'], $config['password'])
            ->post($this->oauthTokenUrl($config), [
                'grant_type' => 'client_credentials',
            ]);

        if (! $response->successful()) {
            Log::warning('Paytrace OAuth failed', [
                'status' => $response->status(),
                'url' => $this->oauthTokenUrl($config),
                'sandbox' => $config['sandbox'],
                'body' => $response->json() ?? $response->body(),
            ]);

            return null;
        }

        return $response->json('access_token');
    }

    /**
     * @param  array{sandbox: bool}  $config
     */
    protected function authFailureMessage(array $config): string
    {
        $hint = $config['sandbox']
            ? 'Check sandbox API username, password, and integrator ID under Settings → Taxes & fees → Paytrace.'
            : 'Check production API credentials under Settings → Taxes & fees → Paytrace (use an API user, not your web login).';

        return 'Could not authenticate with Paytrace. '.$hint;
    }

    /**
     * @param  array{base_url: string, integrator_id: string}  $config
     * @param  array<string, mixed>  $input
     * @return array{success: bool, transaction_id?: string, check_transaction_id?: string, status_message: string}
     */
    protected function submitTransaction(string $token, array $config, string $type, float $amount, array $input): array
    {
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
                'integrator_id' => $config['integrator_id'],
                'billing_address' => $billing,
            ];
            $url = $config['base_url'].'/v1/checks/sale/keyed';
        } else {
            $exp = explode('/', (string) ($input['expiry_date'] ?? ''));
            $payload = [
                'amount' => round($amount, 2),
                'credit_card' => [
                    'number' => preg_replace('/\D/', '', (string) ($input['card_number'] ?? '')),
                    'expiration_month' => $exp[0] ?? '',
                    'expiration_year' => $exp[1] ?? '',
                ],
                'integrator_id' => $config['integrator_id'],
                'csc' => $input['cvv_number'] ?? '',
                'billing_address' => $billing,
            ];
            $url = $config['base_url'].'/v1/transactions/sale/keyed';
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
