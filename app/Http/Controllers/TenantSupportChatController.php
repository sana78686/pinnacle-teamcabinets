<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class TenantSupportChatController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless(tenant_user_has_admin_role($request->user()), 403);

        return view('tenants.support_chat.index', [
            'vueConfig' => $this->vueConfig($request, true),
        ]);
    }

    public function userIndex(Request $request): View|\Illuminate\Http\RedirectResponse
    {
        if (tenant_user_has_admin_role($request->user())) {
            return redirect()->route('tenant_support_chat_index', $request->only('thread'));
        }

        return view('tenants.support_chat.user', [
            'vueConfig' => $this->vueConfig($request, false),
        ]);
    }

    protected function vueConfig(Request $request, bool $isAdmin): array
    {
        $initialThread = (int) $request->query('thread', 0);

        return [
            'isAdmin' => $isAdmin,
            'csrf' => csrf_token(),
            'initialThreadId' => $initialThread > 0 ? $initialThread : null,
            'pollMs' => (int) config('tenant_panel.support_chat_poll_ms', 4000),
            'currentUserId' => $request->user()->id,
            'fullPageUrl' => route('tenant_support_chat_user'),
            'api' => self::apiRoutes(),
        ];
    }

    public static function userWidgetConfig(Request $request): array
    {
        return [
            'isAdmin' => false,
            'csrf' => csrf_token(),
            'pollMs' => (int) config('tenant_panel.support_chat_poll_ms', 4000),
            'currentUserId' => $request->user()->id,
            'fullPageUrl' => route('tenant_support_chat_user'),
            'api' => self::apiRoutes(),
        ];
    }

    protected static function apiRoutes(): array
    {
        return [
            'threads' => route('tenant_support_chat_api_threads'),
            'currentThread' => route('tenant_support_chat_api_current_thread'),
            'chatUsers' => route('tenant_support_chat_api_users'),
            'storeThread' => route('tenant_support_chat_api_threads_store'),
            'messages' => route('tenant_support_chat_api_messages', ['id' => '__ID__']),
            'sendMessage' => route('tenant_support_chat_api_send', ['id' => '__ID__']),
            'markRead' => route('tenant_support_chat_api_read', ['id' => '__ID__']),
            'destroyMessage' => route('tenant_support_chat_api_message_destroy', ['id' => '__ID__']),
            'destroyThread' => route('tenant_support_chat_api_thread_destroy', ['id' => '__ID__']),
            'unreadCount' => route('tenant_support_chat_api_unread'),
        ];
    }
}
