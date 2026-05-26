<?php

namespace App\Http\Controllers;

use App\Models\Bulletin;
use App\Support\BulletinAudience;
use App\Support\MediaUpload;
use App\Support\PublicUploadedFile;
use App\Support\TenantListPaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BulletinApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = TenantListPaginator::perPage($request);
        $search = TenantListPaginator::search($request);
        $sort = (string) $request->input('sort', 'newest');
        $audience = (string) $request->input('audience', '');

        if (! array_key_exists($sort, BulletinAudience::adminSortOptions())) {
            $sort = 'newest';
        }

        $query = Bulletin::query();

        if ($request->boolean('trashed')) {
            $query->onlyTrashed();
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('bulletin_title', 'like', '%'.$search.'%')
                    ->orWhere('bulletin_description', 'like', '%'.$search.'%')
                    ->orWhere('target_role', 'like', '%'.$search.'%');
            });
        }

        if ($audience === 'every_one' || $audience === 'specific_user') {
            $query->where('user_option', $audience);
        }

        match ($sort) {
            'oldest' => $query->oldest('id'),
            'title_asc' => $query->orderBy('bulletin_title')->orderByDesc('id'),
            'title_desc' => $query->orderByDesc('bulletin_title')->orderByDesc('id'),
            default => $query->latest('created_at')->latest('id'),
        };

        $paginator = $query->paginate($perPage);

        return response()->json([
            'data' => $paginator->getCollection()->map(fn (Bulletin $row) => $this->serialize($row))->values(),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
            ],
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $bulletin = Bulletin::query()->findOrFail($id);

        return response()->json(['data' => $this->serialize($bulletin)]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate(array_merge([
            'user_option' => 'required|in:every_one,specific_user',
            'target_role' => 'nullable|string|max:100|required_if:user_option,specific_user',
            'bulletin_title' => 'required|string|max:255',
            'bulletin_description' => 'required|string|max:5000',
        ], MediaUpload::imageOrPdfFieldRules('image')));

        $bulletin = new Bulletin;
        if (tenancy()->initialized) {
            $bulletin->tenant_id = tenant()->getTenantKey();
        }
        $bulletin->user_option = $validated['user_option'];
        $bulletin->target_role = $validated['user_option'] === 'specific_user'
            ? BulletinAudience::normalizeTargetRole($validated['target_role'] ?? null)
            : null;
        $bulletin->bulletin_title = $validated['bulletin_title'];
        $bulletin->bulletin_description = $validated['bulletin_description'];
        $bulletin->image = PublicUploadedFile::resolve(
            $request,
            'image',
            null,
            'images'
        );
        $bulletin->save();

        return response()->json([
            'success' => true,
            'message' => 'Bulletin created successfully.',
            'data' => $this->serialize($bulletin),
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $bulletin = Bulletin::query()->findOrFail($id);

        $validated = $request->validate(array_merge([
            'user_option' => 'required|in:every_one,specific_user',
            'target_role' => 'nullable|string|max:100|required_if:user_option,specific_user',
            'bulletin_title' => 'required|string|max:255',
            'bulletin_description' => 'required|string|max:5000',
        ], MediaUpload::imageOrPdfFieldRules('image')));

        $bulletin->user_option = $validated['user_option'];
        $bulletin->target_role = $validated['user_option'] === 'specific_user'
            ? BulletinAudience::normalizeTargetRole($validated['target_role'] ?? null)
            : null;
        $bulletin->bulletin_title = $validated['bulletin_title'];
        $bulletin->bulletin_description = $validated['bulletin_description'];
        $bulletin->image = PublicUploadedFile::resolve(
            $request,
            'image',
            $bulletin->image,
            'images'
        );
        $bulletin->save();

        return response()->json([
            'success' => true,
            'message' => 'Bulletin updated successfully.',
            'data' => $this->serialize($bulletin->fresh()),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        Bulletin::query()->findOrFail($id)->delete();

        return response()->json(['success' => true, 'message' => 'Bulletin deleted.']);
    }

    public function restore(int $id): JsonResponse
    {
        $bulletin = Bulletin::query()->onlyTrashed()->findOrFail($id);
        $bulletin->restore();

        return response()->json([
            'success' => true,
            'message' => 'Bulletin restored.',
            'data' => $this->serialize($bulletin->fresh()),
        ]);
    }

    /** @return array<string, mixed> */
    protected function serialize(Bulletin $bulletin): array
    {
        $url = $bulletin->attachmentUrl();

        return [
            'id' => $bulletin->id,
            'bulletin_title' => $bulletin->bulletin_title,
            'bulletin_description' => $bulletin->bulletin_description,
            'description_short' => Str::limit((string) $bulletin->bulletin_description, 90),
            'user_option' => $bulletin->user_option,
            'user_option_label' => BulletinAudience::userOptionLabel($bulletin->user_option),
            'user_option_badge' => $bulletin->user_option === 'every_one' ? 'bg-primary' : 'bg-secondary',
            'target_role' => $bulletin->target_role,
            'target_role_label' => $bulletin->user_option === 'specific_user'
                ? BulletinAudience::targetRoleLabel($bulletin->target_role)
                : '—',
            'attachment_url' => $url,
            'is_image_attachment' => $bulletin->isImageAttachment(),
            'attachment_ext' => strtoupper($bulletin->attachmentExtension()),
            'image' => $bulletin->image,
            'image_url' => $url,
            'image_link' => $url,
            'posted_at' => $bulletin->created_at?->format('m/d/Y') ?? '—',
            'created_at' => $bulletin->created_at?->format('m/d/Y') ?? '—',
        ];
    }
}
