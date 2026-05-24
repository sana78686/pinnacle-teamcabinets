<?php

namespace App\Support;

class RepWorkspaceVueConfig
{
    /** @return array<string, array<string, mixed>> */
    public static function modules(): array
    {
        $workspaceColumns = [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'job_name', 'label' => 'Job name'],
            ['key' => 'customer_name', 'label' => 'Customer'],
            ['key' => 'grand_total_cost', 'label' => 'Total', 'type' => 'money'],
            ['key' => 'sub_total_weight', 'label' => 'Weight'],
            ['key' => 'assemble_cabinets_check', 'label' => 'Assemble'],
            ['key' => 'shipping_status', 'label' => 'Shipping'],
            ['key' => 'created_at', 'label' => 'Date'],
        ];

        return [
            'orders' => [
                'type' => 'orders',
                'title' => 'My Orders',
                'rowLabel' => 'order',
                'createUrl' => route('tenant_order_workspace'),
                'createLabel' => 'Create Order',
                'restoreUrl' => route('tenant_deleted_order_list'),
                'restoreLabel' => 'Restore Orders',
                'emptyMessage' => 'No orders yet. Use Create Order workspace to add one.',
                'columns' => $workspaceColumns,
                'showUrl' => route('tenant_order_show', ['id' => '__ID__']),
                'canDelete' => true,
            ],
            'quotes' => [
                'type' => 'quotes',
                'title' => 'My Quotes',
                'rowLabel' => 'quote',
                'restoreUrl' => route('tenant_deleted_quotes_list'),
                'restoreLabel' => 'Restore Quotes',
                'emptyMessage' => 'No quotes yet.',
                'columns' => $workspaceColumns,
                'showUrl' => route('tenant_quotes_show', ['id' => '__ID__']),
                'editUrl' => route('tenant_quotes_edit', ['id' => '__ID__']),
                'canDelete' => true,
            ],
            'shipping-quotes' => [
                'type' => 'shipping-quotes',
                'title' => 'My Shipping Quotes',
                'rowLabel' => 'shipping quote',
                'restoreUrl' => route('tenant_deleted_shipping_quotes_list'),
                'restoreLabel' => 'Restore Shipping Quotes',
                'emptyMessage' => 'No shipping quotes yet.',
                'columns' => $workspaceColumns,
                'showUrl' => route('tenant_shipping_quotes_show', ['id' => '__ID__']),
                'canDelete' => true,
            ],
            'stock-check' => [
                'type' => 'stock-check',
                'title' => 'My Stock Check Requests',
                'rowLabel' => 'stock check',
                'restoreUrl' => route('tenant_deleted_stock_check_list'),
                'restoreLabel' => 'Restore Stock Check',
                'emptyMessage' => 'No stock check requests yet.',
                'columns' => $workspaceColumns,
                'showUrl' => route('tenant_stock_check_show', ['id' => '__ID__']),
                'canDelete' => true,
            ],
            'claims' => [
                'type' => 'claims',
                'title' => 'My Claims',
                'rowLabel' => 'claim',
                'createUrl' => route('tenant_claim_create'),
                'createLabel' => 'Create Claim',
                'emptyMessage' => 'No claims yet. Use Create Claim to add one.',
                'columns' => [
                    ['key' => 'id', 'label' => '#'],
                    ['key' => 'claims_order_id', 'label' => 'Order ID'],
                    ['key' => 'claims_order_message', 'label' => 'Message'],
                    ['key' => 'customer_name', 'label' => 'User'],
                    ['key' => 'created_at', 'label' => 'Date'],
                ],
                'showUrl' => route('tenant_claim_show', ['id' => '__ID__']),
                'canDelete' => false,
            ],
        ];
    }

    public static function get(string $type): array
    {
        $module = self::modules()[$type] ?? null;
        if (! $module) {
            abort(404);
        }

        return array_merge($module, [
            'csrf' => csrf_token(),
            'api' => [
                'index' => route('tenant_rep_workspace_api_index', ['type' => $type]),
                'destroy' => route('tenant_rep_workspace_api_destroy', ['type' => $type, 'id' => '__ID__']),
            ],
        ]);
    }
}
