<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\PanelNotification;
use Illuminate\Support\Collection;

class TenantNotificationService
{
    public static function notifyAdmins(
        string $title,
        string $message,
        ?string $url = null,
        string $type = 'info',
        array $channels = ['database', 'mail'],
    ): void {
        foreach (self::adminRecipients() as $admin) {
            $admin->notify(new PanelNotification($title, $message, $url, $type, $channels));
        }
    }

    /** In-app bell only (no duplicate email). */
    public static function notifyAdminsPanel(
        string $title,
        string $message,
        ?string $url = null,
        string $type = 'info',
        ?string $module = null,
        ?string $listKey = null,
    ): void {
        foreach (self::adminRecipients() as $admin) {
            $admin->notify(new PanelNotification($title, $message, $url, $type, ['database'], $module, $listKey));
        }
    }

    public static function notifyUser(
        User $user,
        string $title,
        string $message,
        ?string $url = null,
        string $type = 'info',
        array $channels = ['database', 'mail'],
    ): void {
        $user->notify(new PanelNotification($title, $message, $url, $type, $channels));
    }

    /** @return Collection<int, User> */
    protected static function adminRecipients(): Collection
    {
        try {
            $admins = User::role('Admin')->get();
            if ($admins->isNotEmpty()) {
                return $admins;
            }
        } catch (\Throwable) {
            // Role may not exist in this tenant.
        }

        return User::where('is_super_user', 1)->get();
    }
}
