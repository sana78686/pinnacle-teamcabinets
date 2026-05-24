<?php

namespace App\Http\Controllers;

use App\Models\SupportMessage;
use App\Models\SupportThread;
use App\Services\SupportChatService;
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
            ->with(['user:id,name,email'])
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
                    ->orWhereHas('user', fn ($uq) => $uq->where('name', 'like', '%'.$search.'%'));
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

    public function storeThread(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'message' => 'nullable|string|max:5000',
        ]);

        $thread = $this->chat->createThread(
            $request->user(),
            $validated['title'],
            $validated['description'] ?? null,
        );

        if (! empty($validated['message'])) {
            $this->chat->sendMessage($thread, $request->user(), $validated['message']);
        }

        $thread->load(['user:id,name,email']);
        $thread->loadCount([
            'messages as unread_count' => function ($q) use ($request) {
                $q->where('user_id', '!=', $request->user()->id)->where('is_read', false);
            },
        ]);

        return response()->json([
            'message' => 'Support thread created.',
            'data' => $this->serializeThread($thread, $request->user()),
        ], 201);
    }

    public function messages(Request $request, int $id): JsonResponse
    {
        $thread = $this->findAccessibleThread($request, $id);
        $sinceRaw = $request->query('since');

        $query = SupportMessage::query()
            ->with(['user:id,name'])
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
            'thread' => $this->serializeThread($thread->load(['user:id,name,email']), $request->user()),
            'server_time' => now()->toIso8601String(),
        ]);
    }

    public function storeMessage(Request $request, int $id): JsonResponse
    {
        $thread = $this->findAccessibleThread($request, $id);

        $validated = $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        $record = $this->chat->sendMessage($thread, $request->user(), $validated['message']);

        return response()->json([
            'message' => 'Message sent.',
            'data' => $this->serializeMessage($record->load(['user:id,name']), $request->user()),
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

    protected function serializeThread(SupportThread $thread, $viewer): array
    {
        return [
            'id' => $thread->id,
            'title' => $thread->title,
            'description' => $thread->description,
            'status' => $thread->status,
            'user_id' => $thread->user_id,
            'user_name' => $thread->user?->name,
            'user_email' => $thread->user?->email,
            'unread_count' => (int) ($thread->unread_count ?? $this->chat->unreadCountForThread($thread, $viewer)),
            'created_at' => $thread->created_at?->format('M j, Y g:i A'),
            'created_at_iso' => $thread->created_at?->toIso8601String(),
        ];
    }

    protected function serializeMessage(SupportMessage $message, $viewer): array
    {
        $isMine = (int) $message->user_id === (int) $viewer->id;

        return [
            'id' => $message->id,
            'support_thread_id' => $message->support_thread_id,
            'user_id' => $message->user_id,
            'user_name' => $message->user?->name ?? 'User',
            'message' => $message->message,
            'is_read' => (bool) $message->is_read,
            'is_mine' => $isMine,
            'is_admin' => tenant_user_has_admin_role($message->user),
            'created_at' => $message->created_at?->format('M j, Y g:i A'),
            'created_at_iso' => $message->created_at?->toIso8601String(),
        ];
    }
}
