<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->string('subscription_status')->default('trial')->after('phone');
            $table->timestamp('trial_ends_at')->nullable()->after('subscription_status');
            $table->timestamp('subscription_ends_at')->nullable()->after('trial_ends_at');
            $table->boolean('is_complimentary')->default(false)->after('subscription_ends_at');
            $table->timestamp('complimentary_ends_at')->nullable()->after('is_complimentary');
            $table->string('stripe_customer_id')->nullable()->after('complimentary_ends_at');
            $table->string('stripe_subscription_id')->nullable()->after('stripe_customer_id');
        });

        $trialDays = (int) config('pinnacle.trial_days', 14);
        \Illuminate\Support\Facades\DB::table('tenants')
            ->whereNull('trial_ends_at')
            ->update([
                'subscription_status' => 'trial',
                'trial_ends_at' => now()->addDays($trialDays),
            ]);
    }

    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn([
                'subscription_status',
                'trial_ends_at',
                'subscription_ends_at',
                'is_complimentary',
                'complimentary_ends_at',
                'stripe_customer_id',
                'stripe_subscription_id',
            ]);
        });
    }
};
