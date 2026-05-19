<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaxValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tax_values')->insert([
            [
                'id' => 1,
                'option_key' => 'sales_tax_percentage',
                'option_value' => '0',
                'field_label' => 'Sales Tax (percentage)',
                'updated_at' => now(),
                'tenant_id' => 'tenant1',
            ],
            [
                'id' => 2,
                'option_key' => 'terms_and_conditions',
                'option_value' => '<h1><strong>Membership</strong></h1> ...', // Truncated for readability
                'field_label' => '',
                'updated_at' => now(),
                'tenant_id' => 'tenant1',
            ],
            [
                'id' => 3,
                'option_key' => 'credit_card_charges',
                'option_value' => '3',
                'field_label' => 'Credit Card Charges',
                'updated_at' => now(),
                'tenant_id' => 'tenant1',
            ],
            [
                'id' => 4,
                'option_key' => 'ach_pay_charges',
                'option_value' => '10.00',
                'field_label' => 'ACH Charges',
                'updated_at' => now(),
                'tenant_id' => 'tenant1',
            ],
            [
                'id' => 5,
                'option_key' => 'debit_card_charges',
                'option_value' => '0.50',
                'field_label' => 'Debit Card Charges',
                'updated_at' => now(),
                'tenant_id' => 'tenant1',
            ],
            [
                'id' => 6,
                'option_key' => 'ship_quote_terms_and_condition',
                'option_value' => '<h1><strong>Membership</strong></h1> ...', // Truncated for readability
                'field_label' => 'Ship Quote Terms And Conditions',
                'updated_at' => now(),
                'tenant_id' => 'tenant1',
            ],
            [
                'id' => 7,
                'option_key' => 'paytrace_password',
                'option_value' => '!nXmkcqH6Ub8ygm',
                'field_label' => 'Paytrace Password',
                'updated_at' => now(),
                'tenant_id' => 'tenant1',
            ],
            [
                'id' => 8,
                'option_key' => 'fuel_charges_value',
                'option_value' => '2',
                'field_label' => 'Fuel Charges Setting',
                'updated_at' => now(),
                'tenant_id' => 'tenant1',
            ],
        ]);
    }
}
