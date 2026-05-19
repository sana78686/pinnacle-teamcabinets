<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Services\TenantSubscriptionService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\Webhook;

class StripeCheckoutController extends Controller
{
    public function __construct(
        protected TenantSubscriptionService $subscriptions
    ) {}

    public function checkout(Request $request): RedirectResponse
    {
        $tenant = tenant();

        if (! $tenant) {
            abort(404);
        }

        $secret = config('services.stripe.secret');
        $priceId = config('services.stripe.price_id');

        if (! $secret || ! $priceId) {
            return back()->with('error', 'Stripe is not configured. Contact support.');
        }

        Stripe::setApiKey($secret);

        if (! $tenant->stripe_customer_id) {
            $customer = \Stripe\Customer::create([
                'email' => $tenant->email,
                'name' => $tenant->company_name,
                'metadata' => ['tenant_id' => $tenant->id],
            ]);
            $tenant->update(['stripe_customer_id' => $customer->id]);
        }

        $session = Session::create([
            'customer' => $tenant->stripe_customer_id,
            'mode' => 'subscription',
            'line_items' => [[
                'price' => $priceId,
                'quantity' => 1,
            ]],
            'success_url' => tenant_url($tenant->id, 'billing/success?session_id={CHECKOUT_SESSION_ID}'),
            'cancel_url' => tenant_url($tenant->id, 'billing/cancel'),
            'metadata' => ['tenant_id' => $tenant->id],
        ]);

        return redirect()->away($session->url);
    }

    public function success(Request $request): RedirectResponse
    {
        $tenant = tenant();
        if ($tenant && $this->subscriptions->hasAccess($tenant)) {
            return redirect()->route('tenant_dashboard')
                ->with('success', 'Thank you! Your subscription is active.');
        }

        return redirect()->route('tenant.subscription.required')
            ->with('success', 'Payment received. Access will activate shortly.');
    }

    public function cancel(): RedirectResponse
    {
        return redirect()->route('tenant.subscription.required')
            ->with('error', 'Checkout was cancelled.');
    }

    public function webhook(Request $request): Response
    {
        $secret = config('services.stripe.webhook_secret');
        $payload = $request->getContent();
        $sig = $request->header('Stripe-Signature');

        try {
            $event = $secret
                ? Webhook::constructEvent($payload, $sig, $secret)
                : json_decode($payload, false, 512, JSON_THROW_ON_ERROR);
        } catch (\Throwable $e) {
            Log::warning('Stripe webhook error: '.$e->getMessage());

            return response('Invalid payload', 400);
        }

        $type = is_object($event) && isset($event->type) ? $event->type : null;
        $object = $event->data->object ?? null;

        if ($type === 'checkout.session.completed' && $object) {
            $this->handleCheckoutCompleted($object);
        }

        if (in_array($type, ['customer.subscription.updated', 'customer.subscription.created'], true) && $object) {
            $this->handleSubscriptionUpdated($object);
        }

        if ($type === 'customer.subscription.deleted' && $object) {
            $this->handleSubscriptionDeleted($object);
        }

        return response('OK', 200);
    }

    protected function handleCheckoutCompleted(object $session): void
    {
        $tenantId = $session->metadata->tenant_id ?? null;
        if (! $tenantId) {
            return;
        }

        $tenant = Tenant::find($tenantId);
        if (! $tenant) {
            return;
        }

        $tenant->update([
            'stripe_customer_id' => $session->customer ?? $tenant->stripe_customer_id,
            'stripe_subscription_id' => $session->subscription ?? $tenant->stripe_subscription_id,
        ]);

        $this->subscriptions->markPaid($tenant);
    }

    protected function handleSubscriptionUpdated(object $subscription): void
    {
        $tenant = Tenant::where('stripe_subscription_id', $subscription->id)
            ->orWhere('stripe_customer_id', $subscription->customer ?? null)
            ->first();

        if (! $tenant) {
            return;
        }

        $endsAt = isset($subscription->current_period_end)
            ? Carbon::createFromTimestamp($subscription->current_period_end)
            : null;

        $status = $subscription->status ?? 'active';

        if (in_array($status, ['active', 'trialing'], true)) {
            $tenant->update([
                'stripe_subscription_id' => $subscription->id,
                'subscription_status' => TenantSubscriptionService::STATUS_ACTIVE,
                'subscription_ends_at' => $endsAt,
                'is_complimentary' => false,
            ]);
        } elseif ($status === 'past_due') {
            $tenant->update(['subscription_status' => TenantSubscriptionService::STATUS_PAST_DUE]);
        } else {
            $tenant->update(['subscription_status' => TenantSubscriptionService::STATUS_EXPIRED]);
        }
    }

    protected function handleSubscriptionDeleted(object $subscription): void
    {
        $tenant = Tenant::where('stripe_subscription_id', $subscription->id)->first();
        if ($tenant) {
            $tenant->update([
                'subscription_status' => TenantSubscriptionService::STATUS_EXPIRED,
                'stripe_subscription_id' => null,
            ]);
        }
    }
}
