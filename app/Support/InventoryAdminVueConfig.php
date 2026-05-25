<?php

namespace App\Support;

class InventoryAdminVueConfig
{
    public static function get(): array
    {
        $statusOptions = [
            ['value' => 'active', 'label' => 'Active'],
            ['value' => 'inactive', 'label' => 'Inactive'],
        ];

        return [
            'type' => 'inventory-admin',
            'singular' => 'Inventory item',
            'addLabel' => 'Add inventory item',
            'columns' => [
                ['key' => 'id', 'label' => '#'],
                ['key' => 'product_name', 'label' => 'Product'],
                ['key' => 'sku', 'label' => 'SKU'],
                ['key' => 'quantity', 'label' => 'Quantity'],
                ['key' => 'status', 'label' => 'Status'],
            ],
            'showFields' => [
                ['key' => 'product_name', 'label' => 'Product'],
                ['key' => 'sku', 'label' => 'SKU'],
                ['key' => 'quantity', 'label' => 'Quantity'],
                ['key' => 'status', 'label' => 'Status'],
            ],
            'fields' => [
                ['name' => 'product_name', 'label' => 'Product name', 'type' => 'text', 'required' => true],
                ['name' => 'sku', 'label' => 'SKU', 'type' => 'text'],
                ['name' => 'quantity', 'label' => 'Quantity', 'type' => 'number', 'required' => true, 'min' => 0],
                ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => $statusOptions],
            ],
            'api' => [
                'index' => route('tenant_inventory_admin_api_index'),
                'store' => route('tenant_inventory_admin_api_store'),
                'update' => route('tenant_inventory_admin_api_update', ['id' => '__ID__']),
                'destroy' => route('tenant_inventory_admin_api_destroy', ['id' => '__ID__']),
            ],
            'csrf' => csrf_token(),
        ];
    }
}
