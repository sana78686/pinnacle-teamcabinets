<?php

namespace App\Http\Controllers\Concerns;

use App\Services\CloudflareTurnstileService;
use Illuminate\Http\Request;

trait ValidatesTurnstile
{
    /** @param  array<string, mixed>  $rules */
    protected function validateWithTurnstile(Request $request, array $rules): array
    {
        return $request->validate(array_merge($rules, app(CloudflareTurnstileService::class)->validationRules()));
    }
}
