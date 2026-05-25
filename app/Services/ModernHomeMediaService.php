<?php

namespace App\Services;

use App\Models\HomeSetting;
use App\Support\PublicUploadedFile;

class ModernHomeMediaService
{
    public function __construct(
        protected StorefrontMediaOptimizer $optimizer,
    ) {}

    /** @return array<string, mixed> */
    public function resolve(?HomeSetting $settings = null): array
    {
        $settings ??= HomeSetting::forCurrentTenant();
        $defaults = config('tenant_modern_home', []);
        $interval = (int) ($settings->modern_slideshow_interval_ms ?? $defaults['slideshow_interval_ms'] ?? 2000);
        $interval = max(1000, min(10000, $interval));

        return [
            'hero_video' => $this->mediaUrl($settings->modern_hero_video ?? null, $defaults['hero_video'] ?? ''),
            'hero_poster' => $this->mediaUrl($settings->modern_hero_poster ?? null, $defaults['hero_poster'] ?? ''),
            'factory_video' => $this->mediaUrl($settings->modern_factory_video ?? null, $defaults['factory_video'] ?? ''),
            'factory_poster' => $this->mediaUrl($settings->modern_factory_poster ?? null, $defaults['factory_poster'] ?? ''),
            'slideshow_interval_ms' => $interval,
            'door_styles' => $defaults['door_styles'] ?? [],
            'finish_options' => $defaults['finish_options'] ?? [],
            'gallery' => $defaults['gallery'] ?? [],
        ];
    }

    public function mediaUrl(?string $customPath, string $defaultRelative): string
    {
        if ($customPath) {
            if (PublicUploadedFile::isExternalUrl($customPath)) {
                return $customPath;
            }

            return tenant_media_url($customPath) ?? tenant_static_asset('themes/modern/media/'.$defaultRelative);
        }

        return tenant_static_asset('themes/modern/media/'.$defaultRelative);
    }

    public function storeUploadedMedia(?string $path): ?string
    {
        if (! $path || PublicUploadedFile::isExternalUrl($path)) {
            return $path;
        }

        $absolute = public_path(ltrim(str_replace('\\', '/', $path), '/'));
        if (! is_file($absolute)) {
            return $path;
        }

        $ext = strtolower(pathinfo($absolute, PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
            $this->optimizer->optimizeImage($absolute);
        } elseif ($ext === 'mp4') {
            $this->optimizer->optimizeVideo($absolute);
        }

        return $path;
    }
}
