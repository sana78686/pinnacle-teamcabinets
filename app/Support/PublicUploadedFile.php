<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PublicUploadedFile
{
    /** Delete a file stored under public/ or on a Laravel disk. */
    public static function delete(?string $relativePath, ?string $disk = null): void
    {
        if (! $relativePath) {
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
     * Apply remove flag, new upload, or keep the current path.
     *
     * @return string|null Updated relative path (null when removed)
     */
    public static function resolve(
        Request $request,
        string $field,
        ?string $currentPath,
        ?string $uploadDir = null,
        ?string $disk = null
    ): ?string {
        if ($request->boolean('remove_'.$field)) {
            self::delete($currentPath, $disk);

            return null;
        }

        if (! $request->hasFile($field)) {
            return $currentPath;
        }

        self::delete($currentPath, $disk);

        $file = $request->file($field);
        if (! $file instanceof UploadedFile || ! $uploadDir) {
            return $currentPath;
        }

        if ($disk) {
            $filename = time().'_'.preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());

            return $file->storeAs(trim($uploadDir, '/'), $filename, $disk);
        }

        $dir = public_path(trim($uploadDir, '/'));
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $filename = time().'_'.preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
        $file->move($dir, $filename);

        return trim($uploadDir, '/').'/'.$filename;
    }
}
