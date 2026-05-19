<?php

return [
    'sections' => [
        [
            'label' => 'Site Settings',
            'route' => 'tenant_site_setting',
            'active' => ['tenant_site_setting', 'tenant_site_settings_store'],
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
            'label' => 'Document Settings',
            'route' => 'tenant_setting_manage_document',
            'active' => ['tenant_setting_manage_document', 'tenant_setting_manage_documentation_*'],
        ],
        [
            'label' => 'Documentation List',
            'route' => 'tenant_setting_manage_documentation_list',
            'active' => ['tenant_setting_manage_documentation_list'],
        ],
        [
            'label' => 'SMTP Settings',
            'route' => 'tenant_setting_manage_stmp',
            'active' => ['tenant_setting_manage_stmp', 'tenant_setting_manage_stmp_*'],
        ],
        [
            'label' => 'SMTP List',
            'route' => 'tenant_setting_manage_stmp_list',
            'active' => ['tenant_setting_manage_stmp_list'],
        ],
        [
            'label' => 'Email Content',
            'route' => 'tenant_setting_manage_email_content',
            'active' => ['tenant_setting_manage_email_content', 'tenant_setting_manage_email_content_*'],
        ],
        [
            'label' => 'Email Content List',
            'route' => 'tenant_setting_manage_email_content_list',
            'active' => ['tenant_setting_manage_email_content_list'],
        ],
        [
            'label' => 'Terms & Conditions',
            'route' => 'tenant_setting_manage_term_condition',
            'active' => ['tenant_setting_manage_term_condition', 'tenant_setting_manage_term_condition_*'],
        ],
        [
            'label' => 'Terms List',
            'route' => 'tenant_setting_manage_term_condition_list',
            'active' => ['tenant_setting_manage_term_condition_list'],
        ],
        [
            'label' => 'Credit / Debit / ACH',
            'route' => 'tenant_setting_manage_credit',
            'active' => ['tenant_setting_manage_credit', 'tenant_setting_manage_credit_*'],
        ],
        [
            'label' => 'Credit List',
            'route' => 'tenant_setting_manage_credit_list',
            'active' => ['tenant_setting_manage_credit_list'],
        ],
        [
            'label' => 'Fuel Settings',
            'route' => 'tenant_setting_manage_fuel',
            'active' => ['tenant_setting_manage_fuel', 'tenant_setting_manage_fuel_*'],
        ],
        [
            'label' => 'Fuel List',
            'route' => 'tenant_setting_manage_fuel_list',
            'active' => ['tenant_setting_manage_fuel_list'],
        ],
        [
            'label' => 'Success / Error Messages',
            'route' => 'tenant_setting_manage_success',
            'active' => ['tenant_setting_manage_success', 'tenant_setting_manage_success_*'],
        ],
        [
            'label' => 'Success Messages List',
            'route' => 'tenant_setting_manage_success_list',
            'active' => ['tenant_setting_manage_success_list'],
        ],
        [
            'label' => 'Contact Us',
            'route' => 'tenant_setting_manage_index',
            'active' => ['tenant_setting_manage_index', 'tenant_setting_manage_contact_*'],
        ],
        [
            'label' => 'Contact List',
            'route' => 'tenant_setting_manage_contact_list',
            'active' => ['tenant_setting_manage_contact_list'],
        ],
        [
            'label' => 'About Us',
            'route' => 'tenant_setting_manage_create',
            'active' => ['tenant_setting_manage_create', 'tenant_setting_manage_about_*'],
        ],
        [
            'label' => 'About Us List',
            'route' => 'tenant_setting_manage_about_List',
            'active' => ['tenant_setting_manage_about_List'],
        ],
    ],
];
