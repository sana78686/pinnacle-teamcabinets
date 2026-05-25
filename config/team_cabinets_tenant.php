<?php

/**
 * Defaults for the Team Cabinets tenant (local/staging).
 * Seeded by TeamCabinetsTenantDataSeeder when running tenant seed for this ID.
 */
return [

    'tenant_id' => env('TEAM_CABINETS_TENANT_ID', 'team-cabinets'),

    'taxes' => [
        'sales_tax_percentage' => '0',
        'credit_card_charges' => '3',
        'debit_card_charges' => '0.50',
        'ach_pay_charges' => '10.00',
        'fuel_charges_value' => '2',
        'commercial_delivery_charge' => '75',
        'liftgate_charge' => '150',
        'unload_charge' => '150',
        'pallet_cost' => '30',
    ],

    /** Legacy CI role commission defaults (point factor as decimal). Matches CI add_point_factor form. */
    'commission_defaults_by_role' => [
        'representatives' => '0.20',
        'distributors' => '0.24',
        'dealers' => '0.24',
        'showrooms' => '0.24',
    ],

    /** Legacy plural keys (kept for seeders / imports). */
    'point_factors' => [
        'representatives' => '0.20',
        'distributors' => '0.24',
        'dealers' => '0.24',
        'showrooms' => '0.24',
        'manufacture' => '0.165',
        'affiliate' => '0.24',
        'sub-affiliate' => '0.24',
    ],

    /** tax_values option_key => HTML file under database/seeders/data/ */
    'terms_files' => [
        'terms_and_conditions' => 'team_cabinets_terms_and_conditions.html',
        'ship_quote_terms_and_condition' => 'team_cabinets_ship_quote_terms.html',
    ],

];
