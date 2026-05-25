<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;

class StorefrontMediaOptimizer
{
    public const IMAGE_MAX_WIDTH = 1600;

    public const JPEG_QUALITY = 82;

    /** @return array{ok: bool, message: string, before?: int, after?: int} */
    public function optimizeImage(string $absolutePath): array
    {
        if (! is_file($absolutePath)) {
            return ['ok' => false, 'message' => 'File not found.'];
        }

        $before = (int) filesize($absolutePath);
        $ext = strtolower(pathinfo($absolutePath, PATHINFO_EXTENSION));

        if (! in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
            return ['ok' => false, 'message' => 'Unsupported image type.'];
        }

        if (! extension_loaded('gd')) {
            return ['ok' => false, 'message' => 'GD extension unavailable.'];
        }

        try {
            $source = match ($ext) {
                'jpg', 'jpeg' => @imagecreatefromjpeg($absolutePath),
                'png' => @imagecreatefrompng($absolutePath),
                'webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($absolutePath) : false,
                default => false,
            };

            if (! $source) {
                return ['ok' => false, 'message' => 'Could not read image.'];
            }

            $width = imagesx($source);
            $height = imagesy($source);
            $targetWidth = min($width, self::IMAGE_MAX_WIDTH);

            if ($targetWidth < $width) {
                $targetHeight = (int) round($height * ($targetWidth / $width));
                $resized = imagecreatetruecolor($targetWidth, $targetHeight);
                if ($ext === 'png' || $ext === 'webp') {
                    imagealphablending($resized, false);
                    imagesavealpha($resized, true);
                }
                imagecopyresampled($resized, $source, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);
                imagedestroy($source);
                $source = $resized;
            }

            $saved = match ($ext) {
                'jpg', 'jpeg' => imagejpeg($source, $absolutePath, self::JPEG_QUALITY),
                'png' => imagepng($source, $absolutePath, 6),
                'webp' => function_exists('imagewebp') ? imagewebp($source, $absolutePath, self::JPEG_QUALITY) : false,
                default => false,
            };
            imagedestroy($source);

            if (! $saved) {
                return ['ok' => false, 'message' => 'Could not save optimized image.'];
            }

            clearstatcache(true, $absolutePath);
            $after = (int) filesize($absolutePath);

            return [
                'ok' => true,
                'message' => 'Image optimized.',
                'before' => $before,
                'after' => $after,
            ];
        } catch (\Throwable $e) {
            Log::warning('StorefrontMediaOptimizer image failed', ['path' => $absolutePath, 'error' => $e->getMessage()]);

            return ['ok' => false, 'message' => $e->getMessage()];
        }
    }

    /** @return array{ok: bool, message: string, before?: int, after?: int} */
    public function optimizeVideo(string $absolutePath): array
    {
        if (! is_file($absolutePath)) {
            return ['ok' => false, 'message' => 'File not found.'];
        }

        if (! $this->ffmpegAvailable()) {
            return ['ok' => false, 'message' => 'ffmpeg not installed — upload a smaller MP4 or install ffmpeg.'];
        }

        $before = (int) filesize($absolutePath);
        $temp = $absolutePath.'.opt.mp4';

        $result = Process::timeout(600)->run([
            'ffmpeg', '-y', '-i', $absolutePath,
            '-vcodec', 'libx264', '-crf', '28', '-preset', 'fast',
            '-vf', 'scale=1280:-2', '-movflags', '+faststart',
            '-an', $temp,
        ]);

        if (! $result->successful() || ! is_file($temp)) {
            @unlink($temp);

            return ['ok' => false, 'message' => 'Video compression failed.'];
        }

        if (! @rename($temp, $absolutePath)) {
            @unlink($temp);

            return ['ok' => false, 'message' => 'Could not replace video file.'];
        }

        clearstatcache(true, $absolutePath);
        $after = (int) filesize($absolutePath);

        return [
            'ok' => true,
            'message' => 'Video compressed.',
            'before' => $before,
            'after' => $after,
        ];
    }

    public function ffmpegAvailable(): bool
    {
        $probe = Process::run(['ffmpeg', '-version']);

        return $probe->successful();
    }

    /** @return list<string> */
    public function optimizeDirectory(string $absoluteDir, bool $videos = true): array
    {
        $logs = [];
        if (! is_dir($absoluteDir)) {
            return ['Directory not found: '.$absoluteDir];
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($absoluteDir, \FilesystemIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if (! $file->isFile()) {
                continue;
            }
            $path = $file->getPathname();
            $ext = strtolower($file->getExtension());

            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                $result = $this->optimizeImage($path);
                if ($result['ok'] && isset($result['before'], $result['after'])) {
                    $logs[] = basename($path).': '.$this->formatBytes($result['before']).' → '.$this->formatBytes($result['after']);
                }
            } elseif ($videos && $ext === 'mp4') {
                $result = $this->optimizeVideo($path);
                if ($result['ok'] && isset($result['before'], $result['after'])) {
                    $logs[] = basename($path).': '.$this->formatBytes($result['before']).' → '.$this->formatBytes($result['after']);
                } elseif (! $result['ok']) {
                    $logs[] = basename($path).': '.$result['message'];
                }
            }
        }

        return $logs;
    }

    protected function formatBytes(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 1).' MB';
        }

        return round($bytes / 1024).' KB';
    }
}
