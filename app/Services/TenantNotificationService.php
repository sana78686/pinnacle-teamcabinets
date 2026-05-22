<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Quote;
use App\Models\SiteSetting;
use App\Models\User;
use App\Notifications\PanelNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Mail + in-app panel notifications (CI parity).
 * Rule: business emails use Mailable / TenantEmailService; bell + toasts use PanelNotification (database only).
 */
class TenantNotificationService
{
    /**
     * Login success — in-app only (no email). Returns notification IDs for boot toasts.
     *
     * @return array<int, string>
     */
    public static function notifyOnLogin(User $user): array
    {
        $countBefore = $user->notifications()->count();

        $user->notify(new PanelNotification(
            'Welcome back',
            sprintf('Welcome back, %s! You are now logged in.', $user->name),
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

    /** Admin bell after self-service registration (mail sent separately). */
    public static function registrationPendingApproval(User $user): void
    {
        self::notifyAdminsPanel(
            'New user registration',
            sprintf('New registration from %s — pending approval', $user->name),
            route('tenant_user_index', ['verified' => 0], false),
            'info',
            'auth',
        );
    }

    public static function accountApproved(User $user): void
    {
        self::notifyUserPanel(
            $user,
            'Account approved',
            'Your account has been approved! You can now place orders.',
            route('tenant_dashboard', [], false),
            'success',
            'auth',
        );
    }

    public static function accountDeactivated(User $user): void
    {
        self::notifyUserPanel(
            $user,
            'Account deactivated',
            'Your account has been deactivated. Contact admin for details.',
            route('tenant_login', [], false),
            'danger',
            'auth',
        );
    }

    public static function accountCreatedByAdmin(User $user): void
    {
        self::notifyUserPanel(
            $user,
            'Welcome',
            'Your account has been set up. Please log in and change your password.',
            route('tenant_login', [], false),
            'success',
            'auth',
        );
    }

    public static function quoteSavedForUser(Quote $quote, User $user): void
    {
        $label = $quote->job_name ?? ('Quote #'.$quote->id);
        self::notifyUserPanel(
            $user,
            'Quote saved',
            sprintf('Quote "%s" saved successfully. View it in My Quotes.', $label),
            route('tenant_quotes_show', $quote->id, false),
            'info',
            'quotes',
        );
    }

    public static function quoteSavedForAdmins(Quote $quote, User $user): void
    {
        $label = $quote->job_name ?? ('Quote #'.$quote->id);
        self::notifyAdminsPanel(
            'New quote saved',
            sprintf('%s saved a new quote: "%s"', $user->name ?? 'A user', $label),
            route('tenant_quotes_show', $quote->id, false),
            'info',
            'quotes',
            'quotes_list',
        );
    }

    public static function shippingQuoteRequestedForUser(Model $record, User $user): void
    {
        $label = $record->job_name ?? ('Request #'.$record->id);
        self::notifyUserPanel(
            $user,
            'Shipping quote submitted',
            sprintf('Your shipping quote request for "%s" has been submitted successfully.', $label),
            route('tenant_shipping_quotes_show', $record->id, false),
            'warning',
            'shipping',
        );
    }

    public static function stockCheckSubmittedForUser(Model $record, User $user, bool $withShipping): void
    {
        $label = $record->job_name ?? ('Request #'.$record->id);
        $msg = $withShipping
            ? sprintf('Your stock check with shipping request for "%s" has been submitted.', $label)
            : sprintf('Your stock check request for "%s" has been submitted. We will contact you soon.', $label);

        self::notifyUserPanel(
            $user,
            'Stock check submitted',
            $msg,
            route('tenant_stock_check_show', $record->id, false),
            'warning',
            'stock',
        );
    }

    public static function orderPlacedForUser(Order $order, User $user): void
    {
        $total = number_format((float) ($order->grand_total_cost ?? 0), 2);
        self::notifyUserPanel(
            $user,
            'Order placed',
            sprintf('Order #%d placed successfully! Total: $%s. View your order in My Orders.', $order->id, $total),
            route('tenant_order_show', $order->id, false),
            'success',
            'orders',
        );
    }

    public static function orderPlacedForAdmins(Order $order, User $user): void
    {
        $total = number_format((float) ($order->grand_total_cost ?? 0), 2);
        self::notifyAdminsPanel(
            'New order placed',
            sprintf('New order #%d from %s — $%s', $order->id, $user->name ?? 'Customer', $total),
            route('tenant_order_show', $order->id, false),
            'success',
            'orders',
            'orders_list',
        );
    }

    /** Session flash → SweetAlert toast on next authenticated page (no email). */
    public static function flashToast(string $message, string $type = 'info', ?string $title = null, ?string $url = null): void
    {
        $existing = session('tenant_panel_toast_messages', []);
        $existing[] = [
            'title' => $title ?? match ($type) {
                'success' => 'Success',
                'warning' => 'Notice',
                'danger', 'error' => 'Alert',
                default => 'Notification',
            },
            'message' => $message,
            'type' => $type,
            'url' => $url,
        ];
        session()->flash('tenant_panel_toast_messages', $existing);
    }

    public static function notifyUserPanel(
        User $user,
        string $title,
        string $message,
        ?string $url = null,
        string $type = 'info',
        ?string $module = null,
    ): void {
        $user->notify(new PanelNotification($title, $message, $url, $type, ['database'], $module));
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
            'pinnacle_welcome',
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
        array $channels = ['database'],
    ): void {
        foreach (self::adminRecipients() as $admin) {
            $admin->notify(new PanelNotification($title, $message, $url, $type, $channels));
        }
    }

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
        array $channels = ['database'],
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
