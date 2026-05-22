<?php

/**
 * Sidebar nav badge keys: parent modules aggregate list_key counts.
 */
return [
    'parents' => [
        'orders' => ['orders_list'],
        'quotes' => ['quotes_list', 'shipping_quotes_list'],
        'stock_check' => ['stock_check_list'],
        'claims' => ['claims_list'],
    ],

    'list_keys' => [
        'orders_list',
        'quotes_list',
        'shipping_quotes_list',
        'stock_check_list',
        'claims_list',
    ],
];
