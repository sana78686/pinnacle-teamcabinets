<?php

/**
 * Product setup area: list pages use top tabs; create/edit/show use sidebar (like Settings).
 * Recommended order: Catalog → Category → Door style → Product.
 */
return [
    'hub_route' => 'tenant_products_hub',

    'list_tabs' => [
        [
            'label' => 'Overview',
            'route' => 'tenant_products_hub',
            'icon' => 'layout',
            'step' => null,
            'active' => ['tenant_products_hub'],
        ],
        [
            'label' => 'Catalogs',
            'route' => 'tenant_product_catalog_index',
            'icon' => 'layers',
            'step' => 1,
            'active' => [
                'tenant_product_catalog_index',
                'tenant_product_catalog_show',
                'tenant_deleted_product_catalog_list',
            ],
        ],
        [
            'label' => 'Category / Cabinet Section',
            'route' => 'tenant_product_section_index',
            'icon' => 'folder',
            'step' => 2,
            'active' => [
                'tenant_product_section_index',
                'tenant_product_section_show',
                'tenant_deleted_product_section_list',
            ],
        ],
        [
            'label' => 'Door styles',
            'route' => 'tenant_door_style_index',
            'icon' => 'grid',
            'step' => 3,
            'active' => [
                'tenant_door_style_index',
                'tenant_door_style_show',
                'tenant_door_style_delete',
                'tenant_door_style_restore',
            ],
        ],
        [
            'label' => 'Products',
            'route' => 'tenant_product_index',
            'icon' => 'package',
            'step' => 4,
            'active' => [
                'tenant_product_index',
                'tenant_product_show',
                'tenant_deleted_products_list',
            ],
        ],
    ],

    'form_sections' => [
        [
            'step' => 1,
            'label' => 'Catalog',
            'icon' => 'layers',
            'hint' => 'Start here — create a catalog before categories and products.',
            'create_route' => 'tenant_product_catalog_create',
            'create_label' => 'Create catalog',
            'list_route' => 'tenant_product_catalog_index',
            'active' => [
                'tenant_product_catalog_create',
                'tenant_product_catalog_edit',
                'tenant_product_catalog_show',
                'tenant_product_catalog_store',
                'tenant_product_catalog_update',
            ],
        ],
        [
            'step' => 2,
            'label' => 'Category / Cabinet Section',
            'icon' => 'folder',
            'hint' => 'Group products within a catalog. Optional default assemble cost per section.',
            'create_route' => 'tenant_product_section_create',
            'create_label' => 'Create category / cabinet section',
            'list_route' => 'tenant_product_section_index',
            'active' => [
                'tenant_product_section_create',
                'tenant_product_section_edit',
                'tenant_product_section_show',
                'tenant_product_section_store',
                'tenant_product_section_update',
            ],
        ],
        [
            'step' => 3,
            'label' => 'Door style',
            'icon' => 'image',
            'hint' => 'Door colors/styles belong to a catalog.',
            'create_route' => 'tenant_door_style_create',
            'create_label' => 'Create door style',
            'list_route' => 'tenant_door_style_index',
            'active' => [
                'tenant_door_style_create',
                'tenant_door_style_edit',
                'tenant_door_style_show',
                'tenant_door_style_store',
                'tenant_door_style_update',
            ],
        ],
        [
            'step' => 4,
            'label' => 'Product',
            'icon' => 'box',
            'hint' => 'Add SKUs after catalog, category, and door style exist.',
            'create_route' => 'tenant_product_create',
            'create_label' => 'Create product',
            'list_route' => 'tenant_product_index',
            'active' => [
                'tenant_product_create',
                'tenant_product_edit',
                'tenant_product_show',
                'tenant_product_store',
                'tenant_product_update',
            ],
        ],
    ],

    'chrome_route_patterns' => [
        'tenant_products_hub',
        'tenant_product_*',
        'tenant_product_catalog_*',
        'tenant_products_*',
        'tenant_product_section_*',
        'tenant_door_style_*',
    ],
];
