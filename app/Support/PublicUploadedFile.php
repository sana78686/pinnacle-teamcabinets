<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PublicUploadedFile
{
    public static function isExternalUrl(?string $path): bool
    {
        if ($path === null || $path === '') {
            return false;
        }

        return str_starts_with($path, 'http://') || str_starts_with($path, 'https://');
    }

    /** Delete a file stored under public/ or on a Laravel disk (skips external URLs). */
    public static function delete(?string $relativePath, ?string $disk = null): void
    {
        if (! $relativePath || self::isExternalUrl($relativePath)) {
            return;
        }

        if ($disk) {
            if (Storage::disk($disk)->exists($relativePath)) {
                Storage::disk($disk)->delete($relativePath);
            }

            return;
        }

        $path = public_path(ltrim($relativePath, '/'));
        if (is_file($path)) {
            @unlink($path);
        }
    }

    /**
     * Apply remove flag, file upload, external URL, or keep current path.
     *
     * @return string|null Updated path or external URL (null when removed)
     */
    public static function resolve(
        Request $request,
        string $field,
        ?string $currentPath,
        ?string $uploadDir = null,
        ?string $disk = null,
        ?string $urlField = null
    ): ?string {
        return self::resolveMedia($request, $field, $currentPath, $uploadDir, $disk, $urlField);
    }

    /**
     * @return string|null Updated path or external URL (null when removed)
     */
    public static function resolveMedia(
        Request $request,
        string $field,
        ?string $currentPath,
        ?string $uploadDir = null,
        ?string $disk = null,
        ?string $urlField = null
    ): ?string {
        $urlField = $urlField ?? $field.'_url';
        $url = trim((string) $request->input($urlField, ''));

        if ($request->boolean('remove_'.$field)) {
            self::delete($currentPath, $disk);

            return null;
        }

        if ($request->hasFile($field)) {
            self::delete($currentPath, $disk);

            return self::storeUpload($request->file($field), $uploadDir, $disk);
        }

        if ($url !== '') {
            if ($currentPath && ! self::isExternalUrl($currentPath)) {
                self::delete($currentPath, $disk);
            }

            return $url;
        }

        return $currentPath;
    }

    protected static function storeUpload(?UploadedFile $file, ?string $uploadDir, ?string $disk): ?string
    {
        if (! $file instanceof UploadedFile || ! $uploadDir) {
            return null;
        }

        $filename = time().'_'.preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());

        if ($disk) {
            return $file->storeAs(trim($uploadDir, '/'), $filename, $disk);
        }

        $dir = public_path(trim($uploadDir, '/'));
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $file->move($dir, $filename);

        return trim($uploadDir, '/').'/'.$filename;
    }
}
