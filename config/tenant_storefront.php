<?php

return [
    'reserved_slugs' => [
        'about', 'about-us', 'blog', 'contact', 'contact-us',
        'terms-and-conditions', 'terms', 'shipping-quote-terms', 'privacy-policy',
    ],

    /**
     * Legal pages: CMS page slug wins if published with content; else tax_values HTML.
     */
    'legal_pages' => [
        'terms-and-conditions' => [
            'title' => 'Terms & Conditions',
            'menu_label' => 'Terms',
            'tax_key' => 'terms_and_conditions',
        ],
        'shipping-quote-terms' => [
            'title' => 'Shipping Quote Terms',
            'menu_label' => 'Shipping terms',
            'tax_key' => 'ship_quote_terms_and_condition',
        ],
    ],
];
