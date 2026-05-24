<?php

namespace App\Support;

class EmailSettingsVueConfig
{
    public static function modules(): array
    {
        return [
            'smtp' => [
                'type' => 'smtp',
                'singular' => 'SMTP account',
                'addLabel' => 'Add New SMTP',
                'note' => 'You cannot delete an SMTP account that is assigned to an email template.',
                'columns' => [
                    ['key' => 'id', 'label' => '#'],
                    ['key' => 'smtp_host', 'label' => 'SMTP Host'],
                    ['key' => 'smtp_username', 'label' => 'SMTP Username'],
                    ['key' => 'from_email', 'label' => 'From Email'],
                    ['key' => 'smtp_port', 'label' => 'Port'],
                    ['key' => 'smtp_encryption', 'label' => 'Encryption'],
                ],
                'showFields' => [
                    ['key' => 'id', 'label' => 'ID'],
                    ['key' => 'smtp_host', 'label' => 'SMTP Host'],
                    ['key' => 'smtp_username', 'label' => 'SMTP Username'],
                    ['key' => 'from_email', 'label' => 'From Email'],
                    ['key' => 'from_name', 'label' => 'From Name'],
                    ['key' => 'smtp_port', 'label' => 'Port'],
                    ['key' => 'smtp_encryption', 'label' => 'Encryption'],
                    ['key' => 'is_verified', 'label' => 'Verified', 'type' => 'bool'],
                ],
                'fields' => [
                    ['name' => 'smtp_host', 'label' => 'SMTP Host', 'required' => true, 'placeholder' => 'smtp.office365.com', 'tip' => config('tenant_field_tips.host')],
                    ['name' => 'smtp_username', 'label' => 'SMTP Username', 'required' => true, 'placeholder' => 'user@company.com', 'tip' => config('tenant_field_tips.username')],
                    ['name' => 'smtp_password', 'label' => 'SMTP Password', 'type' => 'password', 'placeholder' => 'Leave blank to keep current password', 'tip' => config('tenant_field_tips.password')],
                    ['name' => 'from_email', 'label' => 'From Email', 'type' => 'email', 'required' => true, 'placeholder' => 'sales@teamcabinets.com', 'tip' => 'Address shown as the sender on outgoing mail.', 'note' => 'NOTE: From Email should be same as SMTP Username.'],
                    ['name' => 'from_name', 'label' => 'From Name', 'placeholder' => 'Team Cabinets', 'tip' => 'Display name for outgoing mail.'],
                    ['name' => 'smtp_port', 'label' => 'SMTP Port', 'type' => 'number', 'required' => true, 'placeholder' => '587', 'tip' => config('tenant_field_tips.port')],
                    ['name' => 'smtp_encryption', 'label' => 'Encryption', 'type' => 'select', 'required' => true, 'options' => [
                        ['value' => 'tls', 'label' => 'TLS'],
                        ['value' => 'ssl', 'label' => 'SSL'],
                        ['value' => 'none', 'label' => 'None'],
                    ], 'tip' => config('tenant_field_tips.port')],
                ],
            ],
            'email-content' => [
                'type' => 'email-content',
                'singular' => 'Email template',
                'addLabel' => 'Add Email Template',
                'note' => 'Templates are used for registration, orders, quotes, stock checks, shipping quotes, and claims.',
                'columns' => [
                    ['key' => 'id', 'label' => '#'],
                    ['key' => 'email_type', 'label' => 'Emails'],
                    ['key' => 'email_subject', 'label' => 'Subject'],
                    ['key' => 'smtp_label', 'label' => 'SMTP From'],
                ],
                'showFields' => [
                    ['key' => 'id', 'label' => 'ID'],
                    ['key' => 'email_type', 'label' => 'Name'],
                    ['key' => 'email_slug', 'label' => 'Slug'],
                    ['key' => 'email_subject', 'label' => 'Subject'],
                    ['key' => 'macro', 'label' => 'Macros'],
                    ['key' => 'smtp_label', 'label' => 'SMTP From'],
                    ['key' => 'email_content', 'label' => 'Content', 'type' => 'html'],
                ],
                'fields' => [
                    ['name' => 'email_type', 'label' => 'Email name', 'required' => true, 'placeholder' => 'Shipping Quote Email For Admin', 'tip' => 'Label shown in the admin list (same as CI “Emails” column).'],
                    ['name' => 'email_slug', 'label' => 'Slug', 'required' => true, 'placeholder' => 'shipping_quote_req_to_admin', 'tip' => 'Unique system key. Do not change after the template is in use.'],
                    ['name' => 'email_subject', 'label' => 'Subject', 'required' => true, 'placeholder' => 'Team Cabinets - New Shipping Quote Request', 'full' => true],
                    ['name' => 'email_from', 'label' => 'Send using SMTP', 'type' => 'select', 'optionsFrom' => 'smtp_accounts', 'tip' => 'Optional. Uses the default tenant SMTP when not set.'],
                    ['name' => 'macro', 'label' => 'Macros', 'placeholder' => '{USERNAME},{CONTENT}', 'tip' => 'Comma-separated placeholders available in subject/body.'],
                    ['name' => 'email_content', 'label' => 'Email body (HTML)', 'type' => 'textarea', 'required' => true, 'full' => true, 'rows' => 8, 'tip' => 'HTML content. Use macros like {USERNAME} in the body.'],
                ],
            ],
        ];
    }
}
