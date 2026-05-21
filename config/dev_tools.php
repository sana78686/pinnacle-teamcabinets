<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Dev database setup (web route)
    |--------------------------------------------------------------------------
    |
    | Set DEV_SETUP_TOKEN in .env, then visit:
    | /dev/migrate-fresh-seed?token=YOUR_TOKEN
    |
    | Disabled in production unless DEV_SETUP_ALLOW_PRODUCTION=true.
    |
    */
    'setup_token' => env('DEV_SETUP_TOKEN'),

    'allow_in_production' => (bool) env('DEV_SETUP_ALLOW_PRODUCTION', false),

    /** Also run TenantSeeder then migrate/seed all tenant databases. */
    'seed_demo_tenants' => (bool) env('DEV_SETUP_SEED_DEMO_TENANTS', false),

    /** After tenant migrate, seed Team Cabinets taxes, terms, and commission defaults. */
    'seed_team_cabinets_defaults' => (bool) env('DEV_SETUP_SEED_TEAM_CABINETS', true),

];
