<?php

namespace App\Services;

use App\Models\ManageEmailsContent;
use App\Models\Order;
use App\Models\Quote;
use App\Models\ShippingQuote;
use App\Models\StockCheckRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class OrderWorkspaceNotificationService
{
    public function __construct(
        protected TenantEmailService $emails,
        protected OrderWorkspaceShippingService $shipping,
    ) {}

    public function sendShippingQuoteEmails(ShippingQuote $record, User $user, array $shippingCosts): void
    {
        $emailData = $this->buildQuoteEmailData($record, $user, $shippingCosts, $record->id);

        try {
            $this->emails->sendToAdmin(
                ManageEmailsContent::SLUG_SHIPPING_ADMIN,
                ['USERNAME' => $emailData['ship_to_name']],
                'shipping_quote_workspace',
                ['email_data' => $emailData]
            );
            if ($user->email) {
                $this->emails->send(
                    ManageEmailsContent::SLUG_SHIPPING_USER,
                    $user->email,
                    ['USERNAME' => $emailData['ship_to_name']],
                    'shipping_quote_workspace',
                    ['email_data' => $emailData]
                );
            }
        } catch (\Throwable $e) {
            Log::warning('Shipping quote email failed: '.$e->getMessage());
        }

        $this->notifyAdminsShippingQuote($record, $user);
        TenantNotificationService::shippingQuoteRequestedForUser($record, $user);
    }

    public function sendOrderPlacedEmails(Order $order, User $user, array $checkoutTotals, array $cartData): void
    {
        $invoiceId = (string) $order->id;
        $macros = [
            'USERNAME' => $cartData['bill_to_name'] ?? $user->name,
            'INVOICE' => $invoiceId,
        ];
        $partialData = [
            'order' => $order,
            'cartData' => $cartData,
            'totals' => $checkoutTotals,
            'user' => $user,
        ];

        try {
            $this->emails->send(
                ManageEmailsContent::SLUG_ORDER_USER,
                $user->email,
                $macros,
                'order_workspace_invoice',
                $partialData
            );
            $this->emails->sendToAdmin(
                ManageEmailsContent::SLUG_ORDER_ADMIN,
                $macros,
                'order_workspace_invoice',
                $partialData
            );
            $this->emails->sendToAdmin(
                ManageEmailsContent::SLUG_ORDER_WAREHOUSE,
                $macros,
                'order_workspace_invoice',
                $partialData
            );

            $repId = $cartData['rep_id'] ?? null;
            if ($repId) {
                $rep = User::query()->find($repId);
                if ($rep?->email) {
                    $repMacros = array_merge($macros, ['REPRESENTATIVE' => $rep->name]);
                    $this->emails->send(
                        ManageEmailsContent::SLUG_ORDER_REP,
                        $rep->email,
                        $repMacros,
                        'order_workspace_invoice',
                        $partialData
                    );
                }
            }
        } catch (\Throwable $e) {
            Log::warning('Order placed email failed: '.$e->getMessage());
        }

        TenantNotificationService::orderPlacedForUser($order, $user);
        TenantNotificationService::orderPlacedForAdmins($order, $user);
    }

    public function sendQuoteSavedEmails(Quote $quote, User $user, array $payload): void
    {
        TenantNotificationService::quoteSavedForUser($quote, $user);
        TenantNotificationService::quoteSavedForAdmins($quote, $user);

        if (! $user->email) {
            return;
        }

        try {
            $this->emails->send(
                ManageEmailsContent::SLUG_ORDER_USER,
                $user->email,
                [
                    'USERNAME' => $user->name,
                    'INVOICE' => (string) $quote->id,
                ],
                'order_workspace_quote',
                ['quote' => $quote, 'payload' => $payload, 'user' => $user]
            );
            $this->emails->sendToAdmin(
                ManageEmailsContent::SLUG_ORDER_ADMIN,
                [
                    'USERNAME' => $user->name,
                    'INVOICE' => (string) $quote->id,
                ],
                'order_workspace_quote',
                ['quote' => $quote, 'payload' => $payload, 'user' => $user]
            );
        } catch (\Throwable $e) {
            Log::warning('Quote saved email failed: '.$e->getMessage());
        }
    }

    public function sendStockCheckEmails(StockCheckRequest $record, User $user, array $shippingCosts, bool $withShipping): void
    {
        $emailData = $this->buildQuoteEmailData($record, $user, $shippingCosts, $record->id);
        $emailData['is_shipping_required'] = $withShipping ? 1 : 0;
        $emailData['is_updated'] = 0;

        try {
            $this->emails->sendToAdmin(
                ManageEmailsContent::SLUG_STOCK_ADMIN,
                ['USERNAME' => $emailData['ship_to_name']],
                'stock_check_workspace',
                ['email_data' => $emailData]
            );
            if ($user->email) {
                $this->emails->send(
                    ManageEmailsContent::SLUG_STOCK_USER,
                    $user->email,
                    ['USERNAME' => $emailData['ship_to_name']],
                    'stock_check_workspace',
                    ['email_data' => $emailData]
                );
            }
        } catch (\Throwable $e) {
            Log::warning('Stock check email failed: '.$e->getMessage());
        }

        $this->notifyAdminsStockCheck($record, $user, $withShipping);
        TenantNotificationService::stockCheckSubmittedForUser($record, $user, $withShipping);
    }

    protected function notifyAdminsShippingQuote(ShippingQuote $record, User $user): void
    {
        try {
            TenantNotificationService::notifyAdminsPanel(
                'Shipping quote requested',
                sprintf('New shipping quote request from %s — "%s"', $user->name ?? 'Customer', $record->job_name ?? 'Job'),
                $this->safeRoute('tenant_shipping_quotes_show', $record->id, 'tenant_shipping_quotes_index'),
                'warning',
                'shipping',
                'shipping_quotes_list',
            );
        } catch (\Throwable $e) {
            Log::warning('Shipping quote panel notification failed: '.$e->getMessage());
        }
    }

    protected function notifyAdminsStockCheck(Model $record, User $user, bool $withShipping): void
    {
        try {
            $suffix = $withShipping ? ' (includes shipping)' : '';
            TenantNotificationService::notifyAdminsPanel(
                'Stock check requested',
                sprintf('New stock check from %s%s', $user->name ?? 'Customer', $suffix),
                $this->safeRoute('tenant_stock_check_show', $record->id, 'tenant_stock_check_index'),
                'warning',
                'stock',
                'stock_check_list',
            );
        } catch (\Throwable $e) {
            Log::warning('Stock check panel notification failed: '.$e->getMessage());
        }
    }

    protected function safeRoute(string $preferred, int|string $id, string $fallback): ?string
    {
        try {
            if (Route::has($preferred)) {
                return route($preferred, $id);
            }
        } catch (\Throwable) {
            // ignore
        }

        try {
            return route($fallback);
        } catch (\Throwable) {
            return null;
        }
    }

    /**
     * @param  ShippingQuote|StockCheckRequest  $record
     * @return array<string, mixed>
     */
    public function stockCheckEmailData(Model $record, User $user, array $shippingCosts, int $quoteId): array
    {
        return $this->buildQuoteEmailData($record, $user, $shippingCosts, $quoteId);
    }

    /**
     * @param  ShippingQuote|StockCheckRequest  $record
     */
    protected function buildQuoteEmailData(Model $record, User $user, array $shippingCosts, int $quoteId): array
    {
        $user->loadMissing(['country', 'state']);
        $addresses = app(OrderWorkspaceCheckoutService::class)->billShipAddresses($user);

        $assembleYes = in_array($record->assemble_cabinets_check, ['yes', '1', 1], true);

        return array_merge($addresses, [
            'user_id' => $user->id,
            'job_name' => $record->job_name,
            'order_comment' => $record->comment ?? '',
            'room_data' => json_encode($record->rooms ?? []),
            'cart_product_weight' => ($record->sub_total_weight ?? '0').' lbs',
            'all_cart_total' => $record->sub_total_cost ?? 0,
            'is_assemble' => $assembleYes ? 1 : 2,
            'order_shipping_cost' => $shippingCosts['shipping_cost'] ?? 0,
            'ship_quote_id' => $quoteId,
            'created_at' => $record->created_at?->format('Y-m-d H:i:s') ?? now()->format('Y-m-d H:i:s'),
            'is_shipping_updated' => 0,
            'delivery_type' => $shippingCosts['delivery_type'] ?? 0,
            'unload_type' => $shippingCosts['unload_type'] ?? 0,
            'delivery_cost' => $shippingCosts['delivery_cost'] ?? 0,
            'liftgate_cost' => $shippingCosts['liftgate_cost'] ?? 0,
            'unload_cost' => $shippingCosts['unload_cost'] ?? 0,
            'total_pallets' => $shippingCosts['total_pallets'] ?? 1,
            'miscellneous_charges' => 0,
            'shipping_cost' => $shippingCosts['shipping_cost'] ?? 0,
        ]);
    }
}
