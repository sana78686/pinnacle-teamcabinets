<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    if (! Schema::hasTable('users')) {
      return;
    }

    Schema::table('users', function (Blueprint $table) {
      if (! Schema::hasColumn('users', 'note')) {
        $table->text('note')->nullable()->after('address');
      }
      if (! Schema::hasColumn('users', 'gross_sale')) {
        $table->string('gross_sale', 50)->nullable()->after('note');
      }
    });
  }

  public function down(): void
  {
    if (! Schema::hasTable('users')) {
      return;
    }

    Schema::table('users', function (Blueprint $table) {
      $drops = [];
      foreach (['note', 'gross_sale'] as $col) {
        if (Schema::hasColumn('users', $col)) {
          $drops[] = $col;
        }
      }
      if ($drops !== []) {
        $table->dropColumn($drops);
      }
    });
  }
};
