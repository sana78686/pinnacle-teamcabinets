<?php

return [
    'hear_about_options' => [
        '' => 'Please select',
        'search_engine' => 'Search engine (Google, Bing, etc.)',
        'social_media' => 'Social media',
        'referral' => 'Friend or colleague referral',
        'trade_show' => 'Trade show or event',
        'dealer' => 'Dealer or showroom',
        'advertisement' => 'Advertisement',
        'other' => 'Other',
    ],

    'best_contact_options' => [
        '' => 'Please select',
        'email' => 'Email',
        'phone' => 'Phone',
        'text' => 'Text message',
        'either' => 'Email or phone',
    ],

    /** Top-level slugs managed outside custom CMS list. */
    'reserved_slugs' => [
        'about',
        'about-us',
        'contact',
        'contact-us',
        'blog',
        'terms-and-conditions',
        'privacy-policy',
        'cookie-policy',
        'shipping-policy',
        'return-policy',
    ],

    /**
     * Legal / policy pages — edited under Website Designing → Legal pages.
     * Shown on the storefront when published with content.
     */
    'legal_pages' => [
        'terms-and-conditions' => [
            'title' => 'Terms & Conditions',
            'menu_label' => 'Terms',
            'tax_key' => 'terms_and_conditions',
            'in_header' => true,
            'default_content' => '<p>Update your membership terms and conditions here. This content appears on your public Terms &amp; Conditions page.</p>',
        ],
        'privacy-policy' => [
            'title' => 'Privacy Policy',
            'menu_label' => 'Privacy',
            'in_header' => true,
            'default_content' => '<p>Describe how you collect, use, and protect customer and dealer information.</p>',
        ],
        'cookie-policy' => [
            'title' => 'Cookie Policy',
            'menu_label' => 'Cookies',
            'in_header' => false,
            'default_content' => '<p>Explain which cookies your storefront uses and how visitors can manage preferences.</p>',
        ],
        'shipping-policy' => [
            'title' => 'Shipping Policy',
            'menu_label' => 'Shipping',
            'in_header' => false,
            'default_content' => '<p>Outline shipping regions, lead times, and freight responsibilities.</p>',
        ],
        'return-policy' => [
            'title' => 'Return Policy',
            'menu_label' => 'Returns',
            'in_header' => false,
            'default_content' => '<p>Describe return eligibility, timelines, and claim procedures.</p>',
        ],
    ],
];
