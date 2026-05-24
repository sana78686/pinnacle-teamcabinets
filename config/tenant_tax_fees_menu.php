<?php

return [
    'sections' => [
        [
            'label' => 'Overview',
            'route' => 'tenant_setting_tax_fees',
            'icon' => 'grid',
            'active' => ['tenant_setting_tax_fees'],
        ],
        [
            'label' => 'Payment & fuel',
            'route' => 'tenant_setting_tax_fees_payment',
            'icon' => 'credit-card',
            'active' => ['tenant_setting_tax_fees_payment', 'tenant_setting_tax_fees_payment_store'],
        ],
        [
            'label' => 'Shipping charges',
            'route' => 'tenant_setting_tax_fees_shipping',
            'icon' => 'truck',
            'active' => ['tenant_setting_tax_fees_shipping', 'tenant_setting_tax_fees_shipping_store'],
        ],
        [
            'label' => 'Sales Tax Management',
            'route' => 'tenant_setting_tax_fees_sales_tax',
            'icon' => 'map-pin',
            'active' => [
                'tenant_setting_tax_fees_sales_tax',
                'tenant_setting_tax_fees_sales_tax_edit',
                'tenant_setting_tax_fees_sales_tax_update',
                'tenant_setting_tax_fees_sales_tax_store',
            ],
        ],
        [
            'label' => 'Paytrace',
            'route' => 'tenant_setting_tax_fees_paytrace',
            'icon' => 'lock',
            'active' => ['tenant_setting_tax_fees_paytrace', 'tenant_setting_tax_fees_paytrace_store'],
        ],
    ],
];
