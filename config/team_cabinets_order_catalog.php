<?php

/**
 * Team Cabinets order catalog seed (CI-aligned categories).
 */
return [
    'catalogs' => [
        [
            'name' => 'TEAM CABINETS',
            'slug' => 'team-cabinets',
            'image' => null,
            'pdf' => null,
            'doors' => [
                ['label' => 'Shaker White', 'image' => null],
                ['label' => 'Shaker Gray', 'image' => null],
                ['label' => 'Espresso', 'image' => null],
            ],
        ],
        [
            'name' => 'ARTSTAR',
            'slug' => 'artstar',
            'image' => null,
            'pdf' => null,
            'doors' => [
                ['label' => 'Shaker White', 'image' => null],
                ['label' => 'Classic Cherry', 'image' => null],
            ],
        ],
    ],
    'sections' => [
        'Base Cabinets',
        'Wall Cabinets',
        'Tall Cabinets',
        'Moldings',
        'Vanity Cabinets',
        'Fillers',
        'Accessories',
        'Panels',
        'Samples Doors',
    ],
    /** section_name => sample products */
    'sample_products' => [
        'Base Cabinets' => [
            ['label' => 'Base 12"', 'sku' => 'B12', 'description' => 'W12 D24 H34.5', 'weight' => '42', 'cost' => '185.00', 'assemble_cost' => '15', 'qty' => '999'],
            ['label' => 'Base 18"', 'sku' => 'B18', 'description' => 'W18 D24 H34.5', 'weight' => '48', 'cost' => '210.00', 'assemble_cost' => '15', 'qty' => '999'],
            ['label' => 'Base 24"', 'sku' => 'B24', 'description' => 'W24 D24 H34.5', 'weight' => '55', 'cost' => '245.00', 'assemble_cost' => '18', 'qty' => '999'],
            ['label' => 'Sink Base 36"', 'sku' => 'SB36', 'description' => 'W36 D24 H34.5', 'weight' => '72', 'cost' => '320.00', 'assemble_cost' => '22', 'qty' => '999'],
        ],
        'Wall Cabinets' => [
            ['label' => 'Wall 12"', 'sku' => 'W12', 'description' => 'W12 D12 H30', 'weight' => '28', 'cost' => '125.00', 'assemble_cost' => '12', 'qty' => '999'],
            ['label' => 'Wall 24"', 'sku' => 'W24', 'description' => 'W24 D12 H30', 'weight' => '38', 'cost' => '165.00', 'assemble_cost' => '12', 'qty' => '999'],
            ['label' => 'Wall 30"', 'sku' => 'W30', 'description' => 'W30 D12 H42', 'weight' => '45', 'cost' => '198.00', 'assemble_cost' => '14', 'qty' => '999'],
        ],
        'Tall Cabinets' => [
            ['label' => 'Pantry 18"', 'sku' => 'P18', 'description' => 'W18 D24 H84', 'weight' => '95', 'cost' => '425.00', 'assemble_cost' => '28', 'qty' => '999'],
            ['label' => 'Pantry 24"', 'sku' => 'P24', 'description' => 'W24 D24 H84', 'weight' => '110', 'cost' => '495.00', 'assemble_cost' => '32', 'qty' => '999'],
        ],
        'Moldings' => [
            ['label' => 'Crown Molding 8ft', 'sku' => 'CM8', 'description' => 'Crown 8 linear ft', 'weight' => '6', 'cost' => '48.00', 'assemble_cost' => '0', 'qty' => '999'],
            ['label' => 'Light Rail 8ft', 'sku' => 'LR8', 'description' => 'Light rail 8 linear ft', 'weight' => '4', 'cost' => '32.00', 'assemble_cost' => '0', 'qty' => '999'],
        ],
        'Vanity Cabinets' => [
            ['label' => 'Vanity 24"', 'sku' => 'V24', 'description' => 'W24 D21 H34.5', 'weight' => '50', 'cost' => '220.00', 'assemble_cost' => '16', 'qty' => '999'],
            ['label' => 'Vanity 30"', 'sku' => 'V30', 'description' => 'W30 D21 H34.5', 'weight' => '58', 'cost' => '265.00', 'assemble_cost' => '18', 'qty' => '999'],
        ],
        'Fillers' => [
            ['label' => 'Filler 3"', 'sku' => 'F3', 'description' => 'W3 filler panel', 'weight' => '8', 'cost' => '35.00', 'assemble_cost' => '0', 'qty' => '999'],
            ['label' => 'Filler 6"', 'sku' => 'F6', 'description' => 'W6 filler panel', 'weight' => '12', 'cost' => '52.00', 'assemble_cost' => '0', 'qty' => '999'],
        ],
        'Accessories' => [
            ['label' => 'Trash Pullout', 'sku' => 'TP18', 'description' => 'Base trash pullout', 'weight' => '15', 'cost' => '89.00', 'assemble_cost' => '8', 'qty' => '999'],
            ['label' => 'Spice Rack', 'sku' => 'SR9', 'description' => 'Base spice rack', 'weight' => '10', 'cost' => '65.00', 'assemble_cost' => '6', 'qty' => '999'],
        ],
        'Panels' => [
            ['label' => 'End Panel 24"', 'sku' => 'EP24', 'description' => 'Finished end panel', 'weight' => '22', 'cost' => '78.00', 'assemble_cost' => '0', 'qty' => '999'],
            ['label' => 'Back Panel 30"', 'sku' => 'BP30', 'description' => 'Back panel 30H', 'weight' => '18', 'cost' => '62.00', 'assemble_cost' => '0', 'qty' => '999'],
        ],
        'Samples Doors' => [
            ['label' => 'Sample Door', 'sku' => 'SW-Sample', 'description' => 'Shaker White sample door', 'weight' => '7', 'cost' => '0.00', 'assemble_cost' => '0', 'qty' => '999'],
        ],
    ],
];
