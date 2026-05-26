<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Mirror: database/migrations/tenant/2026_05_26_130000_add_checkout_fields_to_orders_table.php
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('orders')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'fuel_charges')) {
                $table->decimal('fuel_charges', 12, 2)->default(0)->after('fuel_tax');
            }
            if (! Schema::hasColumn('orders', 'fuel_charges_pertcentage')) {
                $table->string('fuel_charges_pertcentage', 50)->nullable()->after('fuel_charges');
            }
            if (! Schema::hasColumn('orders', 'sales_tax')) {
                $table->string('sales_tax', 50)->nullable()->after('fuel_charges_pertcentage');
            }
            if (! Schema::hasColumn('orders', 'order_amount')) {
                $table->decimal('order_amount', 12, 2)->nullable()->after('grand_total_cost');
            }
            if (! Schema::hasColumn('orders', 'amount')) {
                $table->decimal('amount', 12, 2)->nullable()->after('order_amount');
            }
            if (! Schema::hasColumn('orders', 'tax')) {
                $table->decimal('tax', 12, 2)->nullable()->after('amount');
            }
            if (! Schema::hasColumn('orders', 'order_payment_type')) {
                $table->string('order_payment_type', 100)->nullable()->after('shipping_cost');
            }
            if (! Schema::hasColumn('orders', 'transaction_pro_id')) {
                $table->string('transaction_pro_id', 255)->nullable()->after('order_payment_type');
            }
            if (! Schema::hasColumn('orders', 'status')) {
                $table->string('status', 50)->default('PENDING')->after('transaction_pro_id');
            }
            if (! Schema::hasColumn('orders', 'paytrace_response')) {
                $table->text('paytrace_response')->nullable()->after('status');
            }
            if (! Schema::hasColumn('orders', 'credit_card_charges')) {
                $table->decimal('credit_card_charges', 12, 2)->default(0)->after('paytrace_response');
            }
            if (! Schema::hasColumn('orders', 'debit_card_charges')) {
                $table->decimal('debit_card_charges', 12, 2)->default(0)->after('credit_card_charges');
            }
            if (! Schema::hasColumn('orders', 'ach_charges')) {
                $table->decimal('ach_charges', 12, 2)->default(0)->after('debit_card_charges');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('orders')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            foreach ([
                'fuel_charges',
                'fuel_charges_pertcentage',
                'sales_tax',
                'order_amount',
                'amount',
                'tax',
                'order_payment_type',
                'transaction_pro_id',
                'status',
                'paytrace_response',
                'credit_card_charges',
                'debit_card_charges',
                'ach_charges',
            ] as $col) {
                if (Schema::hasColumn('orders', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
