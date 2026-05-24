<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('manage_commissions')) {
            return;
        }

        Schema::create('manage_commissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->decimal('gross_sales', 12, 4)->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        if (Schema::hasTable('users')) {
            $now = now();
            DB::table('users')
                ->select('id')
                ->orderBy('id')
                ->chunkById(200, function ($users) use ($now) {
                    $rows = [];
                    foreach ($users as $user) {
                        $rows[] = [
                            'user_id' => $user->id,
                            'gross_sales' => 0,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];
                    }
                    if ($rows !== []) {
                        DB::table('manage_commissions')->insertOrIgnore($rows);
                    }
                });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('manage_commissions');
    }
};
