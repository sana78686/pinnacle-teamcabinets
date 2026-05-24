<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('support_threads')) {
            return;
        }

        Schema::create('support_threads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
        });

        Schema::create('support_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('support_thread_id')->constrained('support_threads')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('message');
            $table->string('attachment_path', 500)->nullable();
            $table->string('attachment_name', 255)->nullable();
            $table->unsignedTinyInteger('is_read')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_messages');
        Schema::dropIfExists('support_threads');
    }
};
