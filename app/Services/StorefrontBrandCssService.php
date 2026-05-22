<?php

namespace App\Services;

class StorefrontBrandCssService
{
    public const DEFAULT_PRIMARY = '#1a4a7a';

    /** Relative path under public/ for this tenant's generated brand overrides. */
    public function cssRelativePath(): string
    {
        $id = (string) (tenant('id') ?? 'default');

        return 'css/themes/brands/'.$id.'.css';
    }

    public function cssAbsolutePath(): string
    {
        return public_path($this->cssRelativePath());
    }

    /** Primary brand color from generated CSS, or Hazel default. */
    public function currentColor(): string
    {
        $path = $this->cssAbsolutePath();
        if (! is_file($path)) {
            return self::DEFAULT_PRIMARY;
        }

        $css = (string) file_get_contents($path);
        if (preg_match('/--hz-blue:\s*(#[0-9a-fA-F]{6})/', $css, $m)) {
            return strtolower($m[1]);
        }

        return self::DEFAULT_PRIMARY;
    }

    /** URL for storefront layout, or null when no custom brand file exists. */
    public function stylesheetUrl(): ?string
    {
        $path = $this->cssAbsolutePath();
        if (! is_file($path)) {
            return null;
        }

        return tenant_static_asset($this->cssRelativePath()).'?v='.filemtime($path);
    }

    /**
     * Write :root overrides for header, footer, and primary buttons (Hazel CSS vars).
     */
    public function write(string $hex): void
    {
        $primary = $this->normalizeHex($hex);
        $navy = $this->darken($primary, 0.42);
        $gold = $this->accent($primary);

        $dir = dirname($this->cssAbsolutePath());
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $css = <<<CSS
/* Tenant storefront brand — generated from Site Settings. Do not edit manually. */
:root {
    --hz-navy: {$navy};
    --hz-blue: {$primary};
    --hz-gold: {$gold};
}

CSS;

        file_put_contents($this->cssAbsolutePath(), $css);
    }

    public function remove(): void
    {
        $path = $this->cssAbsolutePath();
        if (is_file($path)) {
            @unlink($path);
        }
    }

    private function normalizeHex(string $hex): string
    {
        $hex = ltrim(trim($hex), '#');
        if (! preg_match('/^[0-9a-fA-F]{6}$/', $hex)) {
            throw new \InvalidArgumentException('Invalid brand color hex.');
        }

        return '#'.strtolower($hex);
    }

    /** @return array{0: int, 1: int, 2: int} */
    private function hexToRgb(string $hex): array
    {
        $hex = ltrim($hex, '#');

        return [
            hexdec(substr($hex, 0, 2)),
            hexdec(substr($hex, 2, 2)),
            hexdec(substr($hex, 4, 2)),
        ];
    }

    private function rgbToHex(int $r, int $g, int $b): string
    {
        return sprintf('#%02x%02x%02x', max(0, min(255, $r)), max(0, min(255, $g)), max(0, min(255, $b)));
    }

    private function darken(string $hex, float $amount): string
    {
        [$r, $g, $b] = $this->hexToRgb($hex);
        $factor = 1 - max(0, min(1, $amount));

        return $this->rgbToHex(
            (int) round($r * $factor),
            (int) round($g * $factor),
            (int) round($b * $factor),
        );
    }

    private function lighten(string $hex, float $amount): string
    {
        [$r, $g, $b] = $this->hexToRgb($hex);
        $amount = max(0, min(1, $amount));

        return $this->rgbToHex(
            (int) round($r + (255 - $r) * $amount),
            (int) round($g + (255 - $g) * $amount),
            (int) round($b + (255 - $b) * $amount),
        );
    }

    /** Lighter accent for hovers on dark header/footer. */
    private function accent(string $hex): string
    {
        $light = $this->lighten($hex, 0.45);
        [$lr, $lg, $lb] = $this->hexToRgb($light);
        [$gr, $gg, $gb] = $this->hexToRgb('#c9a227');
        $mix = 0.35;

        return $this->rgbToHex(
            (int) round($lr * (1 - $mix) + $gr * $mix),
            (int) round($lg * (1 - $mix) + $gg * $mix),
            (int) round($lb * (1 - $mix) + $gb * $mix),
        );
    }
}
