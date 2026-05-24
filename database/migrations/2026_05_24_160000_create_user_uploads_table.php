<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('user_uploads')) {
            return;
        }

        Schema::create('user_uploads', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->text('file_name');
            $table->string('description', 251);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_uploads');
    }
};
