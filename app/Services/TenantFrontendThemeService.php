<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;
use InvalidArgumentException;

class TenantFrontendThemeService
{
    /** @return array<string, array<string, mixed>> */
    public function all(): array
    {
        return config('tenant_frontend_themes.themes', []);
    }

    public function defaultSlug(): string
    {
        return config('tenant_frontend_themes.default', 'hazel');
    }

    public function isValid(string $slug): bool
    {
        return array_key_exists($slug, $this->all());
    }

    public function activeSlug(): string
    {
        if (! Schema::hasColumn('site_settings', 'frontend_theme')) {
            return $this->defaultSlug();
        }

        $slug = SiteSetting::query()->value('frontend_theme');

        if (is_string($slug) && $this->isValid($slug)) {
            return $slug;
        }

        return $this->defaultSlug();
    }

    /** @return array<string, mixed> */
    public function active(): array
    {
        $slug = $this->activeSlug();

        return array_merge(
            ['slug' => $slug],
            $this->all()[$slug] ?? []
        );
    }

    public function setActive(string $slug): void
    {
        if (! $this->isValid($slug)) {
            throw new InvalidArgumentException("Unknown frontend theme: {$slug}");
        }

        $settings = SiteSetting::forCurrentTenant();

        if (Schema::hasColumn('site_settings', 'frontend_theme')) {
            $settings->frontend_theme = $slug;
        }

        $settings->save();
    }

    /**
     * Resolve a themed view name for the public storefront.
     */
    public function view(string $name): string
    {
        $slug = $this->activeSlug();

        if ($slug === 'classic') {
            $legacy = "frontend.superusers.{$name}";
            if (view()->exists($legacy)) {
                return $legacy;
            }
        }

        $themed = "themes.{$slug}.{$name}";
        if (view()->exists($themed)) {
            return $themed;
        }

        $fallback = "themes.{$this->defaultSlug()}.{$name}";
        if (view()->exists($fallback)) {
            return $fallback;
        }

        return $themed;
    }

    public function asset(string $path): string
    {
        return asset('css/themes/'.$this->activeSlug().'/'.$path);
    }
}
