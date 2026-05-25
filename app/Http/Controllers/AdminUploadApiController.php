<?php

namespace App\Http\Controllers;

use App\Models\AdminUpload;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AdminUploadApiController extends Controller
{
    public function index(): JsonResponse
    {
        if (! Schema::hasTable('admin_uploads')) {
            return response()->json(['data' => []]);
        }

        $rows = AdminUpload::query()
            ->with('uploader:id,name')
            ->orderByDesc('id')
            ->get()
            ->map(fn (AdminUpload $row) => $this->serialize($row));

        return response()->json(['data' => $rows]);
    }

    public function store(Request $request): JsonResponse
    {
        abort_unless(Schema::hasTable('admin_uploads'), 503, 'Admin uploads are not available yet.');

        $validated = $request->validate([
            'file' => 'required|file|max:20480',
            'description' => 'nullable|string|max:500',
            'user_type' => 'nullable|string|max:64',
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $storedName = $this->storeFile($file);

        $upload = AdminUpload::query()->create([
            'file_name' => $storedName,
            'original_name' => $originalName,
            'description' => $validated['description'] ?? null,
            'user_type' => $validated['user_type'] ?? '',
            'uploaded_by' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'File uploaded successfully.',
            'data' => $this->serialize($upload->fresh('uploader')),
        ], 201);
    }

    public function destroy(int $id): JsonResponse
    {
        abort_unless(Schema::hasTable('admin_uploads'), 503);

        $upload = AdminUpload::query()->findOrFail($id);
        $this->deleteStoredFile($upload->file_name);
        $upload->delete();

        return response()->json(['success' => true, 'message' => 'Upload deleted.']);
    }

    protected function storeFile(\Illuminate\Http\UploadedFile $file): string
    {
        $base = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safe = Str::slug($base, '_') ?: 'upload';
        $name = time().'_'.$safe.'.'.$file->getClientOriginalExtension();

        $dir = public_path('assets/admin_uploads');
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $file->move($dir, $name);

        return $name;
    }

    protected function deleteStoredFile(?string $fileName): void
    {
        if (! $fileName) {
            return;
        }

        $path = public_path('assets/admin_uploads/'.$fileName);
        if (is_file($path)) {
            @unlink($path);
        }
    }

    protected function serialize(AdminUpload $row): array
    {
        $visibility = $row->user_type === '' ? 'All users' : $row->user_type;

        return [
            'id' => $row->id,
            'file_name' => $row->original_name ?: $row->file_name,
            'stored_name' => $row->file_name,
            'description' => $row->description ?? '—',
            'user_type' => $row->user_type,
            'user_type_label' => $visibility,
            'uploaded_by' => $row->uploader?->name ?? '—',
            'created_at' => $row->created_at?->format('M j, Y') ?? '—',
            'file_url' => tenant_static_asset('assets/admin_uploads/'.$row->file_name),
        ];
    }
}
