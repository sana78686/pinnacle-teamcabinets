<?php

namespace App\Rules;

use App\Services\CloudflareTurnstileService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CloudflareTurnstile implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $service = app(CloudflareTurnstileService::class);

        if (! $service->isEnabled()) {
            return;
        }

        if ($service->verify(is_string($value) ? $value : null, request()->ip())) {
            return;
        }

        $codes = $service->lastErrorCodes();

        if (in_array('timeout-or-duplicate', $codes, true)) {
            $fail('Security check expired. Please complete the verification again, then sign in.');
        } elseif (in_array('hostname-mismatch', $codes, true)) {
            $fail('Security verification does not match this site hostname. Add this domain in your Cloudflare Turnstile widget settings.');
        } else {
            $fail('Please complete the security verification.');
        }
    }
}
