<?php

/**
 * Optional app-wide defaults only. Each tenant configures Paytrace under
 * Settings → Taxes & fees → Paytrace (stored in tax_values per tenant).
 */
return [
    'integrator_id' => env('PAYTRACE_INTEGRATOR_ID', '92371rHTLxWk'),
];
