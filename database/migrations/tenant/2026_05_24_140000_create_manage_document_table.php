<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('manage_document')) {
            return;
        }

        Schema::create('manage_document', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_type');
            $table->text('document_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manage_document');
    }
};
