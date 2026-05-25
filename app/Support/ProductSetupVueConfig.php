<?php

namespace App\Support;

class ProductSetupVueConfig
{
    public static function get(string $type): array
    {
        $configs = [
            'catalogs' => [
                'type' => 'catalogs',
                'singular' => 'Catalog',
                'addLabel' => 'Add Catalog',
                'columns' => [
                    ['key' => 'id', 'label' => '#'],
                    ['key' => 'name', 'label' => 'Name'],
                    ['key' => 'image_url', 'label' => 'Image', 'type' => 'image'],
                    ['key' => 'pdf_view_url', 'label' => 'PDF', 'type' => 'pdf'],
                ],
                'showFields' => [
                    ['key' => 'id', 'label' => 'ID'],
                    ['key' => 'name', 'label' => 'Name'],
                    ['key' => 'image_url', 'label' => 'Image', 'type' => 'image'],
                    ['key' => 'pdf_view_url', 'label' => 'PDF', 'type' => 'pdf'],
                ],
                'fields' => [
                    [
                        'name' => 'name',
                        'label' => 'Catalog name',
                        'required' => true,
                        'placeholder' => 'Enter catalog name, e.g. ARTSTAR',
                        'tip' => 'Product catalog line name shown in dropdowns and product lists.',
                    ],
                    [
                        'name' => 'image',
                        'label' => 'Image',
                        'type' => 'media',
                        'mediaType' => 'image',
                        'accept' => 'image/*',
                        'full' => true,
                        'tip' => 'Upload a catalog image (JPG, PNG, or WebP) or paste a direct https:// link.',
                        'hint' => MediaUpload::hint(),
                        'urlPlaceholder' => 'https://example.com/image.webp',
                        'urlTip' => 'Paste a direct https:// URL to an image file hosted online.',
                    ],
                    [
                        'name' => 'pdf',
                        'label' => 'PDF',
                        'type' => 'media',
                        'mediaType' => 'pdf',
                        'accept' => 'application/pdf',
                        'full' => true,
                        'tip' => 'Upload a PDF catalog file or paste a direct https:// link.',
                        'hint' => MediaUpload::hint(5120, true),
                        'urlPlaceholder' => 'https://example.com/catalog.pdf',
                        'urlTip' => 'Paste a direct https:// URL to a PDF file hosted online.',
                    ],
                ],
            ],
            'categories' => [
                'type' => 'categories',
                'singular' => 'Category / Cabinet Section',
                'addLabel' => 'Add Category / Cabinet Section',
                'columns' => [
                    ['key' => 'id', 'label' => '#'],
                    ['key' => 'cabinets_name', 'label' => 'Category / Cabinet Section'],
                    ['key' => 'assemble_price', 'label' => 'Assemble cost', 'type' => 'currency'],
                ],
                'showFields' => [
                    ['key' => 'id', 'label' => 'ID'],
                    ['key' => 'cabinets_name', 'label' => 'Category / Cabinet Section'],
                    ['key' => 'assemble_price', 'label' => 'Assemble cost', 'type' => 'currency'],
                ],
                'fields' => [
                    [
                        'name' => 'cabinets_name',
                        'label' => 'Category / Cabinet Section',
                        'required' => true,
                        'placeholder' => 'Enter category name, e.g. Wall Cabinets',
                        'tip' => 'Cabinet category or section name within a catalog (e.g. Wall Cabinets, Base Cabinets).',
                    ],
                    [
                        'name' => 'assemble_price',
                        'label' => 'Cabinet assemble cost',
                        'type' => 'number',
                        'step' => 'any',
                        'min' => 0,
                        'prefix' => '$',
                        'placeholder' => 'e.g. 30.00',
                        'tip' => 'Default assembly cost for products in this cabinet section (optional).',
                    ],
                ],
            ],
            'door-styles' => [
                'type' => 'door-styles',
                'singular' => 'Door style',
                'addLabel' => 'Add Door style',
                'columns' => [
                    ['key' => 'id', 'label' => '#'],
                    ['key' => 'catalog_name', 'label' => 'Catalog'],
                    ['key' => 'product_label', 'label' => 'Label'],
                    ['key' => 'image_url', 'label' => 'Image', 'type' => 'image'],
                    ['key' => 'status', 'label' => 'Status', 'type' => 'status'],
                ],
                'showFields' => [
                    ['key' => 'id', 'label' => 'ID'],
                    ['key' => 'catalog_name', 'label' => 'Catalog'],
                    ['key' => 'product_label', 'label' => 'Label'],
                    ['key' => 'image_url', 'label' => 'Image', 'type' => 'image'],
                    ['key' => 'status', 'label' => 'Status', 'type' => 'status'],
                ],
                'fields' => [
                    [
                        'name' => 'product_catalog_id',
                        'label' => 'Catalog',
                        'type' => 'select',
                        'options' => 'catalogs',
                        'required' => true,
                        'tip' => 'Product catalog this door style belongs to.',
                    ],
                    [
                        'name' => 'product_label',
                        'label' => 'Label',
                        'required' => true,
                        'placeholder' => 'Enter door style label, e.g. shaker white',
                        'tip' => 'Label shown for this door style in product lists and orders.',
                    ],
                    [
                        'name' => 'image',
                        'label' => 'Image',
                        'type' => 'media',
                        'mediaType' => 'image',
                        'accept' => 'image/*',
                        'full' => true,
                        'tip' => 'Upload a door style image or paste a direct https:// link.',
                        'hint' => MediaUpload::hint(),
                        'urlPlaceholder' => 'https://example.com/door-style.webp',
                        'urlTip' => 'Paste a direct https:// URL to an image file hosted online.',
                    ],
                    [
                        'name' => 'status',
                        'label' => 'Active',
                        'type' => 'checkbox',
                        'tip' => 'When unchecked, this door style is hidden from product selection.',
                    ],
                ],
            ],
            'products' => [
                'type' => 'products',
                'singular' => 'Product',
                'addLabel' => 'Add Product',
                'columns' => [
                    ['key' => 'id', 'label' => '#'],
                    ['key' => 'label', 'label' => 'Label'],
                    ['key' => 'sku', 'label' => 'SKU'],
                    ['key' => 'catalog_name', 'label' => 'Catalog'],
                    ['key' => 'category_name', 'label' => 'Category / Cabinet Section'],
                    ['key' => 'image_url', 'label' => 'Image', 'type' => 'image'],
                ],
                'showFields' => [
                    ['key' => 'id', 'label' => 'ID'],
                    ['key' => 'label', 'label' => 'Label'],
                    ['key' => 'sku', 'label' => 'SKU'],
                    ['key' => 'catalog_name', 'label' => 'Catalog'],
                    ['key' => 'category_name', 'label' => 'Category / Cabinet Section'],
                    ['key' => 'door_style_name', 'label' => 'Door style'],
                    ['key' => 'weight', 'label' => 'Weight', 'type' => 'weight'],
                    ['key' => 'cost', 'label' => 'Price', 'type' => 'currency'],
                    ['key' => 'assemble_cost', 'label' => 'Assemble cost', 'type' => 'currency'],
                    ['key' => 'qty', 'label' => 'Qty'],
                    ['key' => 'description', 'label' => 'Description'],
                    ['key' => 'image_url', 'label' => 'Image', 'type' => 'image'],
                ],
                'fields' => [
                    [
                        'name' => 'catalog_id',
                        'label' => 'Catalog',
                        'type' => 'select',
                        'options' => 'catalogs',
                        'required' => true,
                        'tip' => 'Product catalog this item belongs to (pricing and visibility).',
                    ],
                    [
                        'name' => 'section_id',
                        'label' => 'Category / Cabinet Section',
                        'type' => 'select',
                        'options' => 'categories',
                        'required' => true,
                        'tip' => 'Cabinet category or section within the catalog.',
                    ],
                    [
                        'name' => 'door_color_id',
                        'label' => 'Door style',
                        'type' => 'select',
                        'options' => 'door_styles',
                        'required' => true,
                        'tip' => 'Door style / color variant for this product.',
                    ],
                    [
                        'name' => 'label',
                        'label' => 'Product label',
                        'required' => true,
                        'placeholder' => 'Enter product label, e.g. Wall Cabinet',
                        'tip' => 'Display name shown in quotes, orders, and product lists.',
                    ],
                    [
                        'name' => 'sku',
                        'label' => 'SKU',
                        'required' => true,
                        'placeholder' => 'Enter SKU, e.g. A-Bt9',
                        'tip' => 'Stock keeping unit — unique product identifier.',
                    ],
                    [
                        'name' => 'weight',
                        'label' => 'Weight',
                        'type' => 'number',
                        'step' => 'any',
                        'min' => 0,
                        'suffix' => 'lbs',
                        'required' => true,
                        'placeholder' => 'e.g. 38.5',
                        'tip' => 'Shipping weight in pounds (decimals allowed).',
                    ],
                    [
                        'name' => 'cost',
                        'label' => 'Price',
                        'type' => 'number',
                        'step' => 'any',
                        'min' => 0,
                        'prefix' => '$',
                        'required' => true,
                        'placeholder' => 'e.g. 201.60',
                        'tip' => 'Product price in US dollars (decimals allowed).',
                    ],
                    [
                        'name' => 'assemble_cost',
                        'label' => 'Assemble cost',
                        'type' => 'number',
                        'step' => 'any',
                        'min' => 0,
                        'prefix' => '$',
                        'placeholder' => 'e.g. 20.00',
                        'tip' => 'Optional assembly labor cost added to the product.',
                    ],
                    [
                        'name' => 'qty',
                        'label' => 'Quantity',
                        'type' => 'number',
                        'placeholder' => 'Enter quantity, e.g. 1',
                        'tip' => 'Default quantity per unit (usually 1).',
                    ],
                    [
                        'name' => 'description',
                        'label' => 'Details',
                        'type' => 'textarea',
                        'full' => true,
                        'placeholder' => 'Enter optional product details',
                        'tip' => 'Detailed product description for staff and customers.',
                    ],
                    [
                        'name' => 'image',
                        'label' => 'Image',
                        'type' => 'media',
                        'mediaType' => 'image',
                        'accept' => 'image/*',
                        'full' => true,
                        'tip' => 'Upload a schematic product image or paste a direct https:// link.',
                        'hint' => MediaUpload::hint(),
                        'urlPlaceholder' => 'https://example.com/product.webp',
                        'urlTip' => 'Paste a direct https:// URL to an image file hosted online.',
                    ],
                ],
            ],
        ];

        if (! isset($configs[$type])) {
            throw new \InvalidArgumentException('Unknown product setup type: '.$type);
        }

        $config = $configs[$type];
        $config['csrf'] = csrf_token();
        $config['api'] = [
            'index' => route('tenant_product_setup_api_index', ['type' => $type]),
            'meta' => route('tenant_product_setup_api_meta', ['type' => $type]),
            'store' => route('tenant_product_setup_api_store', ['type' => $type]),
            'show' => route('tenant_product_setup_api_show', ['type' => $type, 'id' => '__ID__']),
            'update' => route('tenant_product_setup_api_update', ['type' => $type, 'id' => '__ID__']),
            'destroy' => route('tenant_product_setup_api_destroy', ['type' => $type, 'id' => '__ID__']),
        ];

        if ($type === 'products') {
            $config['deactivateAllUrl'] = route('tenant_product_setup_deactivate_all');
        }

        return $config;
    }
}
