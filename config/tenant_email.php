<?php

return [

    /*
    | CI email partials for {CONTENT} blocks (orders, claims, stock, shipping).
    | Platform logo fallback: config/pinnacle.php (static). Per-tenant: site_settings.
    */
    'partials' => [
        'invoice' => 'emails.tenant.ci.partials.invoice_email',
        'claims' => 'emails.tenant.partials.claims_body',
        'user_claims' => 'emails.tenant.partials.claims_body',
        'stock_check_warehouse' => 'emails.tenant.ci.partials.stock_check_email_to_warehouse',
        'stock_check_quote' => 'emails.tenant.ci.partials.email_stock_check_quote_data',
        'shipping_quote' => 'emails.tenant.ci.partials.email_shipping_quote_data',
        'shipping_quote_workspace' => 'emails.tenant.workspace.shipping_quote_body',
        'stock_check_workspace' => 'emails.tenant.workspace.stock_check_body',
        'order_workspace_invoice' => 'emails.tenant.workspace.order_invoice_body',
        'order_workspace_quote' => 'emails.tenant.workspace.order_quote_body',
        'pick_list' => 'emails.tenant.ci.partials.pick_list_email',
    ],

];
