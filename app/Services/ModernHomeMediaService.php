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
            'hero_video' => $this->resolveHeroVideo($settings, $defaults),
            'hero_poster' => $this->resolveHeroPoster($settings, $defaults),
            'factory_video' => $this->mediaUrl($settings->modern_factory_video ?? null, $defaults['factory_video'] ?? ''),
            'factory_poster' => $this->resolveFactoryPoster($settings, $defaults),
            'slideshow_interval_ms' => $interval,
            'door_styles' => $defaults['door_styles'] ?? [],
            'finish_options' => $defaults['finish_options'] ?? [],
            'gallery' => $defaults['gallery'] ?? [],
            'content' => $this->content($settings),
        ];
    }

    /** @return array<string, string> */
    public function content(?HomeSetting $settings = null): array
    {
        $settings ??= HomeSetting::forCurrentTenant();
        $d = config('tenant_modern_home.content_defaults', []);
        $company = (string) (tenant('company_name') ?? tenant('name') ?? 'Your business');
        $fill = fn (?string $value, string $key) => $this->filledOrDefault($value, $d[$key] ?? '', $company);

        return [
            'style_intro_title' => $fill($settings->card_three_title, 'style_intro_title'),
            'style_intro_body' => $fill($settings->card_three_description, 'style_intro_body'),
            'door_title' => $fill($settings->card_one_title, 'door_title'),
            'door_body' => $fill($settings->card_one_description, 'door_body'),
            'finish_title' => $fill($settings->card_two_title, 'finish_title'),
            'finish_body' => $fill($settings->card_two_description, 'finish_body'),
            'factory_title' => $fill($settings->aboutus_title, 'factory_title'),
            'factory_body' => $fill($settings->aboutus_description, 'factory_body'),
            'gallery_title' => $fill(null, 'gallery_title'),
            'cta_one_title' => $fill(null, 'cta_one_title'),
            'cta_one_body' => $fill(null, 'cta_one_body'),
            'cta_one_label' => $fill(null, 'cta_one_label'),
            'cta_two_title' => $fill(null, 'cta_two_title'),
            'cta_two_body' => $fill(null, 'cta_two_body'),
            'cta_two_label' => $fill(null, 'cta_two_label'),
        ];
    }

    protected function filledOrDefault(?string $value, string $default, string $company): string
    {
        $text = trim((string) $value);

        if ($text !== '') {
            return str_replace('{company}', $company, $text);
        }

        return str_replace('{company}', $company, $default);
    }

    /** @param  array<string, mixed>  $defaults */
    protected function resolveHeroVideo(HomeSetting $settings, array $defaults): string
    {
        if ($this->isVideoPath($settings->banner_image)) {
            return $this->uploadedUrl($settings->banner_image, $defaults['hero_video'] ?? '');
        }

        return $this->mediaUrl($settings->modern_hero_video ?? null, $defaults['hero_video'] ?? '');
    }

    /** @param  array<string, mixed>  $defaults */
    protected function resolveHeroPoster(HomeSetting $settings, array $defaults): string
    {
        if ($settings->modern_hero_poster) {
            return $this->mediaUrl($settings->modern_hero_poster, $defaults['hero_poster'] ?? '');
        }

        if ($this->isImagePath($settings->banner_image)) {
            return $this->uploadedUrl($settings->banner_image, $defaults['hero_poster'] ?? '');
        }

        return $this->mediaUrl(null, $defaults['hero_poster'] ?? '');
    }

    /** @param  array<string, mixed>  $defaults */
    protected function resolveFactoryPoster(HomeSetting $settings, array $defaults): string
    {
        if ($settings->modern_factory_poster) {
            return $this->mediaUrl($settings->modern_factory_poster, $defaults['factory_poster'] ?? '');
        }

        if ($this->isImagePath($settings->aboutus_image)) {
            return $this->uploadedUrl($settings->aboutus_image, $defaults['factory_poster'] ?? '');
        }

        return $this->mediaUrl(null, $defaults['factory_poster'] ?? '');
    }

    protected function isVideoPath(?string $path): bool
    {
        return $path !== null && preg_match('/\.(mp4|webm)$/i', $path) === 1;
    }

    protected function isImagePath(?string $path): bool
    {
        return $path !== null && preg_match('/\.(jpe?g|png|webp|gif)$/i', $path) === 1;
    }

    protected function uploadedUrl(?string $path, string $defaultRelative): string
    {
        if (! $path) {
            return tenant_static_asset('themes/modern/media/'.$defaultRelative);
        }

        if (PublicUploadedFile::isExternalUrl($path)) {
            return $path;
        }

        return tenant_media_url($path) ?? tenant_static_asset('themes/modern/media/'.$defaultRelative);
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
