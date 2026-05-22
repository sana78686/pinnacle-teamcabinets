<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaytracePaymentService
{
    /**
     * Process card/ACH payment via Paytrace JSON API (CI Payment_Model parity).
     *
     * @param  array<string, mixed>  $input
     * @return array{success: bool, transaction_id?: string, check_transaction_id?: string, status_message: string}
     */
    public function charge(string $type, float $amount, array $input): array
    {
        $username = tax_value('paytrace_username', '') ?? '';
        $password = tax_value('paytrace_password', '') ?? '';

        if ($username === '' || $password === '') {
            return [
                'success' => false,
                'status_message' => 'Paytrace is not configured for this tenant. Use Check or Purchase Order, or add Paytrace credentials under Settings → Taxes & fees.',
            ];
        }

        try {
            $token = $this->oauthToken($username, $password);
            if (! $token) {
                return ['success' => false, 'status_message' => 'Could not authenticate with Paytrace.'];
            }

            return $this->submitTransaction($token, $type, $amount, $input);
        } catch (\Throwable $e) {
            Log::warning('Paytrace charge failed: '.$e->getMessage());

            return ['success' => false, 'status_message' => 'Payment processing failed. Please try again or choose another method.'];
        }
    }

    protected function oauthToken(string $username, string $password): ?string
    {
        $response = Http::asForm()
            ->withBasicAuth($username, $password)
            ->post('https://api.paytrace.com/oauth/token', [
                'grant_type' => 'client_credentials',
            ]);

        if (! $response->successful()) {
            return null;
        }

        return $response->json('access_token');
    }

    /**
     * @param  array<string, mixed>  $input
     * @return array{success: bool, transaction_id?: string, check_transaction_id?: string, status_message: string}
     */
    protected function submitTransaction(string $token, string $type, float $amount, array $input): array
    {
        $integratorId = '92371rHTLxWk';
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
            $url = 'https://api.paytrace.com/v1/checks/sale/keyed';
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
            $url = 'https://api.paytrace.com/v1/transactions/sale/keyed';
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

        return ['success' => false, 'status_message' => (string) $message];
    }
}
