<?php

namespace Database\Seeders;

use App\Services\ManageEmailsContentService;
use Illuminate\Database\Seeder;

class ManageEmailsContentSeeder extends Seeder
{
    /**
     * CI Team Cabinets email templates (manage_emails_content).
     */
    public function run(): void
    {
        app(ManageEmailsContentService::class)->ensureDefaults();
    }
}
