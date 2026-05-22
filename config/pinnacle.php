<?php

return [

    'name' => 'Pinnacle',

    /** Static branding for emails when tenant has no Site Settings logo/name. */
    'email' => [
        'logo' => 'assets/logo/pinnacle-tenant.png',
    ],

    'tagline' => 'Launch your cabinets business in minutes',
    'trial_days' => 14,

    /**
     * Static copy shown on the tenant portal (not editable per tenant).
     * Override via .env for deployment-specific wording.
     */
    'portal' => [
        'registration_success_message' => env(
            'PINNACLE_REGISTRATION_SUCCESS_MESSAGE',
            'Welcome to Pinnacle! Your dealer account has been created. Sign in below to configure your site, catalog, and team.'
        ),
        'dashboard_welcome_title' => env(
            'PINNACLE_DASHBOARD_WELCOME_TITLE',
            'Welcome to Pinnacle'
        ),
        'dashboard_welcome_body' => env(
            'PINNACLE_DASHBOARD_WELCOME_BODY',
            'Your account is active on a free trial.'
        ),
    ],
    'support_email' => env('PINNACLE_SUPPORT_EMAIL', 'support@pinnacle.example.com'),
    'powered_by' => env('PINNACLE_POWERED_BY', 'apimstec'),

    'contact' => [
        'phone' => env('PINNACLE_PHONE', '(800) 555-0199'),
        'address' => env('PINNACLE_ADDRESS', '123 Cabinet Way, Suite 100, Dallas, TX 75201, USA'),
        'hours' => env('PINNACLE_HOURS', 'Monday – Friday, 8:00 AM – 5:00 PM CST'),
        'map_embed' => env('PINNACLE_MAP_EMBED', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d214586.4463501924!2d-96.89670465!3d32.82087565!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x864ea0e446f0f8b1%3A0x94b07e325b4075f8!2sDallas%2C%20TX!5e0!3m2!1sen!2sus!4v1710000000000!5m2!1sen!2sus'),
    ],

    'flagship_tenant' => [
        'name' => 'Team Cabinets',
        'slug' => 'team-cabinets',
        'description' => 'Our flagship tenant — a full cabinets ordering platform migrated from the proven Team Cabinets system onto modern dedicated tenant infrastructure.',
    ],

    'service_groups' => [
        [
            'title' => 'Public website & CMS',
            'description' => 'Each tenant gets a branded public site with pages you control — home, about, contact, and custom content.',
            'items' => [
                'Custom homepage & page builder (CMS)',
                'About Us & Contact Us management',
                'Terms & conditions on your site',
                'Contact form with email notifications',
            ],
        ],
        [
            'title' => 'Dealer & affiliate portal',
            'description' => 'Role-based access for your team, dealers, and affiliates — the same hierarchy Team Cabinets has used for years.',
            'items' => [
                'User management with roles & permissions',
                'Parent/child affiliate (dealer) accounts',
                'Profile, password & account verification (OTP)',
                'CSV import/export for users and roles',
            ],
        ],
        [
            'title' => 'Products & catalog',
            'description' => 'Manage cabinets, catalogs, sections, and door styles — synced with your business rules.',
            'items' => [
                'Cabinets product catalog',
                'Product sections & door styles',
                'Product catalog browsing for orders',
                'QuickBooks product ID mapping',
            ],
        ],
        [
            'title' => 'Orders & cart',
            'description' => 'End-to-end ordering workflow from catalog selection through multi-step checkout.',
            'items' => [
                'Multi-step order creation',
                'Session cart with rooms & job names',
                'Order list, tracking & warehouse pick lists',
                'Order import/export',
            ],
        ],
        [
            'title' => 'Quotes & shipping',
            'description' => 'Request and manage quotes before orders are placed.',
            'items' => [
                'Customer quotes',
                'Shipping quotes',
                'Stock check requests',
            ],
        ],
        [
            'title' => 'Operations & reporting',
            'description' => 'Back-office tools migrated from the Team Cabinets admin portal.',
            'items' => [
                'Claims management',
                'Bulletins & announcements',
                'Commission reports',
                'Tax, commission & shipping totals',
                'Document library for dealers',
            ],
        ],
        [
            'title' => 'Payments & accounting',
            'description' => 'Financial tools built for cabinet distributors.',
            'items' => [
                'QuickBooks integration',
                'Credit/debit/ACH charge settings',
                'Sales tax management',
                'Fuel surcharge settings',
                'Paytrace payment configuration',
            ],
        ],
        [
            'title' => 'Platform & admin settings',
            'description' => 'Everything needed to run your tenant without touching code.',
            'items' => [
                'SMTP & transactional email templates',
                'Success/error page content',
                'Credit & payment messaging',
                'Point factor / pricing rules',
                'Per-tenant isolated database',
            ],
        ],
    ],

    'highlights' => [
        [
            'title' => 'Live in minutes',
            'body' => 'Get your own website and admin panel on a dedicated subdomain in minutes — ready to onboard dealers.',
        ],
        [
            'title' => '2-week free trial',
            'body' => 'Explore the full platform free for 14 days when you register through Pinnacle.',
        ],
        [
            'title' => 'QuickBooks ready',
            'body' => 'Products and orders align with QuickBooks so your books stay in sync with cabinet sales.',
        ],
        [
            'title' => 'Proven workflow',
            'body' => 'Built from the production Team Cabinets system — orders, quotes, affiliates, and claims included.',
        ],
    ],

    /**
     * Marketing page visuals — use image when file exists under public/, else CSS color block.
     */
    'visuals' => [
        'hero' => [
            'path' => 'assets/pinnacle/hero-kitchen.jpg',
            'label' => 'Cabinet showroom',
            'gradient' => 'linear-gradient(145deg, #0c2340 0%, #1e4976 45%, #3d6b9a 100%)',
        ],
        'showcase_dealer' => [
            'path' => 'assets/pinnacle/showcase-dealer.jpg',
            'label' => 'Dealer catalog',
            'gradient' => 'linear-gradient(145deg, #2a4a6b 0%, #4a7ab0 50%, #c5a028 100%)',
        ],
        'showcase_catalog' => [
            'path' => 'assets/pinnacle/showcase-catalog.jpg',
            'label' => 'Product catalog',
            'gradient' => 'linear-gradient(145deg, #1a3352 0%, #2d5a87 60%, #8b7355 100%)',
        ],
        'flagship_logo' => [
            'path' => 'assets/logo/team_cabinets.jpg',
            'label' => 'Team Cabinets',
            'gradient' => 'linear-gradient(160deg, #0c2340, #1e4976)',
        ],
    ],

    'what_we_sell' => [
        [
            'title' => 'Branded dealer website',
            'description' => 'Public catalog, quotes, and contact — your brand, your domain.',
            'icon' => 'website',
        ],
        [
            'title' => 'Management panel',
            'description' => 'Orders, users, products, claims, and reports in one admin portal.',
            'icon' => 'panel',
        ],
        [
            'title' => 'Dealer & affiliate network',
            'description' => 'Roles, child accounts, commissions, and document sharing.',
            'icon' => 'dealers',
        ],
        [
            'title' => 'QuickBooks sync',
            'description' => 'Map products and keep accounting aligned with cabinet sales.',
            'icon' => 'quickbooks',
        ],
    ],

];
