<?php

namespace App\Http\Controllers;

use App\Models\SupportMessage;
use App\Models\SupportThread;
use App\Models\User;
use App\Services\SupportChatService;
use App\Support\PublicUploadedFile;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SupportChatApiController extends Controller
{
    public function __construct(
        protected SupportChatService $chat,
    ) {}

    public function threads(Request $request): JsonResponse
    {
        $user = $request->user();
        $isAdmin = tenant_user_has_admin_role($user);

        $query = SupportThread::query()
            ->with(['user:id,name,email,logo,username'])
            ->withCount([
                'messages as unread_count' => function ($q) use ($user) {
                    $q->where('user_id', '!=', $user->id)->where('is_read', false);
                },
            ])
            ->latest('id');

        if (! $isAdmin) {
            $query->where('user_id', $user->id);
        }

        if ($search = trim((string) $request->query('search', ''))) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%'.$search.'%')
                    ->orWhereHas('user', fn ($uq) => $uq->where('name', 'like', '%'.$search.'%')
                        ->orWhere('email', 'like', '%'.$search.'%')
                        ->orWhere('username', 'like', '%'.$search.'%'));
            });
        }

        $paginator = $query->paginate(tenant_list_per_page())->withQueryString();

        return response()->json([
            'data' => collect($paginator->items())->map(fn (SupportThread $thread) => $this->serializeThread($thread, $user)),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
            ],
        ]);
    }

    public function currentThread(Request $request): JsonResponse
    {
        if (tenant_user_has_admin_role($request->user())) {
            abort(403);
        }

        $thread = $this->chat->findUserThread($request->user());

        if (! $thread) {
            return response()->json(['data' => null]);
        }

        $thread->load(['user:id,name,email,logo,username']);
        $thread->loadCount([
            'messages as unread_count' => function ($q) use ($request) {
                $q->where('user_id', '!=', $request->user()->id)->where('is_read', false);
            },
        ]);

        return response()->json([
            'data' => $this->serializeThread($thread, $request->user()),
        ]);
    }

    public function chatUsers(Request $request): JsonResponse
    {
        abort_unless(tenant_user_has_admin_role($request->user()), 403);

        $search = trim((string) $request->query('search', ''));
        $existingThreadUserIds = SupportThread::query()->pluck('user_id')->all();

        $query = User::query()
            ->select(['id', 'name', 'username', 'email', 'logo'])
            ->where('id', '!=', $request->user()->id)
            ->orderBy('name');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('username', 'like', '%'.$search.'%');
            });
        }

        $users = $query->limit(25)->get()->filter(function (User $user) {
            return ! tenant_user_has_admin_role($user);
        })->values();

        return response()->json([
            'data' => $users->map(function (User $user) use ($existingThreadUserIds) {
                $avatar = tenant_user_chat_avatar($user);
                $hasThread = in_array($user->id, $existingThreadUserIds, true);

                return [
                    'id' => $user->id,
                    'name' => $avatar['name'],
                    'email' => $user->email,
                    'avatar' => $avatar,
                    'has_thread' => $hasThread,
                ];
            }),
        ]);
    }

    public function storeThread(Request $request): JsonResponse
    {
        $viewer = $request->user();

        if (tenant_user_has_admin_role($viewer)) {
            $validated = $request->validate([
                'user_id' => 'required|integer|exists:users,id',
            ]);

            $target = User::query()->findOrFail((int) $validated['user_id']);

            if (tenant_user_has_admin_role($target)) {
                throw ValidationException::withMessages([
                    'user_id' => 'You cannot start a chat with an admin account.',
                ]);
            }

            $existing = $this->chat->findUserThread($target);
            $thread = $existing ?? $this->chat->createThread($target, 'Support Chat', null);
            $created = ! $existing;

            $thread->load(['user:id,name,email,logo,username']);
            $thread->loadCount([
                'messages as unread_count' => function ($q) use ($viewer) {
                    $q->where('user_id', '!=', $viewer->id)->where('is_read', false);
                },
            ]);

            return response()->json([
                'message' => $created ? 'Chat room created.' : 'Opened existing chat room.',
                'data' => $this->serializeThread($thread, $viewer),
                'existing' => ! $created,
            ], $created ? 201 : 200);
        }

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:5000',
            'message' => 'nullable|string|max:5000',
        ]);

        $thread = $this->chat->getOrCreateUserThread($viewer);

        if (! empty($validated['message'])) {
            $this->chat->sendMessage($thread, $viewer, $validated['message']);
        }

        $thread->load(['user:id,name,email,logo,username']);
        $thread->loadCount([
            'messages as unread_count' => function ($q) use ($viewer) {
                $q->where('user_id', '!=', $viewer->id)->where('is_read', false);
            },
        ]);

        return response()->json([
            'message' => 'Support thread ready.',
            'data' => $this->serializeThread($thread, $viewer),
        ], 201);
    }

    public function messages(Request $request, int $id): JsonResponse
    {
        $thread = $this->findAccessibleThread($request, $id);
        $sinceRaw = $request->query('since');

        $query = SupportMessage::query()
            ->with(['user:id,name,logo,username'])
            ->where('support_thread_id', $thread->id)
            ->orderBy('id');

        if ($sinceRaw) {
            try {
                $since = Carbon::parse($sinceRaw);
                $query->where('created_at', '>', $since);
            } catch (\Throwable) {
                // ignore invalid since
            }
        }

        $messages = $query->get();

        if ($request->boolean('mark_read', true)) {
            $this->chat->markThreadRead($thread, $request->user());
        }

        return response()->json([
            'data' => $messages->map(fn (SupportMessage $msg) => $this->serializeMessage($msg, $request->user())),
            'thread' => $this->serializeThread($thread->load(['user:id,name,email,logo,username']), $request->user()),
            'server_time' => now()->toIso8601String(),
        ]);
    }

    public function storeMessage(Request $request, int $id): JsonResponse
    {
        $thread = $this->findAccessibleThread($request, $id);

        $validated = $request->validate([
            'message' => 'nullable|string|max:5000',
            'attachment' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,xls,xlsx,zip,txt,csv',
        ]);

        $message = trim((string) ($validated['message'] ?? ''));
        $attachmentPath = null;
        $attachmentName = null;

        if ($request->hasFile('attachment')) {
            $stored = $this->chat->storeAttachment($request->file('attachment'));
            $attachmentPath = $stored['path'];
            $attachmentName = $stored['name'];
        }

        if ($message === '' && ! $attachmentPath) {
            throw ValidationException::withMessages([
                'message' => 'Enter a message or attach a file.',
            ]);
        }

        $record = $this->chat->sendMessage($thread, $request->user(), $message, $attachmentPath, $attachmentName);

        return response()->json([
            'message' => 'Message sent.',
            'data' => $this->serializeMessage($record->load(['user:id,name,logo,username']), $request->user()),
        ], 201);
    }

    public function markRead(Request $request, int $id): JsonResponse
    {
        $thread = $this->findAccessibleThread($request, $id);
        $this->chat->markThreadRead($thread, $request->user());

        return response()->json([
            'ok' => true,
            'unread_count' => $this->chat->unreadCountForUser($request->user()),
        ]);
    }

    public function destroyMessage(Request $request, int $id): JsonResponse
    {
        $message = SupportMessage::query()->with('thread')->findOrFail($id);
        $thread = $message->thread;

        if (! $thread) {
            throw ValidationException::withMessages(['message' => 'Thread not found.']);
        }

        $this->authorizeThreadAccess($request, $thread);

        if ($message->attachment_path) {
            PublicUploadedFile::delete($message->attachment_path);
        }

        $threadId = $thread->id;
        $remaining = SupportMessage::query()->where('support_thread_id', $threadId)->count();

        if ($remaining <= 1) {
            $thread->delete();

            return response()->json([
                'message' => 'Thread deleted.',
                'thread_deleted' => true,
                'thread_id' => $threadId,
            ]);
        }

        $message->delete();

        return response()->json([
            'message' => 'Message deleted.',
            'thread_deleted' => false,
            'thread_id' => $threadId,
        ]);
    }

    public function destroyThread(Request $request, int $id): JsonResponse
    {
        $thread = $this->findAccessibleThread($request, $id);

        SupportMessage::query()
            ->where('support_thread_id', $thread->id)
            ->whereNotNull('attachment_path')
            ->pluck('attachment_path')
            ->each(fn (?string $path) => PublicUploadedFile::delete($path));

        $thread->delete();

        return response()->json([
            'message' => 'Support thread deleted.',
            'thread_id' => $id,
        ]);
    }

    public function unreadCount(Request $request): JsonResponse
    {
        return response()->json([
            'unread_count' => $this->chat->unreadCountForUser($request->user()),
        ]);
    }

    protected function findAccessibleThread(Request $request, int $id): SupportThread
    {
        $thread = SupportThread::query()->findOrFail($id);
        $this->authorizeThreadAccess($request, $thread);

        return $thread;
    }

    protected function authorizeThreadAccess(Request $request, SupportThread $thread): void
    {
        $user = $request->user();

        if (tenant_user_has_admin_role($user)) {
            return;
        }

        if ((int) $thread->user_id !== (int) $user->id) {
            abort(403, 'You do not have access to this support thread.');
        }
    }

    protected function serializeThread(SupportThread $thread, User $viewer): array
    {
        $avatar = tenant_user_chat_avatar($thread->user);

        return [
            'id' => $thread->id,
            'title' => $thread->title,
            'description' => $thread->description,
            'status' => $thread->status,
            'user_id' => $thread->user_id,
            'user_name' => $avatar['name'],
            'user_email' => $thread->user?->email,
            'user_avatar' => $avatar,
            'unread_count' => (int) ($thread->unread_count ?? $this->chat->unreadCountForThread($thread, $viewer)),
            'created_at' => $thread->created_at?->format('M j, Y g:i A'),
            'created_at_iso' => $thread->created_at?->toIso8601String(),
        ];
    }

    protected function serializeMessage(SupportMessage $message, User $viewer): array
    {
        $isMine = (int) $message->user_id === (int) $viewer->id;
        $avatar = tenant_user_chat_avatar($message->user);
        $attachmentUrl = $message->attachment_path ? tenant_media_url($message->attachment_path) : null;

        return [
            'id' => $message->id,
            'support_thread_id' => $message->support_thread_id,
            'user_id' => $message->user_id,
            'user_name' => $avatar['name'],
            'user_avatar' => $avatar,
            'message' => $message->message,
            'attachment_url' => $attachmentUrl,
            'attachment_name' => $message->attachment_name,
            'has_attachment' => (bool) $attachmentUrl,
            'is_read' => (bool) $message->is_read,
            'is_mine' => $isMine,
            'is_admin' => tenant_user_has_admin_role($message->user),
            'created_at' => $message->created_at?->format('M j, Y g:i A'),
            'created_at_iso' => $message->created_at?->toIso8601String(),
        ];
    }
}
