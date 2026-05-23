<?php

namespace App\Http\Controllers;

use App\Services\TenantNavBadgeService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TenantNotificationController extends Controller
{
    public function __construct(
        protected TenantNavBadgeService $navBadges,
    ) {}
    public function index(Request $request)
    {
        $notifications = $request->user()->notifications()->latest()->paginate(tenant_list_per_page())->withQueryString();

        return view('tenants.notifications.index', compact('notifications'));
    }

    public function poll(Request $request): JsonResponse
    {
        $user = $request->user();
        $sinceRaw = $request->query('since');

        $unreadCount = $user->unreadNotifications()->count();
        $dropdown = $user->unreadNotifications()->latest()->take(20)->get();

        $newItems = collect();
        if ($sinceRaw) {
            try {
                $since = Carbon::parse($sinceRaw);
                $newItems = $user->unreadNotifications()
                    ->where('created_at', '>', $since)
                    ->latest()
                    ->take(10)
                    ->get();
            } catch (\Throwable) {
                $newItems = collect();
            }
        }

        $map = fn ($n) => [
            'id' => $n->id,
            'title' => $n->data['title'] ?? 'Notification',
            'message' => $n->data['message'] ?? '',
            'url' => $n->data['url'] ?? null,
            'type' => $n->data['type'] ?? 'info',
            'module' => $n->data['module'] ?? null,
            'read_at' => $n->read_at?->toIso8601String(),
            'created_at' => $n->created_at->diffForHumans(),
            'created_at_iso' => $n->created_at->toIso8601String(),
        ];

        return response()->json([
            'unread_count' => $unreadCount,
            'notifications' => $dropdown->map($map)->values(),
            'new' => $newItems->map($map)->values(),
            'server_time' => now()->toIso8601String(),
            'nav_badges' => $this->navBadges->countsForUser($user),
        ]);
    }

    public function markRead(Request $request, string $id): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $notification = $request->user()->notifications()->where('id', $id)->first();
        $notification?->markAsRead();

        if ($request->expectsJson()) {
            $user = $request->user();

            return response()->json([
                'ok' => true,
                'unread_count' => $user->unreadNotifications()->count(),
                'nav_badges' => $this->navBadges->countsForUser($user),
            ]);
        }

        return back()->with('success', 'Notification marked as read.');
    }

    public function markAllRead(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->unreadNotifications->markAsRead();

        return response()->json([
            'ok' => true,
            'unread_count' => 0,
            'notifications' => [],
            'nav_badges' => $this->navBadges->countsForUser($user),
        ]);
    }
}
