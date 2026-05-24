<?php

namespace App\Http\Controllers;

use App\Models\UserUpload;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UserUploadApiController extends Controller
{
    protected array $allowedExtensions = ['jpg', 'jpeg', 'png', 'doc', 'docx', 'pdf'];

    public function index(Request $request): JsonResponse
    {
        if (! Schema::hasTable('user_uploads')) {
            return response()->json([
                'data' => [],
                'meta' => [
                    'current_page' => 1,
                    'last_page' => 1,
                    'per_page' => tenant_list_per_page(),
                    'total' => 0,
                ],
            ]);
        }

        $paginator = UserUpload::query()
            ->where('user_id', Auth::id())
            ->latest('id')
            ->paginate(tenant_list_per_page())
            ->withQueryString();

        return response()->json([
            'data' => collect($paginator->items())->map(fn (UserUpload $row) => $this->serialize($row)),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
            ],
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $record = $this->findOwned($id);

        return response()->json(['data' => $this->serialize($record, true)]);
    }

    public function store(Request $request): JsonResponse
    {
        if (! Schema::hasTable('user_uploads')) {
            return response()->json([
                'message' => 'Uploads are not available yet. Please contact support.',
            ], 503);
        }

        $validated = $request->validate([
            'description' => 'required|string|max:251',
            'file' => 'required|file|max:20480',
        ]);

        $file = $request->file('file');
        $extension = strtolower((string) $file->getClientOriginalExtension());
        if (! in_array($extension, $this->allowedExtensions, true)) {
            throw ValidationException::withMessages([
                'file' => 'Only JPG, JPEG, PNG, DOC, DOCX, and PDF files are allowed.',
            ]);
        }

        $storedName = $this->storeFile($file);

        $record = UserUpload::query()->create([
            'user_id' => Auth::id(),
            'file_name' => $storedName,
            'description' => $validated['description'],
        ]);

        return response()->json([
            'message' => 'File uploaded successfully.',
            'data' => $this->serialize($record, true),
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $record = $this->findOwned($id);

        $validated = $request->validate([
            'description' => 'required|string|max:251',
            'file' => 'nullable|file|max:20480',
        ]);

        $data = ['description' => $validated['description']];

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = strtolower((string) $file->getClientOriginalExtension());
            if (! in_array($extension, $this->allowedExtensions, true)) {
                throw ValidationException::withMessages([
                    'file' => 'Only JPG, JPEG, PNG, DOC, DOCX, and PDF files are allowed.',
                ]);
            }

            $this->deleteStoredFile($record->file_name);
            $data['file_name'] = $this->storeFile($file);
        }

        $record->update($data);

        return response()->json([
            'message' => 'Upload updated successfully.',
            'data' => $this->serialize($record->fresh(), true),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $record = $this->findOwned($id);
        $this->deleteStoredFile($record->file_name);
        $record->delete();

        return response()->json(['message' => 'Upload deleted successfully.']);
    }

    protected function findOwned(int $id): UserUpload
    {
        abort_unless(Schema::hasTable('user_uploads'), 503, 'Uploads are not available yet.');

        return UserUpload::query()
            ->where('user_id', Auth::id())
            ->findOrFail($id);
    }

    protected function storeFile(\Illuminate\Http\UploadedFile $file): string
    {
        $base = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safe = Str::slug($base, '_') ?: 'upload';
        $name = $safe.'_'.time().'.'.$file->getClientOriginalExtension();

        $file->move(public_path('assets/user_uploads'), $name);

        return $name;
    }

    protected function deleteStoredFile(?string $fileName): void
    {
        if (! $fileName) {
            return;
        }

        $path = public_path('assets/user_uploads/'.$fileName);
        if (is_file($path)) {
            @unlink($path);
        }
    }

    protected function serialize(UserUpload $row, bool $detail = false): array
    {
        $fileUrl = tenant_static_asset('assets/user_uploads/'.$row->file_name);

        $data = [
            'id' => $row->id,
            'file_name' => $row->file_name,
            'description' => $row->description,
            'created_at' => $row->created_at?->format('M j, Y') ?? '—',
            'file_url' => $fileUrl,
        ];

        if ($detail) {
            $data['file_url'] = $fileUrl;
        }

        return $data;
    }
}
