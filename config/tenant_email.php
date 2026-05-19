<?php

return [

    /*
    | CI email partials for {CONTENT} blocks (orders, claims, stock, shipping).
    | Platform logo fallback: config/pinnacle.php (static). Per-tenant: site_settings.
    */
    'partials' => [
        'invoice' => 'emails.tenant.ci.partials.invoice_email',
        'claims' => 'emails.tenant.ci.partials.claims_email',
        'user_claims' => 'emails.tenant.ci.partials.user_claims_email',
        'stock_check_warehouse' => 'emails.tenant.ci.partials.stock_check_email_to_warehouse',
        'stock_check_quote' => 'emails.tenant.ci.partials.email_stock_check_quote_data',
        'shipping_quote' => 'emails.tenant.ci.partials.email_shipping_quote_data',
        'pick_list' => 'emails.tenant.ci.partials.pick_list_email',
    ],

];
