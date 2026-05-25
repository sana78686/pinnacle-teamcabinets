<?php

namespace App\Services;

use App\Models\ClaimsOrder;
use App\Models\ManageEmailsContent;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductSection;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class ClaimWorkspaceService
{
    public function __construct(
        protected TenantEmailService $emails,
    ) {}

    public function orderEligibleForClaim(Order $order): bool
    {
        $status = strtoupper((string) ($order->status ?? ''));

        return in_array($status, ['PAID', 'COMPLETED'], true);
    }

    public function userMayAccess(ClaimsOrder $claim, User $user): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return (int) $claim->claims_order_user_id === (int) $user->id;
    }

    public function listQuery(User $user): Builder
    {
        $query = ClaimsOrder::query()
            ->with(['order', 'claimant'])
            ->orderByDesc('id');

        if ($user->isAdmin()) {
            return $query;
        }

        return $query->where('claims_order_user_id', $user->id);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function buildClaimLineOptions(Order $order): array
    {
        $lines = [];
        foreach ($order->rooms ?? [] as $room) {
            $roomName = $room['room_name'] ?? 'Room';
            foreach ($room['products'] ?? [] as $line) {
                $product = ! empty($line['product_id'])
                    ? Product::query()->with('doorColor')->find($line['product_id'])
                    : null;
                $sku = $line['sku'] ?? $product?->sku ?? '';
                if ($sku === '') {
                    continue;
                }
                $unitCost = (float) ($line['cost'] ?? 0);
                if ($unitCost <= 0 && $product) {
                    $unitCost = (float) preg_replace('/[^\d.]/', '', (string) $product->cost);
                }
                $weight = (float) ($line['weight'] ?? 0);
                if ($weight <= 0 && $product) {
                    $weight = (float) preg_replace('/[^\d.]/', '', (string) $product->weight);
                }
                $sectionName = $product?->product_section_id
                    ? (ProductSection::query()->whereKey($product->product_section_id)->value('name') ?? '')
                    : '';

                $lines[] = [
                    'room' => $roomName,
                    'sku' => $sku,
                    'weight' => $weight,
                    'cost' => $unitCost,
                    'cabinets_id' => (string) ($product?->product_section_id ?? ''),
                    'section_name' => $sectionName,
                    'product_name' => $product?->label ?? $sku,
                    'product_color' => $product?->doorColor?->product_label ?? '',
                    'product_description' => trim($sku.' — '.($product?->label ?? '')),
                    'checkbox_val1' => ! empty($line['checkbox_val1']) ? '1' : '0',
                    'checkbox_val2' => ! empty($line['checkbox_val2']) ? '1' : '0',
                    'payload' => [
                        'room' => $roomName,
                        'sku' => $sku,
                        'weight' => $weight,
                        'cost' => $unitCost,
                        'cabinets_id' => (string) ($product?->product_section_id ?? ''),
                        'product_name' => $product?->label ?? $sku,
                        'product_color' => $product?->doorColor?->product_label ?? '',
                        'product_description' => trim($sku.' — '.($product?->label ?? '')),
                        'checkbox_val1' => ! empty($line['checkbox_val1']) ? '1' : '0',
                        'checkbox_val2' => ! empty($line['checkbox_val2']) ? '1' : '0',
                    ],
                ];
            }
        }

        return $lines;
    }

    /**
     * @param  array<int, string>  $selectedPayloads  JSON strings from checkboxes
     * @param  array<string, array<int, UploadedFile>>  $imageFiles  keyed by sku
     * @return array<int, array<string, mixed>>
     */
    public function parseSelectedProducts(array $selectedPayloads, array $imageFiles): array
    {
        $products = [];
        foreach ($selectedPayloads as $json) {
            $row = json_decode($json, true);
            if (! is_array($row) || empty($row['sku'])) {
                continue;
            }
            $sku = $row['sku'];
            $images = [];
            foreach ($imageFiles[$sku] ?? [] as $file) {
                if ($file instanceof UploadedFile && $file->isValid()) {
                    $stored = $this->storeClaimImage($file);
                    if ($stored) {
                        $images[] = $stored;
                    }
                }
            }
            $row['image'] = implode(',', $images);
            $products[] = $row;
        }

        return $products;
    }

    public function storeClaim(Order $order, User $user, string $message, array $products): ClaimsOrder
    {
        $claim = ClaimsOrder::query()->create([
            'claims_product_val' => $products,
            'claims_order_message' => $message,
            'claims_order_image' => null,
            'claims_order_id' => $order->id,
            'claims_order_user_id' => $user->id,
            'is_viewed' => false,
        ]);

        $this->sendClaimEmails($claim, $order, $user);
        $this->notifyAdminsNewClaim($claim, $order, $user);

        return $claim;
    }

    protected function storeClaimImage(UploadedFile $file): ?string
    {
        $name = time().'_'.preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
        $path = $file->storeAs('claims', $name, 'public');

        return $path ? basename($path) : null;
    }

    public function claimImageUrl(?string $filename): ?string
    {
        if (! $filename) {
            return null;
        }

        if (Storage::disk('public')->exists('claims/'.$filename)) {
            return Storage::disk('public')->url('claims/'.$filename);
        }

        return asset('assets/claims_img/'.$filename);
    }

    /**
     * @return array<string, mixed>
     */
    public function emailClaimsData(ClaimsOrder $claim, Order $order, User $user): array
    {
        return [
            'claims_product_val' => $claim->claims_product_val ?? [],
            'claims_order_message' => $claim->claims_order_message,
            'claims_order_id' => $claim->claims_order_id,
            'claims_order_user_id' => $claim->claims_order_user_id,
            'job_name' => $order->job_name,
            'user' => $user,
        ];
    }

    protected function sendClaimEmails(ClaimsOrder $claim, Order $order, User $user): void
    {
        $claimsData = $this->emailClaimsData($claim, $order, $user);
        $macros = ['USERNAME' => $user->name ?? 'Customer'];

        try {
            $this->emails->sendToAdmin(
                ManageEmailsContent::SLUG_CLAIM_ADMIN,
                $macros,
                'claims',
                ['claims_data' => $claimsData, 'claim' => $claim]
            );
            if ($user->email) {
                $this->emails->send(
                    ManageEmailsContent::SLUG_CLAIM_USER,
                    $user->email,
                    $macros,
                    'user_claims',
                    ['claims_data' => $claimsData, 'claim' => $claim]
                );
            }
        } catch (\Throwable $e) {
            Log::warning('Claim email failed: '.$e->getMessage());
        }
    }

    protected function notifyAdminsNewClaim(ClaimsOrder $claim, Order $order, User $user): void
    {
        try {
            $url = Route::has('tenant_claim_show')
                ? route('tenant_claim_show', $claim->id)
                : route('tenant_claim_index');

            TenantNotificationService::notifyAdminsPanel(
                'New claim submitted',
                sprintf('%s filed a claim on order #%d — %s.', $user->name ?? 'Customer', $order->id, $order->job_name ?? 'Order'),
                $url,
                'warning',
                'claims',
                'claims_list',
            );
        } catch (\Throwable $e) {
            Log::warning('Claim panel notification failed: '.$e->getMessage());
        }
    }

    public function representativeNameFor(ClaimsOrder $claim): string
    {
        $order = $claim->order;
        if (! $order?->user) {
            return '—';
        }

        $customer = $order->user;
        if ($customer->parent_id) {
            $parent = User::query()->find($customer->parent_id);
            if ($parent && $parent->hasRole('representatives')) {
                return $parent->name ?? '—';
            }
        }

        return $customer->name ?? '—';
    }
}
