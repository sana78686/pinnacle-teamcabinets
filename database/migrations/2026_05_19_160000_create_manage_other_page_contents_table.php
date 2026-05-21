<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('manage_other_page_contents')) {
            Schema::create('manage_other_page_contents', function (Blueprint $table) {
                $table->id();
                $table->string('tenant_id', 36);
                $table->string('slug', 64);
                $table->string('title', 200);
                $table->longText('page_content')->nullable();
                $table->timestamps();

                $table->unique(['tenant_id', 'slug']);
                $table->foreign('tenant_id')
                    ->references('id')->on('tenants')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('manage_other_page_contents');
    }
};
