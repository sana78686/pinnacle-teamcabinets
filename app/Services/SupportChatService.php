<?php

namespace App\Services;

use App\Models\SupportMessage;
use App\Models\SupportThread;
use App\Models\User;
use App\Notifications\PanelNotification;
use Illuminate\Support\Facades\Schema;

class SupportChatService
{
    public function createThread(User $user, ?string $title = null, ?string $description = null): SupportThread
    {
        return SupportThread::query()->create([
            'user_id' => $user->id,
            'title' => $title ?: 'Support request',
            'description' => $description,
            'status' => 1,
        ]);
    }

    public function sendMessage(SupportThread $thread, User $sender, string $message): SupportMessage
    {
        $record = SupportMessage::query()->create([
            'support_thread_id' => $thread->id,
            'user_id' => $sender->id,
            'message' => trim($message),
            'is_read' => false,
        ]);

        $this->notifyRecipients($thread, $sender, $record);

        return $record;
    }

    public function markThreadRead(SupportThread $thread, User $viewer): void
    {
        SupportMessage::query()
            ->where('support_thread_id', $thread->id)
            ->where('user_id', '!=', $viewer->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $this->markSupportNotificationsRead($viewer, $thread);
    }

    public function unreadCountForUser(User $user): int
    {
        if (! Schema::hasTable('support_messages')) {
            return 0;
        }

        $query = SupportMessage::query()->where('is_read', false);

        if (tenant_user_has_admin_role($user)) {
            return (int) $query
                ->where('user_id', '!=', $user->id)
                ->count();
        }

        return (int) $query
            ->whereHas('thread', fn ($q) => $q->where('user_id', $user->id))
            ->where('user_id', '!=', $user->id)
            ->count();
    }

    public function unreadCountForThread(SupportThread $thread, User $viewer): int
    {
        return (int) SupportMessage::query()
            ->where('support_thread_id', $thread->id)
            ->where('user_id', '!=', $viewer->id)
            ->where('is_read', false)
            ->count();
    }

    protected function notifyRecipients(SupportThread $thread, User $sender, SupportMessage $record): void
    {
        if (! Schema::hasTable('notifications')) {
            return;
        }

        $preview = \Illuminate\Support\Str::limit($record->message, 120);

        if (tenant_user_has_admin_role($sender)) {
            $recipient = $thread->user;
            if (! $recipient) {
                return;
            }

            $recipient->notify(new PanelNotification(
                'Support reply',
                sprintf('Admin replied: %s', $preview),
                route('tenant_support_chat_user', [], false).'?thread='.$thread->id,
                'info',
                ['database'],
                'support_chat',
                'support_chat_list',
            ));

            return;
        }

        TenantNotificationService::notifyAdminsPanel(
            'New support message',
            sprintf('%s: %s', $sender->name, $preview),
            route('tenant_support_chat_index', [], false).'?thread='.$thread->id,
            'info',
            'support_chat',
            'support_chat_list',
        );
    }

    protected function markSupportNotificationsRead(User $viewer, SupportThread $thread): void
    {
        if (! Schema::hasTable('notifications')) {
            return;
        }

        foreach ($viewer->unreadNotifications()->get() as $notification) {
            $data = $notification->data;
            if (($data['module'] ?? null) !== 'support_chat') {
                continue;
            }

            $url = (string) ($data['url'] ?? '');
            if ($url !== '' && str_contains($url, '/'.$thread->id)) {
                $notification->markAsRead();
            }
        }
    }
}
