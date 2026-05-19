<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TenantNotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()->notifications()->latest()->paginate(25);

        return view('tenants.notifications.index', compact('notifications'));
    }

    public function poll(Request $request): JsonResponse
    {
        $user = $request->user();
        $since = $request->query('since');

        $all = $user->notifications()->latest()->take(20)->get();
        $unreadCount = $user->unreadNotifications()->count();

        $newItems = collect();
        if ($since) {
            $newItems = $user->unreadNotifications()
                ->where('created_at', '>', $since)
                ->latest()
                ->take(10)
                ->get();
        }

        $map = fn ($n) => [
            'id' => $n->id,
            'title' => $n->data['title'] ?? 'Notification',
            'message' => $n->data['message'] ?? '',
            'url' => $n->data['url'] ?? null,
            'type' => $n->data['type'] ?? 'info',
            'read_at' => $n->read_at?->toIso8601String(),
            'created_at' => $n->created_at->diffForHumans(),
            'created_at_iso' => $n->created_at->toIso8601String(),
        ];

        return response()->json([
            'unread_count' => $unreadCount,
            'notifications' => $all->map($map)->values(),
            'new' => $newItems->map($map)->values(),
        ]);
    }

    public function markRead(Request $request, string $id): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $notification = $request->user()->notifications()->where('id', $id)->first();
        $notification?->markAsRead();

        if ($request->expectsJson()) {
            return response()->json([
                'ok' => true,
                'unread_count' => $request->user()->unreadNotifications()->count(),
            ]);
        }

        return back()->with('success', 'Notification marked as read.');
    }

    public function markAllRead(Request $request): JsonResponse
    {
        $request->user()->unreadNotifications->markAsRead();

        return response()->json([
            'ok' => true,
            'unread_count' => 0,
        ]);
    }
}
