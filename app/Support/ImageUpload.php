<?php

namespace App\Support;

/**
 * Standard image-only uploads (Laravel "image" rule: jpg, jpeg, png, bmp, gif, svg, webp).
 */
class ImageUpload
{
    public const ACCEPT = 'image/*';

    public const HINT = 'Any image format (JPG, PNG, WebP, GIF, SVG, BMP, etc.).';

    public static function rule(int $maxKb = 2048, bool $required = false): string
    {
        $prefix = $required ? 'required' : 'nullable';

        return "{$prefix}|image|max:{$maxKb}";
    }

    public static function hint(int $maxKb = 2048): string
    {
        $mb = rtrim(rtrim(number_format($maxKb / 1024, 1, '.', ''), '0'), '.');

        return self::HINT.' Max '.$mb.' MB.';
    }
}
