<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TenantPublicFileController extends Controller
{
    /**
     * Stream a file from storage/app/public or public/ (tenant hosts block direct /public/storage/ access).
     */
    public function storage(Request $request, string $path): BinaryFileResponse|StreamedResponse
    {
        $path = $this->sanitizePath($path);

        if ($path === '') {
            abort(404);
        }

        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->response($path, null, [
                'Content-Disposition' => 'inline',
            ]);
        }

        $publicFile = public_path($path);
        if (is_file($publicFile)) {
            return response()->file($publicFile, [
                'Content-Disposition' => 'inline',
            ]);
        }

        abort(404);
    }

    protected function sanitizePath(string $path): string
    {
        $path = str_replace('\\', '/', $path);
        $path = ltrim($path, '/');

        if (str_contains($path, '..')) {
            return '';
        }

        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, strlen('storage/'));
        }

        return $path;
    }
}
