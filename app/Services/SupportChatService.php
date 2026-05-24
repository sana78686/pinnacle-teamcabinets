<?php

namespace App\Services;

use App\Models\SupportMessage;
use App\Models\SupportThread;
use App\Models\User;
use App\Notifications\PanelNotification;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;

class SupportChatService
{
    public function findUserThread(User $user): ?SupportThread
    {
        return SupportThread::query()
            ->where('user_id', $user->id)
            ->latest('id')
            ->first();
    }

    public function getOrCreateUserThread(User $user): SupportThread
    {
        return $this->findUserThread($user) ?? $this->createThread($user, 'Support Chat', null);
    }

    public function getOrCreateThreadForUser(User $user): SupportThread
    {
        return $this->getOrCreateUserThread($user);
    }

    public function createThread(User $user, ?string $title = null, ?string $description = null): SupportThread
    {
        return SupportThread::query()->create([
            'user_id' => $user->id,
            'title' => $title ?: 'Support request',
            'description' => $description,
            'status' => 1,
        ]);
    }

    public function sendMessage(
        SupportThread $thread,
        User $sender,
        ?string $message,
        ?string $attachmentPath = null,
        ?string $attachmentName = null,
    ): SupportMessage {
        $body = trim((string) $message);

        $record = SupportMessage::query()->create([
            'support_thread_id' => $thread->id,
            'user_id' => $sender->id,
            'message' => $body,
            'attachment_path' => $attachmentPath,
            'attachment_name' => $attachmentName,
            'is_read' => false,
        ]);

        $this->notifyRecipients($thread, $sender, $record);

        return $record;
    }

    public function storeAttachment(UploadedFile $file): array
    {
        $filename = time().'_'.preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
        $dir = public_path('uploads/support_chat');
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $file->move($dir, $filename);

        return [
            'path' => 'uploads/support_chat/'.$filename,
            'name' => $file->getClientOriginalName(),
        ];
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

        $preview = $record->attachment_name
            ? sprintf('Sent a file: %s', $record->attachment_name)
            : \Illuminate\Support\Str::limit((string) $record->message, 120);

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
