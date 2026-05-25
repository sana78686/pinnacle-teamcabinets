<?php

namespace App\Http\Controllers;

use App\Models\ManageDocument;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ManageDocumentApiController extends Controller
{
    protected array $allowedExtensions = ['pdf', 'doc', 'docx', 'zip'];

    public function index(Request $request): JsonResponse
    {
        if (! Schema::hasTable('manage_document')) {
            return response()->json(['data' => []]);
        }

        $query = ManageDocument::query()->orderByDesc('id');

        if ($request->boolean('trashed')) {
            $query->onlyTrashed();
        }

        $rows = $query->get()->map(fn (ManageDocument $row) => $this->serialize($row));

        return response()->json(['data' => $rows]);
    }

    public function show(int $id): JsonResponse
    {
        abort_unless(Schema::hasTable('manage_document'), 503);

        $doc = ManageDocument::query()->findOrFail($id);

        return response()->json(['data' => $this->serialize($doc)]);
    }

    public function store(Request $request): JsonResponse
    {
        abort_unless(Schema::hasTable('manage_document'), 503);

        $validated = $request->validate([
            'user_type' => 'required|string|max:64',
            'status' => 'nullable|in:active,inactive',
            'file' => 'required|file|max:20480',
        ]);

        $file = $request->file('file');
        $this->assertAllowedExtension($file);
        $storedName = $this->storeFile($file);

        $doc = ManageDocument::query()->create([
            'user_type' => $validated['user_type'],
            'document_name' => $storedName,
            'status' => $validated['status'] ?? 'active',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Document saved.',
            'data' => $this->serialize($doc),
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        abort_unless(Schema::hasTable('manage_document'), 503);

        $doc = ManageDocument::query()->findOrFail($id);

        $validated = $request->validate([
            'user_type' => 'sometimes|required|string|max:64',
            'status' => 'nullable|in:active,inactive',
            'file' => 'nullable|file|max:20480',
        ]);

        $data = [];
        if (array_key_exists('user_type', $validated)) {
            $data['user_type'] = $validated['user_type'];
        }
        if (array_key_exists('status', $validated)) {
            $data['status'] = $validated['status'] ?? $doc->status;
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $this->assertAllowedExtension($file);
            $this->deleteStoredFile($doc->document_name);
            $data['document_name'] = $this->storeFile($file);
        }

        if ($data !== []) {
            $doc->update($data);
        }

        return response()->json([
            'success' => true,
            'message' => 'Document updated.',
            'data' => $this->serialize($doc->fresh()),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        abort_unless(Schema::hasTable('manage_document'), 503);

        ManageDocument::query()->findOrFail($id)->delete();

        return response()->json(['success' => true, 'message' => 'Document deleted.']);
    }

    public function restore(int $id): JsonResponse
    {
        abort_unless(Schema::hasTable('manage_document'), 503);

        $doc = ManageDocument::query()->onlyTrashed()->findOrFail($id);
        $doc->restore();

        return response()->json([
            'success' => true,
            'message' => 'Document restored.',
            'data' => $this->serialize($doc),
        ]);
    }

    protected function assertAllowedExtension(\Illuminate\Http\UploadedFile $file): void
    {
        $extension = strtolower((string) $file->getClientOriginalExtension());
        if (! in_array($extension, $this->allowedExtensions, true)) {
            throw ValidationException::withMessages([
                'file' => 'Allowed file types: PDF, DOC, DOCX, ZIP.',
            ]);
        }
    }

    protected function storeFile(\Illuminate\Http\UploadedFile $file): string
    {
        $base = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safe = Str::slug($base, '_') ?: 'document';
        $name = time().'_'.$safe.'.'.$file->getClientOriginalExtension();

        $dir = public_path('assets/admin/manage_document');
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

        $path = public_path('assets/admin/manage_document/'.$fileName);
        if (is_file($path)) {
            @unlink($path);
        }
    }

    protected function serialize(ManageDocument $row): array
    {
        $fileName = (string) $row->document_name;

        return [
            'id' => $row->id,
            'user_type' => $row->user_type,
            'document_name' => $fileName,
            'status' => $row->status ?? 'active',
            'file_url' => tenant_static_asset('assets/admin/manage_document/'.$fileName),
            'is_pdf' => (bool) preg_match('/\.pdf$/i', $fileName),
            'created_at' => $row->created_at?->format('M j, Y') ?? '—',
        ];
    }
}
