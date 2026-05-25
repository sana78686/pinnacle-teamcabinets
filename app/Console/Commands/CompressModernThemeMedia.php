<?php

namespace App\Console\Commands;

use App\Services\StorefrontMediaOptimizer;
use Illuminate\Console\Command;

class CompressModernThemeMedia extends Command
{
    protected $signature = 'storefront:compress-modern-media {--videos : Also compress MP4 files when ffmpeg is available}';

    protected $description = 'Compress Modern theme default images (and optionally videos) under public/themes/modern/media';

    public function handle(StorefrontMediaOptimizer $optimizer): int
    {
        $dir = public_path('themes/modern/media');
        $logs = $optimizer->optimizeDirectory($dir, (bool) $this->option('videos'));

        if ($logs === []) {
            $this->warn('No files optimized.');

            return self::SUCCESS;
        }

        foreach ($logs as $line) {
            $this->line($line);
        }

        $this->info('Done. '.count($logs).' file(s) processed.');

        return self::SUCCESS;
    }
}
