<?php

/**
 * Sidebar nav badge keys: parent modules aggregate list_key counts.
 */
return [
    'parents' => [
        'users' => ['users_list'],
        'orders' => ['orders_list'],
        'quotes' => ['quotes_list', 'shipping_quotes_list'],
        'stock_check' => ['stock_check_list'],
        'claims' => ['claims_list'],
    ],

    'list_keys' => [
        'users_list',
        'orders_list',
        'quotes_list',
        'shipping_quotes_list',
        'stock_check_list',
        'claims_list',
    ],
];
