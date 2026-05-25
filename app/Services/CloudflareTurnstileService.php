<?php

namespace App\Services;

use App\Rules\CloudflareTurnstile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CloudflareTurnstileService
{
    /** @var list<string> */
    protected array $lastErrorCodes = [];

    public function isEnabled(): bool
    {
        if (! filter_var(config('turnstile.enabled', true), FILTER_VALIDATE_BOOL)) {
            return false;
        }

        if ($this->shouldSkipForLocalHost()) {
            return false;
        }

        return filled($this->siteKey()) && filled($this->secretKey());
    }

    public function usesTestKeys(): bool
    {
        return ! $this->hasRealKeys()
            && filter_var(config('turnstile.use_test_keys', false), FILTER_VALIDATE_BOOL);
    }

    /** Real .env keys only (not Cloudflare test keys). */
    public function hasRealKeys(): bool
    {
        return $this->normalizeKey(config('turnstile.site_key')) !== null
            && $this->normalizeKey(config('turnstile.secret_key')) !== null;
    }

    public function shouldSkipForLocalHost(): bool
    {
        if (! config('turnstile.skip_on_localhost', false)) {
            return false;
        }

        $host = strtolower((string) request()->getHost());

        return $host === 'localhost'
            || $host === '127.0.0.1'
            || $host === '[::1]'
            || str_ends_with($host, '.localhost');
    }

    public function siteKey(): ?string
    {
        $key = $this->normalizeKey(config('turnstile.site_key'));

        if ($key !== null) {
            return $key;
        }

        if ($this->usesTestKeys()) {
            return config('turnstile.test_site_key');
        }

        return null;
    }

    public function secretKey(): ?string
    {
        $key = $this->normalizeKey(config('turnstile.secret_key'));

        if ($key !== null) {
            return $key;
        }

        if ($this->usesTestKeys()) {
            return config('turnstile.test_secret_key');
        }

        return null;
    }

    protected function normalizeKey(mixed $value): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        $value = trim($value);

        return $value !== '' ? $value : null;
    }

    /** @return list<string> */
    public function lastErrorCodes(): array
    {
        return $this->lastErrorCodes;
    }

    /** @return array<string, list<mixed>> */
    public function validationRules(): array
    {
        if (! $this->isEnabled()) {
            return [];
        }

        return [
            'cf-turnstile-response' => ['required', new CloudflareTurnstile()],
        ];
    }

    public function verify(?string $token, ?string $remoteIp = null): bool
    {
        $this->lastErrorCodes = [];

        if (! $this->isEnabled()) {
            return true;
        }

        if (! filled($token)) {
            return false;
        }

        $payload = [
            'secret' => $this->secretKey(),
            'response' => $token,
        ];

        if (config('turnstile.verify_remote_ip') && $remoteIp) {
            $payload['remoteip'] = $remoteIp;
        }

        try {
            $response = Http::asForm()
                ->timeout(10)
                ->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', $payload);

            if (! $response->successful()) {
                Log::warning('Turnstile siteverify HTTP error', ['status' => $response->status()]);

                return false;
            }

            $body = $response->json();
            if ($body['success'] ?? false) {
                return true;
            }

            $this->lastErrorCodes = $body['error-codes'] ?? [];
            Log::warning('Turnstile siteverify rejected token', [
                'error-codes' => $this->lastErrorCodes,
                'hostname' => $body['hostname'] ?? null,
            ]);

            return false;
        } catch (\Throwable $e) {
            Log::warning('Turnstile siteverify exception: '.$e->getMessage());

            return false;
        }
    }
}
