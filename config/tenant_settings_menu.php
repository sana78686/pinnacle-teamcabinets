<?php

return [
    'sections' => [
        [
            'label' => 'Site Settings',
            'route' => 'tenant_site_setting',
            'active' => ['tenant_site_setting', 'tenant_site_settings_store'],
        ],
        [
            'label' => 'Tax & Fees',
            'route' => 'tenant_setting_tax_fees',
            'active' => ['tenant_setting_tax_fees', 'tenant_setting_tax_fees_store', 'tenant_setting_manage_credit', 'tenant_setting_manage_fuel'],
        ],
        [
            'label' => 'Commission & Point Factors',
            'route' => 'tenant_setting_commission',
            'active' => ['tenant_setting_commission'],
        ],
        [
            'label' => 'QuickBooks',
            'route' => 'tenant_quickbooks_index',
            'active' => ['tenant_quickbooks_*'],
        ],
        [
            'label' => 'Roles & Permissions',
            'route' => 'tenant_role_index',
            'active' => ['tenant_role_*', 'role.export', 'role.import'],
        ],
        [
            'label' => 'Home Page',
            'route' => 'tenant_home_setting_index',
            'active' => ['tenant_home_setting_index', 'tenant_home_setting_srore'],
        ],
        [
            'label' => 'CMS Pages',
            'route' => 'pages.index',
            'active' => ['pages.create', 'pages.index', 'pages.edit', 'pages.show', 'pages.store', 'pages.update'],
        ],
        [
            'label' => 'SMTP Settings',
            'route' => 'tenant_setting_manage_stmp',
            'active' => ['tenant_setting_manage_stmp', 'tenant_setting_manage_stmp_*'],
        ],
        [
            'label' => 'Email Content',
            'route' => 'tenant_setting_manage_email_content',
            'active' => ['tenant_setting_manage_email_content', 'tenant_setting_manage_email_content_*'],
        ],
        [
            'label' => 'Success / Error Messages',
            'route' => 'tenant_setting_manage_success_list',
            'active' => ['tenant_setting_manage_success', 'tenant_setting_manage_success_*'],
        ],
        [
            'label' => 'Contact Us',
            'route' => 'tenant_setting_manage_index',
            'active' => ['tenant_setting_manage_index', 'tenant_setting_manage_contact_*'],
        ],
        [
            'label' => 'About Us',
            'route' => 'tenant_setting_manage_create',
            'active' => ['tenant_setting_manage_create', 'tenant_setting_manage_about_*'],
        ],
    ],
];
