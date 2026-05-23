<?php

namespace App\Support;

class MediaUpload
{
    public const URL_HINT = 'Upload a file or paste a direct https:// link.';

    /** @return array<string, string> */
    public static function imageFieldRules(string $field = 'image', int $maxKb = 2048): array
    {
        return [
            $field => 'nullable|image|max:'.$maxKb,
            $field.'_url' => 'nullable|url|max:2048',
        ];
    }

    /** @return array<string, string> */
    public static function imageOrPdfFieldRules(string $field = 'image', int $maxKb = 2048): array
    {
        return [
            $field => 'nullable|file|mimes:jpeg,jpg,png,gif,webp,pdf|max:'.$maxKb,
            $field.'_url' => 'nullable|url|max:2048',
        ];
    }

    /** @return array<string, string> */
    public static function pdfFieldRules(string $field = 'pdf', int $maxKb = 5120): array
    {
        return [
            $field => 'nullable|file|mimes:pdf|max:'.$maxKb,
            $field.'_url' => 'nullable|url|max:2048',
        ];
    }

    public static function hint(int $maxKb = 2048, bool $isPdf = false): string
    {
        if ($isPdf) {
            $mb = rtrim(rtrim(number_format($maxKb / 1024, 1, '.', ''), '0'), '.');

            return 'PDF file or direct link. Max '.$mb.' MB upload.';
        }

        return ImageUpload::hint($maxKb).' '.self::URL_HINT;
    }
}
