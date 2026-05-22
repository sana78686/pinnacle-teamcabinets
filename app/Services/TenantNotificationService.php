<?php

namespace App\Services;

use App\Models\SiteSetting;
use App\Models\User;
use App\Notifications\PanelNotification;
use Illuminate\Support\Collection;

class TenantNotificationService
{
    /**
     * Locker-style: new bell entry on every login; toast on first page after redirect.
     *
     * @return array<int, string> Notification IDs to show as toasts on load
     */
    public static function notifyOnLogin(User $user): array
    {
        $countBefore = $user->notifications()->count();

        $user->notify(new PanelNotification(
            'Login',
            'Successfully logged in.',
            route('tenant_dashboard', [], false),
            'success',
            ['database'],
            'auth',
        ));

        if (self::userIsAdmin($user) && ! SiteSetting::query()->exists()) {
            $user->notify(self::welcomeNotification());
        }

        $created = $user->notifications()->count() - $countBefore;

        return $user->notifications()
            ->latest()
            ->take(max($created, 1))
            ->pluck('id')
            ->all();
    }

    /** @deprecated Use notifyOnLogin; kept for registration before first sign-in */
    public static function notifyWelcomePanelIfNeeded(): void
    {
        if (SiteSetting::query()->exists()) {
            return;
        }

        foreach (self::adminRecipients() as $admin) {
            if ($admin->notifications()->where('data->list_key', 'pinnacle_welcome')->exists()) {
                continue;
            }
            $admin->notify(self::welcomeNotification());
        }
    }

    protected static function welcomeNotification(): PanelNotification
    {
        $title = (string) config('pinnacle.portal.dashboard_welcome_title', 'Welcome to Pinnacle');
        $body = (string) config('pinnacle.portal.dashboard_welcome_body', '');
        $trialEnds = tenant('trial_ends_at');
        $trialLabel = $trialEnds
            ? $trialEnds->format('M j, Y')
            : (config('pinnacle.trial_days', 14).' days');
        $support = (string) config('pinnacle.support_email', '');

        $message = trim($body);
        $message .= ' Trial ends: '.$trialLabel.'.';
        if ($support !== '') {
            $message .= ' Support: '.$support;
        }

        return new PanelNotification(
            $title,
            $message,
            route('tenant_site_setting', [], false),
            'info',
            ['database'],
            'settings',
        );
    }

    protected static function userIsAdmin(User $user): bool
    {
        if ((int) ($user->is_super_user ?? 0) === 1) {
            return true;
        }

        try {
            return $user->hasRole('Admin');
        } catch (\Throwable) {
            return false;
        }
    }

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
