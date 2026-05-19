<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('pinnacle_settings');
    }

    public function down(): void
    {
        // Intentionally empty — platform branding is static (config/pinnacle.php).
    }
};
