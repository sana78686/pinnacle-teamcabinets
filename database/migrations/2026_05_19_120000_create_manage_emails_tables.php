<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('manage_emails_content')) {
            Schema::create('manage_emails_content', function (Blueprint $table) {
                $table->id();
                $table->string('email_slug')->unique();
                $table->string('email_type', 200);
                $table->string('email_subject');
                $table->text('email_content');
                $table->string('macro')->default('');
                $table->unsignedBigInteger('email_from')->default(0);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('manage_emails_details')) {
            Schema::create('manage_emails_details', function (Blueprint $table) {
                $table->id();
                $table->string('smtp_host', 200);
                $table->string('smtp_user', 200);
                $table->string('smtp_pass', 200);
                $table->string('smtp_port', 11)->default('587');
                $table->string('smtp_encryption', 45)->default('tls');
                $table->string('smtp_from_email', 200);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('manage_emails_details');
        Schema::dropIfExists('manage_emails_content');
    }
};
